# Crowdin-Blog
Результат виконання технічного завдання для [crowdin.space](http://crowdin.space/)
## Встановлення
Для коректної роботи **Crowdin Blog** потрібно виконати наступні дії:
- Встановити **apache2**
- Встановити **php**
- Встановити **curl** модуль (потрібно для функціонування зворотнього зв'язку на сайті)
- Увімкнути модуль **mod_rewrite** в apache
- Налаштувати **sql** базу данних:
  - User: root
  - Password: root
  - Виконати [sql лістинг](crowdin_blog.sql)
- Перенести усі файли репозиторію у директорію з файлами сервера

## Тестування сайту відбувалось з наступною конфігурацією:
**OS:** Ubuntu 16.04

**Server:** Apache 2.0

**PHP:** 7.0.8

**MySQL:** 5.7.13
## Інше
Для входу на сайт використовувати email `admin@crowdin.tk` та пароль `password`.
