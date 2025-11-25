# Mini CRM - Система сбора заявок
Мини-CRM для сбора и обработки заявок с сайта через универсальный виджет.

# Технологии
- **PHP:** 8.4
- **Laravel:** 12
- **MySQL:** 8.0
- **Docker:** Docker Compose
- **Пакеты:**
    - spatie/laravel-permission - управление ролями
    - spatie/laravel-media library - работа с файлами

# Требования
- Docker и Docker Compose
- Git

# Установка и запуск

# 1. Клонировать репозиторий
bash
git clone https://github.com/Dimeydimonov/My_test_mini_crm_Smart_Head
cd My_test_mini_crm_Smart_Head

# 2. Запустить Docker контейнеры
bash
docker compose up -d

# 3. Установить зависимости
bash
docker compose exec php-fpm composer install
docker compose exec php-fpm npm install
docker compose exec php-fpm npm run build

# 4. Настроить .env
Файл `.env` уже настроен для работы с Docker.

# 5. Запустить миграции и seeders
bash
docker compose exec php-fpm php artisan migrate:fresh --seed

# 6. Открыть в браузере
- *Главная страница:* http://localhost
- *Виджет:* http://localhost/widget
- *Админ-панель:* http://localhost/admin/dashboard

#Тестовые данные
После выполнения seeders доступны следующие пользователи:

# Менеджер
- *Email:* manager.test@google.com
- *Password:* 1111
- *Роль:* manager

# Администратор
- *Email:* admin.test@google.com
- *Password:* password123
- *Роль:* admin

# Тестовые данные
- *Клиенты:* 68 записей
- *Заявки:* 55 записей

# Встраивание виджета

Для встраивания виджета на сторонний сайт используйте iframe:
html
<iframe 
    src="http://localhost/widget" 
    width="100%" 
    height="700" 
    style="border: none; border-radius: 10px;">
</iframe>


# API Endpoints

# POST /api/tickets
Создание новой заявки

*Параметры:*
- `name` (required, string) - Имя клиента
- `phone_number` (required, string, E.164) - Телефон в формате +1234567890
- `email` (required, email) - Email клиента
- `subject` (required, string) - Тема заявки
- `message` (required, string) - Текст сообщения
- `files[]` (optional, array) - Файлы (макс. 5 файлов по 10MB)

*Пример запроса (curl):*
bash
curl -X POST http://localhost/api/tickets \
  -F "name=Иван Иванов" \
  -F "phone=+1234567890" \
  -F "email=ivan@example.com" \
  -F "subject=Вопрос по продукту" \
  -F "message=Здравствуйте, интересует..."


*Успешный ответ (201):*
json
{
    "message": "Заявка успешно создана!",
    "data": {
        "id": 51,
        "subject": "Вопрос по продукту",
        "message": "Здравствуйте, интересует...",
        "status": "new",
        "customer": {
            "id": 21,
            "name": "Иван Иванов",
            "phone": "+1234567890",
            "email": "ivan@example.com"
        },
        "created_at": "2025-11-20 15:30:00"
    }
}


# GET /api/tickets/statistics
Получить статистику заявок

*Параметры:*
- `period` (optional, string) - Период: day, week, month (по умолчанию: day)

*Пример запроса:*
bash
curl http://localhost/api/tickets/statistics?period=week

*Ответ (200):*
json
{
    "period": "week",
    "data": {
        "total": 15,
        "new": 5,
        "in_progress": 7,
        "completed": 3
    }
}


# Функционал админ-панели

# Dashboard
- Статистика заявок за день/неделю/месяц
- Количество заявок по статусам

# Управление заявками
- Просмотр списка всех заявок
- Фильтрация по:
    - Статусу (новая/в работе/обработана)
    - Дате создания
    - Email клиента
    - Телефону клиента
- Просмотр деталей заявки
- Скачивание прикрепленных файлов
- Изменение статуса заявки

# Запуск тестов
bash
docker compose exec php-fpm php artisan test

 PASS  Tests\Unit\ExampleTest
✓ that true is true

PASS  Tests\Feature\Admin\AdminTicketTest
✓ manager can view tickets                                                                                                                         0.24s  
✓ manager can change status                                                                                                                        0.02s  
✓ guest cannot access admin                                                                                                                        0.01s

