<?php

/**
 * Google Sheets integration for CF7 lead forms.
 * Uses Service Account JWT auth — no Composer needed.
 *
 * Sheet mapping:
 *   Form ID 60   → "Contact Form"
 *   Form ID 61   → "Job Application"
 *   Form ID 6261 → "Case Study Download"
 */

define('NEAMOB_SHEETS_SPREADSHEET_ID', '1yU13MXl6lN4K88SS3Uo3YSzvsa7ImR0MjBzDZvH6L4w');
define('NEAMOB_SHEETS_CREDENTIALS_FILE', get_template_directory() . '/inc/google-sheets-credentials.json');

/**
 * Map CF7 form IDs to Google Sheet tab names.
 */
function neamob_sheets_get_sheet_name(int $form_id): ?string
{
    $map = [
        60   => 'Contact Form',
        61   => 'Job Application',
        6261 => 'Case Study Download',
    ];
    return $map[$form_id] ?? null;
}

/**
 * Fields to skip (CF7 internals, honeypots, etc.)
 */
function neamob_sheets_skip_field(string $key): bool
{
    $skip = ['_wpcf7', '_wpcf7_version', '_wpcf7_locale', '_wpcf7_unit_tag', '_wpcf7_container_post', '_wpcf7_posted_data_hash', 'g-recaptcha-response', '_wpnonce'];
    if (in_array($key, $skip, true)) {
        return true;
    }
    if (str_starts_with($key, '_')) {
        return true;
    }
    return false;
}

/**
 * Create a JWT and exchange it for a Google OAuth2 access token.
 */
