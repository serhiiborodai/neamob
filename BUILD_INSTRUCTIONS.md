# Инструкция по подготовке билда для nb.twyx.us

**Не создавать MySQL-дамп. Использовать существующую SQLite-базу.**

## Порядок действий

1. **Очистить папку build**
   ```
   rm -rf build/*
   ```

2. **Обновить базу под домен nb.twyx.us**
   ```bash
   php -r "
   require 'wp-load.php';
   global \$wpdb;
   \$from = 'http://localhost:8080';
   \$to = 'https://nb.twyx.us';
   \$wpdb->query(\"UPDATE wp_options SET option_value = REPLACE(option_value, '\$from', '\$to') WHERE option_value LIKE '%\$from%'\");
   \$wpdb->query(\"UPDATE wp_posts SET post_content = REPLACE(post_content, '\$from', '\$to'), guid = REPLACE(guid, '\$from', '\$to') WHERE post_content LIKE '%\$from%' OR guid LIKE '%\$from%'\");
   \$wpdb->query(\"UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, '\$from', '\$to') WHERE meta_value LIKE '%\$from%'\");
   echo 'Updated to nb.twyx.us';
   "
   ```

3. **Создать архив**
   ```bash
   mkdir -p build
   tar --exclude='.git' --exclude='node_modules' --exclude='.env' --exclude='*.log' --exclude='wp-cli.phar' --exclude='export-db-mysql.php' -czvf build/neamob.tar.gz .
   ```

4. **Вернуть базу обратно (localhost:8080)**
   ```bash
   php -r "
   require 'wp-load.php';
   global \$wpdb;
   \$from = 'https://nb.twyx.us';
   \$to = 'http://localhost:8080';
   \$wpdb->query(\"UPDATE wp_options SET option_value = REPLACE(option_value, '\$from', '\$to') WHERE option_value LIKE '%\$from%'\");
   \$wpdb->query(\"UPDATE wp_posts SET post_content = REPLACE(post_content, '\$from', '\$to'), guid = REPLACE(guid, '\$from', '\$to') WHERE post_content LIKE '%\$from%' OR guid LIKE '%\$from%'\");
   \$wpdb->query(\"UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, '\$from', '\$to') WHERE meta_value LIKE '%\$from%'\");
   echo 'Restored to localhost:8080';
   "
   ```

## Загрузка через SSH

```bash
scp build/neamob.tar.gz user@nb.twyx.us:/tmp/
ssh user@nb.twyx.us
cd /var/www/nb.twyx.us
tar -xzf /tmp/neamob.tar.gz
chown -R www-data:www-data .
```
