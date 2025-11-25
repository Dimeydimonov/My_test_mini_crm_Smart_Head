# Архитектурная документация Mini CRM


1. Обзор архитектуры             
2. Архитектурные решения            
3. Выбор библиотек              
4. Особенности реализации             
5. Паттерны проектирования            
6. Безопасность

# Обзор архитектуры

Проект построен на принципах чистой архитектуры с разделением ответственности:

 ───────────── 
    Request   
 ──────┬────── 
       │
       ▼
 ─────────────
   Controller   (тонкий слой, минимальная логика)
 ──────┬────── 
       │
       ▼
 ───────────── 
   Service      (бизнес-логика, транзакции)
 ──────┬────── 
       │
       ▼
 ───────────── 
  Repository    (работа с БД)
 ──────┬────── 
       │
       ▼
 ───────────── 
    Model       (Eloquent)
 ───────────── 


# Архитектурные решения

    #  1. Repository Pattern

* Почему выбран:*
- Изоляция бизнес-логики от деталей работы с БД
- Возможность легкой замены источника данных
- Соблюдение принципа Dependency Inversion P. (SOLID)

*Реализация:*
php
// Интерфейс определяет контракт
interface TicketRepositoryInterface {
    public function create(array $data);
    public function findById(int $id);
}

// Конкретная реализация
class TicketRepository implements TicketRepositoryInterface 
Работа с Eloquent


// Внедрение через DI
class TicketService {
    public function __construct(
        private TicketRepositoryInterface $repository
    ) {}
}

*Преимущества в проекте:*
- Сервисы не зависят от конкретной реализации работы с БД

# 2. Service Layer

*Почему выбран:*
- Централизация бизнес-логики
- Переиспользование кода между контроллерами (Web/API)
- Управление транзакциями
- Соблюдение Single Responsibility P.

*Пример:*
php
class TicketService {
    public function createTicket(array $data, array $files = [])
    {
        return DB::transaction(function () use ($data, $files) {
            // 1. Найти/создать клиента
            $customer = $this->customerService->findOrCreateCustomer(...);
            
            // 2. Создать заявку
            $ticket = $this->ticketRepository->create(...);
            
            // 3. Прикрепить файлы
            $this->fileService->attachFiles(...);
            
            return $ticket;
        });
    }
}

*Что дает:*
- Один метод для создания заявки используется и в API, и в веб-интерфейсе
- Все связанные операции в одной транзакции
- Легко добавить логирование, события, очереди

# 3. Form Request Validation

*Почему выбран:*
- Валидация отделена от контроллеров (Single Responsibility P.)
- Переиспользование правил валидации
- Автоматическая обработка ошибок

*Преимущества:*
php
// До: валидация в контроллере (плохо)
public function store(Request $request) {
    $validated = $request->validate([
        'phone_number' => 'required|regex:/^\+[1-9]\d{1,14}$/',
        // 20+ строк правил
    ]);
}

// После: чистый контроллер (хорошо)
public function store(StoreTicketRequest $request) {
    // Данные уже провалидированы
    $ticket = $this->service->createTicket($request->validated());
}


# 4. API Resources

*Почему выбран:*
- Трансформация моделей для API отделена от контроллеров
- Контроль над структурой ответа
- Скрытие внутренних полей модели

*Пример:*
php
class TicketResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            // Контролируем что возвращаем
            'customer' => new CustomerResource($this->customer),
            'files' => $this->when($this->relationLoaded('media'), fn() => ...),
        ];
    }
}


#Выбор библиотек

# Spatie Laravel Permission

*Почему выбрана:*
- Стандарт де-факто в Laravel экосистеме
- Простое управление ролями и разрешениями
- Готовые middleware
- Хорошая документация и поддержка
- Кеширование разрешений

*Альтернативы (почему не выбраны):*
- Встроенные Gates/Policies - слишком низкоуровневые для сложных ролей
- Собственная реализация - "изобретение велосипеда"

# Spatie Media Library
*Почему выбрана:*
- Мощная работа с медиафайлами
- Автоматическое управление хранением
- Коллекции файлов
- Интеграция с различными драйверами хранения

*Альтернативы (почему не выбраны):*
- Прямое хранение в БД - плохая практика для файлов
- Ручное управление файлами - много boilerplate кода

# Laravel Breeze

*Почему выбран:*
- Минималистичная авторизация
- Готовые Blade шаблоны
- Легко кастомизируется
- Не перегружает проект

*Альтернативы (почему не выбраны):*
- Laravel Jetstream - избыточен для mini-CRM
- Sanctum/Passport - для API-only (у нас веб-админка)

# Особенности реализации
# 1. Валидация телефона E.164

*Почему именно E.164:*
- Международный стандарт(+380....)
- Уникальность номеров
- Совместимость с телефонными API
- Единый формат хранения

*Реализация:*
php
'phone_number' => ['required', 'string', 'regex:/^\+[1-9]\d{1,14}$/']


*Формат:* +(код страны)(номер), например: +380661638162
#2. Дневной лимит заявок

*Зачем:*
- Защита от спама
- Предотвращение злоупотреблений
- Экономия ресурсов

