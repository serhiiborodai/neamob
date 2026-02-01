<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Redirect admin files from root to /wp-admin/
$admin_files = ['edit.php', 'post.php', 'post-new.php', 'upload.php', 'edit-tags.php', 
    'edit-comments.php', 'themes.php', 'plugins.php', 'users.php', 'user-new.php',
    'user-edit.php', 'profile.php', 'tools.php', 'import.php', 'export.php',
    'options-general.php', 'options-writing.php', 'options-reading.php',
    'options-discussion.php', 'options-media.php', 'options-permalink.php',
    'options-privacy.php', 'nav-menus.php', 'widgets.php', 'customize.php',
    'site-health.php', 'update-core.php', 'admin.php', 'media-new.php',
    'theme-editor.php', 'plugin-editor.php', 'plugin-install.php'];

$base = basename(explode('?', $uri)[0]);
if (in_array($base, $admin_files) && strpos($uri, '/wp-admin/') === false) {
    $query = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
    header('Location: /wp-admin/' . $base . $query);
    exit;
}

if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
require_once __DIR__ . '/index.php';
