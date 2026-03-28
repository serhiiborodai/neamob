#!/bin/bash
#
# Локальный скрипт деплоя. Запускай из корня проекта.
# Загружает архив, SQL и deploy.sh на сервер и запускает деплой.
#
# Использование:
#   ./deploy-to-server.sh          — полный деплой (сборка + код + БД + медиа)
#   ./deploy-to-server.sh media    — только portfolio media
#
# Требуется: build/neamob.tar.gz, build/neamob.sql
# Перед первым запуском: chmod +x deploy-to-server.sh
#

set -e

SSH_KEY="${SSH_KEY:-$HOME/.ssh/twyx-server}"
SSH_HOST="${SSH_HOST:-ubuntu@185.233.119.8}"
SSH_CMD="ssh -i $SSH_KEY"

PORTFOLIO_LOCAL="wp-content/uploads/portfolio/"
PORTFOLIO_REMOTE="/home/nb/public_html/nb.twyx.us/wp-content/uploads/portfolio/"

sync_portfolio_media() {
    if [ ! -d "$PORTFOLIO_LOCAL" ]; then
        echo "Папка $PORTFOLIO_LOCAL не найдена, пропускаем."
        return
    fi
    echo "Синхронизация portfolio media..."
    rsync -avz --delete --exclude='._*' --exclude='.DS_Store' --progress -e "$SSH_CMD" "$PORTFOLIO_LOCAL" "${SSH_HOST}:${PORTFOLIO_REMOTE}"
    echo "Portfolio media синхронизированы."
}

# Режим «только медиа»
if [ "${1:-}" = "media" ]; then
    sync_portfolio_media
    echo "Готово."
    exit 0
fi

BUILD_DIR="build"
ARCHIVE="$BUILD_DIR/neamob.tar.gz"
SQL="$BUILD_DIR/neamob.sql"
DEPLOY_SH="$BUILD_DIR/deploy.sh"

echo "Сборка..."
./build.sh

if [ ! -f "$ARCHIVE" ]; then
    echo "Нет архива. Собери билд:"
    echo "  php export-db-mysql.php > $SQL"
    echo "  tar --exclude='.git' --exclude='node_modules' --exclude='.env' --exclude='*.log' \\"
    echo "    --exclude='wp-cli.phar' --exclude='wp-config.php' --exclude='wp-content/database' \\"
    echo "    -czf $ARCHIVE ."
    exit 1
fi

if [ ! -f "$SQL" ]; then
    echo "Нет дампа БД: $SQL"
    exit 1
fi

echo "Загрузка на сервер..."
scp -i "$SSH_KEY" "$ARCHIVE" "$SQL" "$DEPLOY_SH" "${SSH_HOST}:/tmp/"

echo "Запуск деплоя..."
$SSH_CMD "$SSH_HOST" "sudo bash /tmp/deploy.sh"

sync_portfolio_media

echo "Готово."
