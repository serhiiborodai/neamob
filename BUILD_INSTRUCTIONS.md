# Инструкция по подготовке билда для nb.twyx.us

**MySQL на сервере.** Локально — SQLite.

## Порядок действий

**Одной командой:** `./build.sh` (собирает тему, экспортирует БД, создаёт архив)

**Вручную:**

### 1. Очистить папку build
```
rm -rf build/*
```

### 2. Собрать тему (SCSS → CSS)
```bash
cd wp-content/themes/neamob-theme && npm run build && cd ../../..
```

### 3. Экспортировать базу в MySQL (с заменой домена на nb.twyx.us)
```bash
php export-db-mysql.php > build/neamob.sql
```

### 4. Создать архив
```bash
mkdir -p build
tar --exclude='.git' --exclude='node_modules' --exclude='.env' --exclude='*.log' \
  --exclude='wp-cli.phar' --exclude='wp-config.php' \
  --exclude='wp-content/database' --exclude='build' \
  -czvf build/neamob.tar.gz .
```

Архив содержит `build/neamob.sql` и `wp-config.production.php` (шаблон для сервера). Локальный `wp-config.php` и SQLite-база не включаются.

### 5. Файлы для заливки
- `build/neamob.tar.gz` — архив сайта
- `build/neamob.sql` — дамп MySQL
- `build/deploy.sh` — скрипт деплоя на сервере

---

## Развёртывание на nb.twyx.us

### 1. Создать БД MySQL
В панели хостинга создай базу MySQL, пользователя и пароль. Запомни:
- имя базы (DB_NAME)
- пользователь (DB_USER)
- пароль (DB_PASSWORD)
- хост (обычно `localhost`)

### 2. Деплой одной командой
```bash
./deploy-to-server.sh
```

Или вручную:
```bash
scp -i ~/.ssh/twyx-server build/neamob.tar.gz build/neamob.sql build/deploy.sh ubuntu@185.233.119.8:/tmp/
ssh -i ~/.ssh/twyx-server ubuntu@185.233.119.8 "sudo bash /tmp/deploy.sh"
```

Скрипт deploy.sh на сервере распакует архив, сохранит wp-config.php, импортирует БД. Подробнее — [DEPLOY_NB_TWYX_US.md](DEPLOY_NB_TWYX_US.md).

---

## Почта (SMTP для форм)

См. [CF7_MAIL_SETUP.md](CF7_MAIL_SETUP.md) — настройки adm.tools для теста форм.