PASS  Tests\Feature\Api\TicketApiTest
✓ can create ticket via api                                                                                                                        0.02s  
✓ cannot create ticket with invalid phone number                                                                                                   0.01s  
✓ daily limit works                                                                                                                                0.01s  
✓ can get statistics                                                                                                                               0.01s

PASS  Tests\Feature\Auth\AuthenticationTest
✓ login screen can be rendered                                                                                                                     0.02s  
✓ users can authenticate using the login screen                                                                                                    0.01s  
✓ users can not authenticate with invalid password                                                                                                 0.21s  
✓ users can log out                                                                                                                                 0.01s

PASS  Tests\Feature\Auth\EmailVerificationTest
✓ email verification screen can be rendered                                                                                                        0.02s  
✓ email can be verified                                                                                                                            0.01s  
✓ email is not verified with invalid hash                                                                                                          0.01s

PASS  Tests\Feature\Auth\PasswordConfirmationTest
✓ confirm password screen can be rendered                                                                                                          0.02s  
✓ password can be confirmed                                                                                                                        0.01s  
✓ password is not confirmed with invalid password                                                                                                  0.21s

PASS  Tests\Feature\Auth\PasswordResetTest
✓ reset password link screen can be rendered                                                                                                       0.01s  
✓ reset password link can be requested                                                                                                             0.21s  
✓ reset password screen can be rendered                                                                                                            0.21s  
✓ password can be reset with valid token                                                                                                           0.21s

PASS  Tests\Feature\Auth\PasswordUpdateTest
✓ password can be updated                                                                                                                          0.02s  
✓ correct password must be provided to update password                                                                                             0.01s

PASS  Tests\Feature\Auth\RegistrationTest
✓ registration screen can be rendered                                                                                                              0.02s  
✓ new users can register                                                                                                                           0.01s

PASS  Tests\Feature\ExampleTest
✓ the application returns a successful response                                                                                                    0.01s

PASS  Tests\Feature\ProfileTest
✓ profile page is displayed                                                                                                                        0.02s  
✓ profile information can be updated                                                                                                               0.01s  
✓ email verification status is unchanged when the email address is unchanged                                                                       0.01s  
✓ user can delete their account                                                                                                                    0.02s  
✓ correct password must be provided to delete account                                                                                              0.01s

Tests:    32 passed (89 assertions)
Duration: 1.72s




# Структура проекта

app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/           # Контроллеры админки
│   │   ├── Api/             # API контроллеры
│   │   └── WidgetController # Контроллер виджета
│   ├── Requests/            # Form Request классы
│   └── Resources/           # API Resources
├── Models/                  # Eloquent модели
├── Repositories/            # Репозитории
│   ├── Contracts/           # Интерфейсы
│   └── *Repository.php      # Реализации
└── Services/                # Бизнес-логика

database/
├── factories/               # Фабрики для тестовых данных
├── migrations/              # Миграции БД
└── seeders/                 # Seeders

resources/views/
├── admin/                   # Blade шаблоны админки
└── widget.blade.php         # Виджет

tests/
├── Feature/                 # Feature тесты
└── Unit/                    # Unit тесты


# Особенности реализации

# Архитектурные решения
- *Repository Pattern:* Изоляция работы с БД от бизнес-логики
- *Service Layer:* Вся бизнес-логика инкапсулирована в сервисах
- *Form Requests:* Валидация вынесена в отдельные классы
- *API Resources:* Трансформация моделей для API

# Безопасность
- Валидация телефона в формате E.164
- CSRF защита для веб-форм
- Ограничение размера файлов (10MB)
- Ограничение типов файлов
- Дневной лимит на отправку заявок (1 в сутки с одного номера/email)
- Авторизация через middleware и роли

# Файлы
- Использование Spatie Media Library
- Автоматическое управление файлами
- Возможность скачивания через админку

# Рекомендации по улучшению

1. *Уведомления:*
    - Email уведомления менеджерам о новых заявках
    - Email уведомления пользователя о смене статуса заявки
   
2. *Функционал:*
    - Экспорт заявок в Excel
    - История изменений статуса

3. *Интеграции:*
    - Telegram/Slack боты для уведомлений
  
4. *Производительность:*
    - Индексы для частых запросов (хотя с малым обьемом БД не играет роли)

