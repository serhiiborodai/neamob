# Развёртывание на nb.twyx.us

## Быстрый деплой (одна команда)

После сборки билда:

```bash
chmod +x deploy-to-server.sh
./deploy-to-server.sh
```

Скрипт загрузит архив, SQL и deploy.sh на сервер и запустит деплой. wp-config.php не трогается.

---

## Вручную (если нужно)

### 1. Собрать билд

```bash
php export-db-mysql.php > build/neamob.sql
tar --exclude='.git' --exclude='node_modules' --exclude='.env' --exclude='*.log' \
  --exclude='wp-cli.phar' --exclude='wp-config.php' \
  --exclude='wp-content/database' \
  -czf build/neamob.tar.gz .
```

### 2. Залить и запустить деплой

```bash
scp -i ~/.ssh/twyx-server build/neamob.tar.gz build/neamob.sql build/deploy.sh ubuntu@185.233.119.8:/tmp/
ssh -i ~/.ssh/twyx-server ubuntu@185.233.119.8 "sudo bash /tmp/deploy.sh"
```

### 3. Или через SSH

```bash
scp -i ~/.ssh/twyx-server build/neamob.tar.gz build/neamob.sql build/deploy.sh ubuntu@185.233.119.8:/tmp/
ssh -i ~/.ssh/twyx-server ubuntu@185.233.119.8
sudo bash /tmp/deploy.sh
```

---

## Что делает deploy.sh (на сервере)

1. Сохраняет wp-config.php (не перезаписывает)
2. Очищает сайт (кроме wp-config)
3. Распаковывает архив
4. chown nb:nb
5. Читает DB_NAME, DB_USER, DB_PASSWORD из wp-config.php
6. Импортирует neamob.sql в MySQL
7. Удаляет wp-content/db.php (SQLite)
8. Чистит /tmp/

Путь к сайту: `/home/nb/public_html/nb.twyx.us`

---

## Первичная настройка (только один раз)

Если сайт ещё не настроен:

1. Создать БД MySQL (панель хостинга или `mysql -u root -p`)
2. Скопировать `wp-config.production.php` в `wp-config.php` на сервере
3. Заполнить DB_NAME, DB_USER, DB_PASSWORD
4. В админке: деактивировать плагин «SQLite Database Integration»

---

## Проверка

1. https://nb.twyx.us
2. Формы (Contact, Job Application) → письма на neamob@twyx.us
