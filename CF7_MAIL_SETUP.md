# Contact Form 7 — настройка почты на nb.twyx.us

## 1. mail_failed — письма не отправляются

Стандартный PHP `mail()` на многих хостингах не работает. Установи один из плагинов:

- **Post SMTP** (рекомендуется)
- **WP Mail SMTP**
- **Easy WP SMTP**

Настрой SMTP через почту хостинга или Gmail/другой сервис.

### SMTP adm.tools (почта хостинга)

Для домена на adm.tools используй такие параметры:

| Параметр | Значение |
|----------|----------|
| **SMTP-сервер** | `mail.adm.tools` |
| **Порт SMTP** | `465` (SSL) или `587` (STARTTLS) или `25`, `2525` |
| **Шифрование** | SSL при порте 465 |
| **Логин** | полный email (например `info@nb.twyx.us`) |
| **Пароль** | пароль от почтового ящика |

В Post SMTP / WP Mail SMTP:
- **From Email** — тот же адрес, с которого отправляешь (например `info@nb.twyx.us`)
- **SMTP Host** — `mail.adm.tools`
- **Port** — `465` (SSL) или `587` (TLS)
- **Encryption** — SSL (для 465) или TLS (для 587)

---

---

## 3. Капча на всех формах (Contact Form 7)

На сайте три CF7-формы: **Contact Form** (id 60), **Job Application** (61), **Case Study Download** (6261).

Включено в `wp-content/mu-plugins/neamob-security.php`:

- honeypot + лимит **8 отправок / час с IP** (работает сразу)
- reCAPTCHA v3 через встроенную интеграцию CF7 (нужны ключи в `wp-config.php`)

### Ключи reCAPTCHA v3

1. Создай ключи: [Google reCAPTCHA Admin](https://www.google.com/recaptcha/admin) → тип **v3**, домены `neamob.com`, `www.neamob.com`
2. В **production** `wp-config.php` (не в git):

```php
define('WPCF7_RECAPTCHA_SITEKEY', '6Lc...');
define('WPCF7_RECAPTCHA_SECRET', '6Lc...');
```

3. После сохранения mu-plugin автоматически добавит тег `[recaptcha]` во все CF7-формы.

Проверка: отправь тест с формы — в ответе CF7 не должно быть `spam`; в исходнике страницы есть `google.com/recaptcha/api.js`.

---

## 4. Array to string conversion в шаблоне письма

Ошибка появляется, когда в макет письма подставляют поле, которое возвращает массив (чекбоксы, множественный select и т.п.) как строку.

**Важно:** имена полей в макете должны точно совпадать с именами полей в форме.

Допустим, в форме есть:
- `[text* full-name]` → в письме: `[full-name]`
- `[text* last-name]` → в письме: `[last-name]`
- `[email* your-email]` → в письме: `[your-email]`
- `[tel your-phone]` → в письме: `[your-phone]`
- `[text your-company]` → в письме: `[your-company]`
- `[select your-role]` → в письме: `[your-role]` (одиночный select — строка)
- `[select your-interest]` → в письме: `[your-interest]`
- `[textarea your-message]` → в письме: `[your-message]`

Если поле типа `[checkbox]` или `[select multiple]` и может вернуть массив, в письме используй, например:

```
[your-checkbox]
```

или

```
[*] your-checkbox
```

Проверь в форме, нет ли полей с одинаковыми именами или с `[]` (множественный выбор). Для них CF7 подставляет массив — тогда и возникает эта ошибка.

---

## 5. JS — реакция формы

Обработчики CF7 (`wpcf7mailsent`, `wpcf7mailfailed` и др.) привязаны к `document`. Реакция формы (индикатор отправки, сообщение об ошибке) должна работать после правки JS.
