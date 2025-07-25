# OnlyUser
# Система регистрации и авторизации на нативном PHP

## О проекте

Это учебный проект, выполненный в рамках нативного PHP с использованием ООП. Цель проекта — продемонстрировать навыки работы с нативным PHP, базами данных, принципами ООП и основами веб-безопасности.

Проект представляет собой простую, но полнофункциональную систему с регистрацией, авторизацией и личным кабинетом пользователя. Реализация выполнена без использования сторонних фреймворков и библиотек для бэкенда.

## Ключевые возможности

**Регистрация пользователей:**
    Форма с полями: Имя, Телефон, Email, Пароль и Повтор пароля.
    Валидация данных на стороне сервера.
    Проверка на уникальность email и телефона в базе данных.
    Проверка совпадения паролей.
**Авторизация пользователей:**
    Вход по **email или телефону** в одном поле.
    Защита от ботов с помощью **Yandex SmartCaptcha**.
**Личный кабинет (Профиль):**
    Доступ к странице профиля только для авторизованных пользователей.
    Неавторизованные пользователи перенаправляются на главную страницу.
    Возможность изменять свои личные данные: Имя, Телефон, Email.
    Возможность сменить пароль.
**Безопасность:**
    Пароли хранятся в базе данных в хешированном виде (`password_hash`).
    Защита от SQL-инъекций с помощью подготовленных выражений (PDO).
    Экранирование выводимых данных для защиты от XSS.

## Стек технологий

**Бэкенд:** Нативный PHP 8.4
**База данных:** PSQL
**ПО веб-сервера:** Nginx-1.27
**Подход к разработке:** Объектно-ориентированное программирование (ООП)
**Основные инструменты PHP:**
    `PDO` для безопасной работы с базой данных.
    `Сессии` для управления состоянием аутентификации.
    `password_hash()` и `password_verify()` для работы с паролями.
**API:** Yandex SmartCaptcha
**Фронтенд:** HTML5, CSS3 (базовая стилизация)

## Установка и запуск

1.  **Клонируйте репозиторий:**

2.  **Настройте базу данных:**
    Создайте новую базу данных в вашей СУБД
    Импортируйте структуру таблицы из файла `dump.sql` в вашу базу данных.

3.  **Настройте конфигурацию:**
    Создайте файл `config.php` в корне проекта и введите свои данные для подключения к базе данных, а также ключи для Yandex SmartCaptcha.
    ```php
    <?php
    // Настройки для подключения к БД
    define('DB_HOST', 'localhost');
    define('DB_USER', 'your_db_user');
    define('DB_PASS', 'your_db_password');
    define('DB_NAME', 'your_db_name');

    // Ключи для Yandex SmartCaptcha
    define('YANDEX_CAPTCHA_CLIENT_KEY', 'ВАШ_КЛИЕНТСКИЙ_КЛЮЧ');
    define('YANDEX_CAPTCHA_SERVER_KEY', 'ВАШ_СЕРВЕРНЫЙ_КЛЮЧ');
    ```

4.  **Запустите локальный сервер:**

## Структура проекта

Проект имеет простую и понятную структуру, основанную на принципе разделения ответственностей, где каждый компонент выполняет свою четко определенную задачу.

## Архитектура и ключевые классы

В основе архитектуры лежит объектно-ориентированный подход. Для гибкости и простоты тестирования используется принцип **Внедрения зависимостей**. Классы получают нужные им объекты (например, подключение к БД) через конструктор, а не создают их внутри себя.

Логика приложения разделена на несколько ключевых классов в директории `src/`:

### `Database.php` (Класс `Database`)

**Отвечает за:** Создание и предоставление подключения к базе данных (PDO).
**Как работает:** При создании объекта этого класса устанавливается соединение с БД. Метод `getConn()` возвращает готовый к работе объект PDO, который затем передаётся в другие классы, нуждающиеся в доступе к базе данных.

### `User.php` (Класс `User`)
**Отвечает за:** Все операции, связанные с пользователем в базе данных.
**Обязанности:**
    Создание, поиск и обновление данных пользователя.
    Проверка существования пользователя по email или телефону (`exists`).
    Обновление личной информации (`updateInfo`) и пароля (`updatePassword`) по отдельности.
**Зависимости:** Получает объект `PDO` через конструктор для выполнения запросов.

### `Auth.php` (Класс `Auth`)
**Отвечает за:** Управление процессом аутентификации.
**Обязанности:**
    Проверка логина и пароля (`login`).
    Управление сессией пользователя: проверка, авторизован ли пользователь (`isLoggedIn`), и выход из системы (`logOut`).
    Защита страниц с помощью метода `check()`, который перенаправляет неавторизованных пользователей.
**Зависимости:** Получает объект `User` через конструктор, чтобы работать с данными пользователей, но не обращается к БД напрямую.

### `Captcha.php` (Класс `Captcha`)
**Отвечает за:** Взаимодействие с сервисом Yandex SmartCaptcha.
**Обязанности:**
    Отправка запроса на сервер Яндекса для проверки токена, полученного от пользователя.
    Инкапсулирует (скрывает) всю логику работы с cURL и внешним API.
**Зависимости:** Получает серверный ключ капчи через конструктор.

## Скриншоты

**Главная страница:**

<img width="1482" height="793" alt="image" src="https://github.com/user-attachments/assets/8a9eb394-4c7c-474f-83a9-94a0bd704969" />

**Страница регистрации:**

<img width="1390" height="875" alt="image" src="https://github.com/user-attachments/assets/584c0e79-ea74-4a30-81b2-a0adb2bc6883" />


**Страница авторизации с капчей:**

<img width="1354" height="764" alt="image" src="https://github.com/user-attachments/assets/bce20b07-a98d-4b3b-b7fb-429c05db1813" />


**Страница профиля пользователя:**

<img width="954" height="892" alt="image" src="https://github.com/user-attachments/assets/cd23a3d5-1f77-4438-9913-53030a285456" />
