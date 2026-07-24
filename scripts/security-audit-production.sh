#!/usr/bin/env bash
# Run on production as root: bash /path/to/security-audit-production.sh
set -euo pipefail

SITE_ROOT="${SITE_ROOT:-/home/neamob/public_html/neamob.com}"
OWNER="${OWNER:-neamob:neamob}"

cd "$SITE_ROOT"

echo "=== WordPress version ==="
php -r 'require "wp-includes/version.php"; echo $wp_version, PHP_EOL;'

echo "=== Administrators ==="
php -r 'require "wp-load.php"; foreach (get_users(["role" => "administrator"]) as $u) { echo $u->ID, " | ", $u->user_login, " | ", $u->user_email, " | ", $u->user_registered, PHP_EOL; }'

echo "=== Suspicious plugins (random suffix) ==="
find wp-content/plugins -maxdepth 1 -type d -regex '.*/wp-.*-[0-9]+$' 2>/dev/null || true

echo "=== mu-plugins ==="
ls -la wp-content/mu-plugins 2>/dev/null || echo "(none)"

echo "=== PHP modified in last 7 days (excluding wflogs/webp) ==="
find wp-content -name '*.php' -mtime -7 -type f 2>/dev/null | grep -v wflogs | grep -v webp-express | head -50

echo "=== PHP in uploads ==="
find wp-content/uploads -name '*.php' -type f 2>/dev/null | head -20

echo "=== Active plugins ==="
php -r 'require "wp-load.php"; print_r(get_option("active_plugins"));'

if [[ -f wp-content/mu-plugins/neamob-security.php ]]; then
  chown "$OWNER" wp-content/mu-plugins/neamob-security.php
  chmod 644 wp-content/mu-plugins/neamob-security.php
  echo "=== neamob-security.php permissions fixed ==="
fi