function neamob_sheets_get_access_token(): ?string
{
    $creds_file = NEAMOB_SHEETS_CREDENTIALS_FILE;
    if (!file_exists($creds_file)) {
        error_log('[neamob-sheets] Credentials file not found: ' . $creds_file);
        return null;
    }

    $creds = json_decode(file_get_contents($creds_file), true);
    if (!$creds || $creds['type'] !== 'service_account') {
        error_log('[neamob-sheets] Invalid credentials file.');
        return null;
    }

    $now   = time();
    $scope = 'https://www.googleapis.com/auth/spreadsheets';

    $header  = neamob_sheets_base64url(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
    $payload = neamob_sheets_base64url(json_encode([
        'iss'   => $creds['client_email'],
        'scope' => $scope,
        'aud'   => 'https://oauth2.googleapis.com/token',
        'iat'   => $now,
        'exp'   => $now + 3600,
    ]));

    $signing_input = $header . '.' . $payload;

    $private_key = openssl_pkey_get_private($creds['private_key']);
    if (!$private_key) {
        error_log('[neamob-sheets] Failed to load private key.');
        return null;
    }

    $signature = '';
    if (!openssl_sign($signing_input, $signature, $private_key, 'SHA256')) {
        error_log('[neamob-sheets] Failed to sign JWT.');
        return null;
    }

    $jwt = $signing_input . '.' . neamob_sheets_base64url($signature);

    $response = wp_remote_post('https://oauth2.googleapis.com/token', [
        'timeout' => 15,
        'body'    => [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwt,
        ],
    ]);

    if (is_wp_error($response)) {
        error_log('[neamob-sheets] Token request error: ' . $response->get_error_message());
        return null;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (empty($body['access_token'])) {
        error_log('[neamob-sheets] No access token in response: ' . wp_remote_retrieve_body($response));
        return null;
    }

    return $body['access_token'];
}

function neamob_sheets_base64url(string $data): string
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
 * Ensure a sheet (tab) with the given name exists in the spreadsheet.
 * Returns the sheet ID or null on failure.
 */
function neamob_sheets_ensure_sheet(string $token, string $sheet_name): bool
{
    $spreadsheet_id = NEAMOB_SHEETS_SPREADSHEET_ID;

    // Get existing sheets
    $response = wp_remote_get(
        "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheet_id}?fields=sheets.properties",
        [
            'timeout' => 15,
            'headers' => ['Authorization' => 'Bearer ' . $token],
        ]
    );

    if (is_wp_error($response)) {
        error_log('[neamob-sheets] Failed to get spreadsheet info: ' . $response->get_error_message());
        return false;
    }

    $body   = json_decode(wp_remote_retrieve_body($response), true);
    $sheets = $body['sheets'] ?? [];

    foreach ($sheets as $sheet) {
        if ($sheet['properties']['title'] === $sheet_name) {
            return true; // already exists
        }
    }

    // Create the sheet
    $response = wp_remote_post(
        "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheet_id}:batchUpdate",
        [
            'timeout' => 15,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ],
            'body' => json_encode([
                'requests' => [
                    ['addSheet' => ['properties' => ['title' => $sheet_name]]],
                ],
            ]),
        ]
    );

    if (is_wp_error($response)) {
        error_log('[neamob-sheets] Failed to create sheet: ' . $response->get_error_message());
        return false;
    }

    return true;
}

/**
 * Get the first row (headers) of a sheet.
 */
function neamob_sheets_get_headers(string $token, string $sheet_name): array
{
    $spreadsheet_id = NEAMOB_SHEETS_SPREADSHEET_ID;
    $range          = urlencode($sheet_name . '!1:1');

    $response = wp_remote_get(
        "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheet_id}/values/{$range}",
        [
            'timeout' => 15,
            'headers' => ['Authorization' => 'Bearer ' . $token],
        ]
    );

    if (is_wp_error($response)) {
        return [];
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    return $body['values'][0] ?? [];
}

/**
 * Append a row to a sheet.
 */
function neamob_sheets_append_row(string $token, string $sheet_name, array $row): bool
{
    $spreadsheet_id = NEAMOB_SHEETS_SPREADSHEET_ID;
    $range          = urlencode($sheet_name . '!A1');

    $response = wp_remote_post(
        "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheet_id}/values/{$range}:append?valueInputOption=RAW&insertDataOption=INSERT_ROWS",
        [
            'timeout' => 15,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ],
            'body' => json_encode(['values' => [$row]]),
        ]
    );

    if (is_wp_error($response)) {
        error_log('[neamob-sheets] Failed to append row: ' . $response->get_error_message());
        return false;
    }

    $code = wp_remote_retrieve_response_code($response);
    if ($code !== 200) {
        error_log('[neamob-sheets] Append row HTTP ' . $code . ': ' . wp_remote_retrieve_body($response));
        return false;
    }

    return true;
}

/**
 * Main handler — called on wpcf7_mail_sent.
 */
function neamob_sheets_on_form_sent($contact_form): void
{
    $form_id    = (int) $contact_form->id();
    $sheet_name = neamob_sheets_get_sheet_name($form_id);

    if (!$sheet_name) {
        return; // form not mapped
    }

    $submission = WPCF7_Submission::get_instance();
    if (!$submission) {
        return;
    }

    $posted = $submission->get_posted_data();

    // Build field map: key => value (skip CF7 internals)
    $fields = [];
    foreach ($posted as $key => $value) {
        if (neamob_sheets_skip_field($key)) {
            continue;
        }
        $fields[$key] = is_array($value) ? implode(', ', $value) : (string) $value;
    }

    if (empty($fields)) {
        return;
    }

    $token = neamob_sheets_get_access_token();
    if (!$token) {
        return;
    }

    if (!neamob_sheets_ensure_sheet($token, $sheet_name)) {
        return;
    }

    $existing_headers = neamob_sheets_get_headers($token, $sheet_name);
    $form_keys        = array_keys($fields);

    // Add "Date" as first column if headers are being written fresh
    if (empty($existing_headers)) {
        $new_headers = array_merge(['Date'], $form_keys);
        neamob_sheets_append_row($token, $sheet_name, $new_headers);
        $existing_headers = $new_headers;
    } else {
        // Add any new columns that appeared
        $new_keys = array_diff($form_keys, $existing_headers);
        if ($new_keys) {
            $existing_headers = array_merge($existing_headers, array_values($new_keys));
            // Update header row
            $spreadsheet_id = NEAMOB_SHEETS_SPREADSHEET_ID;
            $range          = urlencode($sheet_name . '!1:1');
            wp_remote_request(
                "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheet_id}/values/{$range}?valueInputOption=RAW",
                [
                    'method'  => 'PUT',
                    'timeout' => 15,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Content-Type'  => 'application/json',
                    ],
                    'body' => json_encode(['values' => [$existing_headers]]),
                ]
            );
        }
    }

    // Build data row aligned to headers
    $row = [];
    foreach ($existing_headers as $col) {
        if ($col === 'Date') {
            $row[] = current_time('Y-m-d H:i:s');
        } else {
            $row[] = $fields[$col] ?? '';
        }
    }

    neamob_sheets_append_row($token, $sheet_name, $row);
}

add_action('wpcf7_mail_sent', 'neamob_sheets_on_form_sent');