*Реализация:*
php
public function checkDailyLimit(string $phone_number, string $email): bool
{
    $count = $this->ticketRepository
        ->countTodayByPhoneNumberOrEmail($phone_number, $email);
    return $count >= 1;
}


*В контроллере:*
php
if ($this->ticketService->checkDailyLimit(...)) {
    return response()->json(['message' => '...'], 429);
}


#3. Eloquent Scopes для статистики

*Почему Scopes:*
- Переиспользование запросов
- Читаемый код
- Chainable методы

*Пример:*
php
// В модели Ticket
public function scopeToday($query) {
    return $query->whereDate('created_at', Carbon::today());
}

// Использование
Ticket::today()->where('status', 'new')->count();


# 4. Виджет через AJAX

*Почему AJAX, а не обычная форма:*
- Работа в iframe без перезагрузки страницы
- Возможность встраивания на любой сайт
- Обработка ошибок без перезагрузки

*Безопасность:*
- CSRF токен передается в заголовке
- CORS настроен для API
- Валидация на сервере

# Паттерны проектирования

# 1. Dependency Injection

Используется везде через constructor injection:
php
public function __construct(
    private TicketService $ticketService,
    private CustomerService $customerService
) {}


*Преимущества:*
- Явные зависимости
- Легкое тестирование
- Слабая связанность

# 2. Repository Pattern
Описан выше. Изолирует работу с данными.

# 3Виджет через AJAX. Service Layer

Описан выше. Инкапсулирует бизнес-логику.

# 4. Factory Pattern

Используется в Laravel Factories для создания тестовых данных:
php
Customer::factory(20)->create();


# 5. Strategy Pattern

Неявно используется через Repository интерфейсы - можно подменить стратегию работы с данными.

#Соблюдение SOLID

# Single Responsibility Principle
- Контроллеры - только маршрутизация и HTTP
- Сервисы - только бизнес-логика
- Репозитории - только работа с БД
- Form Requests-  только валидация
- Resources - только трансформация данных

# Open/Closed Principle
- Интерфейсы репозиториев позволяют расширять функционал без изменения существующего кода
- Можно добавить новую реализацию Repository без изменения Service

# Liskov Substitution Principle
- Любая реализация 'TicketRepositoryInterface' взаимозаменяема
- Можно подменить 'TicketRepository' на 'CachedTicketRepository'

# Interface Segregation Principle
- Интерфейсы репозиториев содержат только нужные методы
- Не заставляем клиентов зависеть от ненужных методов

# Dependency Inversion Principle
- Сервисы зависят от интерфейсов, а не от конкретных классов
- 'TicketService' → 'TicketRepositoryInterface' (не 'TicketRepository')

# Безопасность
# 1. Валидация входных данных
- Все входные данные валидируются через Form Requests
- Использование whitelist подхода ($fillable)

# 2. CSRF защита
- Для всех POST/PUT/PATCH/DELETE запросов
- Токен передается в виджете

# 3. Авторизация
- Middleware для защиты админки
- Проверка ролей через Spatie Permission
- Метод 'authorize()' в Form Requests

# 4. Rate Limiting
- Дневной лимит на заявки
- Можно добавить throttle middleware

# 5. SQL Injection
- Eloquent ORM с prepared statements
- Никаких raw запросов с пользовательскими данными

# 6. XSS
- Blade автоматически экранирует вывод: '{{ $variable }}'
- Валидация файлов по MIME типам

# 7. Файлы
- Ограничение размера (10MB)
- Ограничение типов файлов
- Хранение вне webroot через Spatie Media Library

# Соблюдение DRY и KISS

# DRY (Don't Repeat Yourself)
- Общая логика вынесена в сервисы
- Репозитории переиспользуют методы
- Blade компоненты для админки

# KISS (Keep It Simple, Stupid)
- Простая и понятная структура папок
- Минимум абстракций
- Читаемый код без "магии"
- Понятные имена классов и методов

# Структура БД

# Нормализация
- Нет дублирования данных
- Customers отделены от Tickets

# Индексы
php
// customers
$table->index('phone_number');
$table->index('email');

// tickets
$table->index('status');
$table->index('created_at');


*Зачем:*
- Быстрая фильтрация по статусу
- Быстрый поиск по email/phone_number
- Быстрая сортировка по дате

# Рекомендации по развитию

Добавить события для расширяемости:
php
event(new TicketCreated($ticket));
// Слушатели: SendEmailNotification, LogTicket, etc.

Кешировать статистику:
php
Cache::remember('stats.day', 3600, fn() => 
    $this->ticketService->getStatistics('day')
);

Добавить детальное логирование действий:
''php
Log::info('Ticket created', ['ticket_id' => $ticket->id]);

- Laravel Telescope для разработки
- Sentry для production мониторинга

Покрыть тестами:
- Unit тесты для сервисов
- Feature тесты для API и веб
- Integration тесты


Проект построен с учетом лучших практик Laravel:
- Чистая архитектура
- SOLID принципы
- DRY и KISS
- PSR-12 code style
- Безопасность
- Тестируемость
- Масштабируемость

Архитектура позволяет легко расширять функционал без изменения существующего кода.