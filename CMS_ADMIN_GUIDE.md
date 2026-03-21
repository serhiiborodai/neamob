# Гид по админке и связи с фронтом

## Связь контента: админка ↔ фронтенд

| Меню админки | Где на фронте | Что редактируемо |
|--------------|---------------|------------------|
| **Posts** | Блог | Заголовок, контент, категории |
| **Testimonials** | Главная — блок отзывов | Quote, Author, Position, Company Logo (ACF) |
| **Services** | Главная — аккордеон «What We Do» | Заголовок, Short Description (ACF) |
| **Partner Logos** | Главная: слайдер логотипов + блок «Our Partners» | Logo (ACF Image → Media), Show in Slider, Show in Cards |
| **Portfolio** (скрыто) | — | CPT не используется; портфолио редактируется через страницу Portfolio |
| **Case Studies** | Главная, архив, single | Challenge, Solution, Results, Client, Badge — всё в ACF |
| **Pages** | Зависит от шаблона | См. ниже |
| **Jobs** | Careers, single job | Заголовок, контент, ACF поля |
| **Team Members** | About — слайдер команды | Position, Location, Department, **Photo** (ACF) |

---

## Pages — какие страницы за что отвечают

| Страница | Шаблон | Связь с фронтом |
|----------|--------|------------------|
| Home | front-page.php | Главная страница |
| Cookie Policy | page.php | /cookie-policy/ |
| Privacy Policy | page.php | /privacy-policy/ |
| Careers | page-careers? | Список вакансий |
| Blog | page.php? | Блог |
| About | page-about.php | О нас |
| Portfolio | page-portfolio.php | Портфолио — ACF: галерея, блоки |
| Services (родитель) | — | Родитель для дочерних |
| Growth Strategy, Data Analytics… | page-service.php | Страницы сервисов — ACF |

**Лишние страницы:** если в админке много страниц, но фронт использует только Home/Cookie/Privacy — остальное может быть legacy/demo. Можно не публиковать лишние или удалить.

---

## Partner Logos — логика

1. **Слайдер логотипов** — партнёры с галочкой «Show in Logo Slider» **и** загруженным Logo. Без лого — партнёр в слайдер не попадает.
2. **Карточки «Our Partners»** — партнёры с «Show in Our Partners Section».
3. **Изображения** — при загрузке через ACF Image поле файлы попадают в **Медиа**. Там же можно управлять ими.

Если на фронте >20 логотипов, а в админке 12 — остальные берутся из папки `assets/logos/hp_color/` (fallback, когда нет партнёров с лого).

---

## Portfolio

Пункт **Portfolio Items** скрыт из меню. Страница Portfolio наполняется через ACF самой страницы: галерея и блоки. Редактирование: Pages → Portfolio.

---

## Team Members — фото

- Добавлено поле **Photo** (ACF Image) в Team Member.
- Раньше использовались жёстко заданные `1.png`–`8.png` по порядку.
- Сейчас: сначала Photo из ACF, потом Featured Image, потом placeholder (добавь `assets/images/placeholder-person.jpg` при необходимости).

---

## Testimonials

Используется на главной (блок отзывов). ACF: quote, author, position, company logo.

---

## Case Studies — ACF вместо метабоксов

Удалены дублирующие метабоксы. Всё редактируется через **ACF: Case Study Details** (Client Name, Client Logo, Challenge, Solution, Results и т.д.). Контент записи используется как fallback, если ACF пусты.
