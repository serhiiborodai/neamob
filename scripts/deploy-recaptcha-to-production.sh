#!/usr/bin/env bash
# Deploy reCAPTCHA keys from local wp-config.php to neamob.com production.
# Usage: ./scripts/deploy-recaptcha-to-production.sh
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
LOCAL_CONFIG="$ROOT/wp-config.php"
SSH_KEY="${SSH_KEY:-$HOME/.ssh/neomob}"
SSH_HOST="${SSH_HOST:-root@104.236.83.84}"
SITE_ROOT="${SITE_ROOT:-/home/neamob/public_html/neamob.com}"
OWNER="${OWNER:-neamob:neamob}"

if [[ ! -f "$LOCAL_CONFIG" ]]; then
  echo "Missing $LOCAL_CONFIG" >&2
  exit 1
fi

SITEKEY="$(grep -E "define\s*\(\s*'WPCF7_RECAPTCHA_SITEKEY'" "$LOCAL_CONFIG" | sed -E "s/.*'([^']+)'\s*\);\s*$/\1/" | tail -1)"
SECRET="$(grep -E "define\s*\(\s*'WPCF7_RECAPTCHA_SECRET'" "$LOCAL_CONFIG" | sed -E "s/.*'([^']+)'\s*\);\s*$/\1/" | tail -1)"

if [[ -z "$SITEKEY" || -z "$SECRET" ]]; then
  echo "WPCF7_RECAPTCHA_SITEKEY / WPCF7_RECAPTCHA_SECRET not found in wp-config.php" >&2
  exit 1
fi

ssh -i "$SSH_KEY" -o ConnectTimeout=30 "$SSH_HOST" "SITEKEY=$(printf %q "$SITEKEY") SECRET=$(printf %q "$SECRET") SITE_ROOT=$(printf %q "$SITE_ROOT") OWNER=$(printf %q "$OWNER") bash -s" <<'REMOTE'
set -euo pipefail
cd "$SITE_ROOT"
CONFIG="$SITE_ROOT/wp-config.php"

if [[ ! -f "$CONFIG" ]]; then
  echo "wp-config.php not found" >&2
  exit 1
fi

cp "$CONFIG" "${CONFIG}.bak-$(date +%Y%m%d%H%M%S)"
grep -v "WPCF7_RECAPTCHA_SITEKEY" "$CONFIG" | grep -v "WPCF7_RECAPTCHA_SECRET" > "${CONFIG}.tmp"
mv "${CONFIG}.tmp" "$CONFIG"

if grep -q "require_once ABSPATH" "$CONFIG"; then
  sed -i "/require_once ABSPATH/i\\
// reCAPTCHA v3 (Contact Form 7)\\
define('WPCF7_RECAPTCHA_SITEKEY', '${SITEKEY}');\\
define('WPCF7_RECAPTCHA_SECRET', '${SECRET}');\\
" "$CONFIG"
else
  printf "\n// reCAPTCHA v3 (Contact Form 7)\ndefine('WPCF7_RECAPTCHA_SITEKEY', '%s');\ndefine('WPCF7_RECAPTCHA_SECRET', '%s');\n" "$SITEKEY" "$SECRET" >> "$CONFIG"
fi

chown "$OWNER" "$CONFIG"
chmod 640 "$CONFIG"

git pull origin main
chown -R "$OWNER" wp-content/mu-plugins 2>/dev/null || true
find wp-content/mu-plugins -type d -exec chmod 755 {} \; 2>/dev/null || true
find wp-content/mu-plugins -type f -exec chmod 644 {} \; 2>/dev/null || true

php -r "
require 'wp-load.php';
echo (defined('WPCF7_RECAPTCHA_SITEKEY') && WPCF7_RECAPTCHA_SITEKEY ? 'recaptcha_sitekey:ok' : 'recaptcha_sitekey:missing'), PHP_EOL;
echo (defined('WPCF7_RECAPTCHA_SECRET') && WPCF7_RECAPTCHA_SECRET ? 'recaptcha_secret:ok' : 'recaptcha_secret:missing'), PHP_EOL;
echo (class_exists('WPCF7_RECAPTCHA') && WPCF7_RECAPTCHA::get_instance()->is_active() ? 'cf7_recaptcha:active' : 'cf7_recaptcha:inactive'), PHP_EOL;
"

REMOTE

echo "Done."
