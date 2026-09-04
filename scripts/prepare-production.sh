#!/usr/bin/env bash

set -euo pipefail

APP_DIR="${1:-$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)}"
WEB_USER="${WEB_USER:-www}"
PHP_BIN="${PHP_BIN:-$(command -v php || true)}"

if [[ -z "$PHP_BIN" ]]; then
    echo "PHP CLI tidak ditemukan. Set PHP_BIN, contoh: PHP_BIN=/www/server/php/82/bin/php"
    exit 1
fi

cd "$APP_DIR"

mkdir -p \
    bootstrap/cache \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

# Cache generated on another machine may contain absolute paths and must never
# be reused on this server.
find bootstrap/cache -maxdepth 1 -type f -name '*.php' -delete

if [[ "$(id -u)" == "0" ]] && id "$WEB_USER" >/dev/null 2>&1; then
    chown -R "$WEB_USER:$WEB_USER" storage bootstrap/cache
fi

find storage bootstrap/cache -type d -exec chmod 775 {} +
find storage bootstrap/cache -type f -exec chmod 664 {} +

run_artisan() {
    if [[ "$(id -u)" == "0" ]] && id "$WEB_USER" >/dev/null 2>&1 && command -v runuser >/dev/null 2>&1; then
        runuser -u "$WEB_USER" -- "$PHP_BIN" artisan "$@"
    else
        "$PHP_BIN" artisan "$@"
    fi
}

run_artisan optimize:clear
run_artisan config:cache
run_artisan route:cache
run_artisan view:cache

echo "Laravel production cache siap di $APP_DIR"
