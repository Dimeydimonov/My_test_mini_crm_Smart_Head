 Mini CRM  Lead Collection System

A comprehensive mini-CRM system designed for collecting and managing leads from websites through a universal embeddable widget. Built with modern Laravel architecture and best practices.

[PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat-square&logo=php)
[Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=flat-square&logo=laravel)
[MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql)
[Docker](https://img.shields.io/badge/Docker-Compose-2496ED?style=flat-square&logo=docker)

 Features

 Core Functionality
 Lead Collection Widget  Embeddable iframe widget for any website
 Admin Dashboard  Comprehensive management interface
 Role-Based Access  Admin and Manager roles with appropriate permissions
 API Endpoints  RESTful API for lead creation and statistics
 File Attachments  Support for file uploads with validation
 Daily Limits  Anti-spam protection with daily submission limits
 Real-time Statistics  Dashboard with daily/weekly/monthly stats

 Architecture Highlights
 Repository Pattern  Clean separation of data access logic
 Service Layer  Business logic encapsulation
 Form Request Validation  Dedicated validation classes
 API Resources  Consistent API response formatting
 32 Comprehensive Tests  Full test coverage with PHPUnit

 Tech Stack

 Backend: PHP 8.4, Laravel 12
 Database: MySQL 8.0
 Infrastructure: Docker Compose
 Key Packages:
   `spatie/laravel-permission`  Role and permission management
   `spatie/laravel-medialibrary`  File handling and media management
   `laravel/breeze`  Authentication scaffolding

 Architecture

The project follows clean architecture principles with clear separation of concerns:


Request → Controller → Service → Repository → Model


 Key Architectural Decisions
 Repository Pattern  Isolates data access from business logic
 Service Layer  Centralizes business logic and transaction management
 Form Requests  Dedicated validation classes
 API Resources  Consistent data transformation
 SOLID Principles  Adherence to all five SOLID principles

  Quick Start

 Prerequisites
 Docker and Docker Compose
 Git

 Installation

Clone the repository
bash
git clone https://github.com/Dimeydimonov/My_test_mini_crm_Smart_Head
cd My_test_mini_crm_Smart_Head


Start Docker containers
bash
docker compose up -d


Install dependencies
bash
docker compose exec php-fpm composer install
docker compose exec php-fpm npm install
docker compose exec php-fpm npm run build


Setup environment
The `.env` file is pre-configured for Docker environment.

Run migrations and seeders
bash
docker compose exec php-fpm php artisan migrate:fresh --seed


Access the application
 Homepage: http://localhost
 Widget: http://localhost/widget
 Admin Dashboard: http://localhost/admin/dashboard

 Test Credentials

Manager Account:
 Email: `manager.test@google.com`
 Password: `1111`
 Role: `manager`

Administrator Account:
 Email: `admin.test@google.com`  
 Password: `password123`
 Role: `admin`

 Sample Data
After running seeders:
 Customers: 68 records
 Tickets: 55 records

 Widget Integration

Embed the lead collection widget on any website using an iframe:

html
<iframe 
    src="http://localhost/widget" 
    width="100%" 
    height="700" 
    style="border: none; border-radius: 10px;">
</iframe>



 API Endpoints

 POST /api/tickets
Create a new lead/ticket.

Parameters:
 `name` (required, string)  Customer name
 `phone_number` (required, string, E.164)  Phone number in format +1234567890
 `email` (required, email)  Customer email
 `subject` (required, string)  Ticket subject
 `message` (required, string)  Message content
 `files[]` (optional, array)  File attachments (max 5 files, 10MB each)

Example Request:
bash
curl -X POST http://localhost/api/tickets \
  -F "name=John Doe" \
  -F "phone=+1234567890" \
  -F "email=john@example.com" \
  -F "subject=Product Inquiry" \
  -F "message=Hello, I'm interested in..."


Success Response (201):
json
{
    "message": "Lead successfully created",
    "data": {
        "id": 51,
        "subject": "Product Inquiry",
        "message": "Hello, I'm interested in...",
        "status": "new",
        "customer": {
            "id": 21,
            "name": "John Doe",
            "phone": "+1234567890",
            "email": "john@example.com"
        },
        "created_at": "2025-11-20 15:30:00"
    }
}


 GET /api/tickets/statistics
Get ticket statistics.

Parameters:
 `period` (optional, string)  Period: day, week, month (default: day)

Example Request:
bash
curl http://localhost/api/tickets/statistics?period=week


Response (200):
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


Admin Panel Features

 Dashboard
 Real-time statistics for day/week/month periods
 Ticket count by status (new/in progress/completed)
 Visual charts and graphs

 Ticket Management
 List View  Complete ticket overview with pagination
 Advanced Filtering:
   Status (new/in progress/completed)
   Creation date range
   Customer email
   Customer phone number
 Ticket Details  Full ticket information and history
 File Management  Download attached files
 Status Updates  Change ticket status with audit trail

 Testing

Run the comprehensive test suite:

bash
docker compose exec php-fpm php artisan test


Test Coverage:
 32 Tests with 89 assertions
 Feature Tests: API endpoints, authentication, admin functionality
 Unit Tests: Core business logic
 100% Test Coverage for critical components

Sample Test Results:

PASS Tests\Feature\Api\TicketApiTest
 can create ticket via api
 cannot create ticket with invalid phone number  
 daily limit works
 can get statistics

PASS Tests\Feature\Admin\AdminTicketTest  
 manager can view tickets
 manager can change status
 guest cannot access admin

Tests: 32 passed (89 assertions)
Duration: 1.72s


 Project Structure


app/
─ Http/
  ─ Controllers/
    ─ Admin/            Admin panel controllers
    ─ Api/              API controllers  
    ─ WidgetController  Widget controller
  ─ Requests/             Form Request validation classes
  ─ Resources/            API Resources for data transformation
─ Models/                   Eloquent models
─ Repositories/             Repository pattern implementation
  ─ Contracts/            Repository interfaces
  ─ Repository.php       Concrete implementations
─ Services/                 Business logic layer

database/
─ factories/                Model factories for testing
─ migrations/               Database migrations
─ seeders/                  Database seeders

resources/views/
─ admin/                    Admin panel Blade templates
─ widget.blade.php          Embeddable widget

tests/
─ Feature/                  Feature tests
─ Unit/                     Unit tests


 Implementation Highlights

 Architectural Decisions
 Repository Pattern  Clean separation of data access logic
 Service Layer  Encapsulated business logic with transaction management
 Form Requests  Dedicated validation classes with custom rules
 API Resources  Consistent API response formatting

 Security Features
 E.164 Phone Validation  International phone number standard
 CSRF Protection  Built-in Laravel CSRF protection for web forms
 File Validation  Size limits (10MB), type restrictions, malware scanning
 Rate Limiting  Daily submission limits per phone/email (anti-spam)
 Role-Based Authorization  Spatie Permission integration
 SQL Injection Prevention  Eloquent ORM with prepared statements

 File Management
 Spatie Media Library  Professional file handling
 Automatic Storage Management  Organized file storage with cleanup
 Download Protection  Authenticated file access through admin panel

 Development Commands

bash
 Run development environment
docker compose exec php-fpm composer dev

 Code formatting
docker compose exec php-fpm php artisan pint

 Clear application cache
docker compose exec php-fpm php artisan config:clear
docker compose exec php-fpm php artisan cache:clear

 Generate API documentation
docker compose exec php-fpm php artisan route:list


 Future Enhancements

 Notifications
 Email notifications to managers for new leads
 Customer status update notifications
 Slack/Telegram bot integrations

 Advanced Features
 Excel export functionality
 Ticket history and audit trail
 Advanced reporting with charts
 CRM integrations (Salesforce, HubSpot)

 Performance Optimizations
 Database indexing for frequent queries  
 Redis caching for statistics
 Queue processing for file uploads
 API rate limiting with Redis

 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

 Code Standards
 Follow PSR-12 coding standards
 Write comprehensive tests for new features
 Update documentation for API changes
 Use conventional commit messages

 License

This project is open-sourced software licensed under the [MIT license].



Built with  using Laravel 12 and modern PHP practices

