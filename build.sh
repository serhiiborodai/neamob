#!/bin/bash
#
# Полная сборка для деплоя: тема + экспорт БД + архив
# Запуск: ./build.sh
#
set -e

echo "1. Сборка темы (SCSS → CSS)..."
cd wp-content/themes/neamob-theme && npm run build && cd ../../..
echo "2. Импорт логотипов в Partners (идемпотентно)..."
php import-partner-logos.php > /dev/null 2>&1 || true
echo "3. Экспорт БД..."
mkdir -p build
rm -f build/neamob.tar.gz build/neamob.sql
php export-db-mysql.php > build/neamob.sql
echo "4. Создание архива..."
tar --exclude='.git' --exclude='node_modules' --exclude='.env' --exclude='*.log' \
  --exclude='wp-cli.phar' --exclude='wp-config.php' \
  --exclude='wp-content/database' --exclude='build' \
  -czf build/neamob.tar.gz .
echo "Готово: build/neamob.tar.gz, build/neamob.sql"
echo "Деплой: ./deploy-to-server.sh"
