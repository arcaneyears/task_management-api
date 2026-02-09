# Task Management API

RESTful API для системы управления задачами с функциональностью для пользователей, проектов и задач.

## Технологии

- Laravel 11 (последняя версия)
- PHP 8.2+
- PostgreSQL
- Laravel Sanctum (аутентификация)

## Функциональность

- ✅ Аутентификация и авторизация (Sanctum)
- ✅ Управление пользователями (CRUD)
- ✅ Управление проектами (CRUD)
- ✅ Управление задачами (CRUD)
- ✅ Роли и права доступа (admin, manager, user)
- ✅ Email уведомления через очереди
- ✅ Фильтрация и сортировка задач
- ✅ Статистика и аналитика

## Установка

### 1. Клонирование репозитория

```bash
git clone <repository-url>
cd task-management-api
```

### 2. Установка зависимостей

```bash
composer install
```

### 3. Настройка окружения

Скопируйте файл `.env.example` в `.env`:

```bash
cp .env.example .env
```

Отредактируйте `.env` и настройте подключение к базе данных PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=task_management
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 4. Генерация ключа приложения

```bash
php artisan key:generate
```

### 5. Создание базы данных

Создайте базу данных PostgreSQL:

```sql
CREATE DATABASE task_management;
```

### 6. Миграции и Seeders

Запустите миграции и заполните БД тестовыми данными:

```bash
php artisan migrate --seed
```

Это создаст:
- 1 администратора
- 2 менеджера
- 5 пользователей
- 3 проекта
- 20 задач

### 7. Создание символической ссылки для хранилища

```bash
php artisan storage:link
```

### 8. Настройка прав доступа

```bash
chmod -R 775 storage bootstrap/cache
```

### 9. Настройка Apache

Убедитесь, что Apache настроен на директорию `public`:

```apache
<VirtualHost *:80>
    ServerName task-api.local
    DocumentRoot /path/to/task-management-api/public

    <Directory /path/to/task-management-api/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Включите mod_rewrite:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 10. Запуск очереди для email уведомлений

```bash
php artisan queue:work
```

Или настройте Supervisor для автоматического запуска:

```ini
[program:task-api-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/task-management-api/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/task-management-api/storage/logs/worker.log
```

## Тестовые данные для входа

### Администратор
- Email: `admin@example.com`
- Password: `password`

### Менеджеры
- Email: `manager1@example.com` / Password: `password`
- Email: `manager2@example.com` / Password: `password`

### Пользователи
- Email: `user1@example.com` / Password: `password`
- Email: `user2@example.com` / Password: `password`
- Email: `user3@example.com` / Password: `password`
- Email: `user4@example.com` / Password: `password`
- Email: `user5@example.com` / Password: `password`

## API Endpoints

### Аутентификация

#### Регистрация
```http
POST /api/register
Content-Type: application/json

{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role_id": 3,
    "phone": "+1234567890"
}
```

#### Вход
```http
POST /api/login
Content-Type: application/json

{
    "email": "admin@example.com",
    "password": "password"
}
```

Ответ:
```json
{
    "message": "Login successful",
    "user": {...},
    "token": "1|xxxxxxxxxxxxxxxxxxxxx"
}
```

#### Выход
```http
POST /api/logout
Authorization: Bearer {token}
```

#### Текущий пользователь
```http
GET /api/me
Authorization: Bearer {token}
```

### Пользователи

#### Список пользователей (admin, manager)
```http
GET /api/users
Authorization: Bearer {token}
```

Фильтры:
- `?role=admin` - фильтр по роли
- `?status=active` - фильтр по статусу

#### Получить пользователя
```http
GET /api/users/{id}
Authorization: Bearer {token}
```

#### Обновить пользователя
```http
PUT /api/users/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "first_name": "Updated Name",
    "status": "inactive"
}
```

### Проекты

#### Список проектов
```http
GET /api/projects
Authorization: Bearer {token}
```

Фильтры:
- `?status=active` - фильтр по статусу

#### Создать проект (manager, admin)
```http
POST /api/projects
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "New Project",
    "description": "Project description",
    "status": "active"
}
```

#### Получить проект
```http
GET /api/projects/{id}
Authorization: Bearer {token}
```

#### Обновить проект
```http
PUT /api/projects/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Updated Project",
    "status": "completed"
}
```

#### Удалить проект
```http
DELETE /api/projects/{id}
Authorization: Bearer {token}
```

### Задачи

#### Список задач
```http
GET /api/tasks
Authorization: Bearer {token}
```

Фильтры и сортировка:
- `?status=pending` - фильтр по статусу
- `?priority=high` - фильтр по приоритету
- `?project_id=1` - фильтр по проекту
- `?assigned_to=2` - фильтр по исполнителю
- `?sort_by=due_date` - сортировка (created_at, due_date, priority, status)
- `?sort_direction=asc` - направление сортировки (asc, desc)

#### Создать задачу (manager, admin)
```http
POST /api/tasks
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "New Task",
    "description": "Task description",
    "status": "pending",
    "priority": "high",
    "project_id": 1,
    "assigned_to": 5,
    "due_date": "2024-12-31"
}
```

#### Получить задачу
```http
GET /api/tasks/{id}
Authorization: Bearer {token}
```

#### Обновить задачу
```http
PUT /api/tasks/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "status": "in_progress",
    "priority": "medium"
}
```

#### Удалить задачу
```http
DELETE /api/tasks/{id}
Authorization: Bearer {token}
```

### Статистика

#### Получить статистику (дашборд)
```http
GET /api/statistics
Authorization: Bearer {token}
```

Ответ:
```json
{
    "data": {
        "projects": {
            "total": 3,
            "by_status": {
                "active": 2,
                "completed": 1
            }
        },
        "tasks": {
            "total": 20,
            "by_status": {
                "pending": 8,
                "in_progress": 7,
                "completed": 5
            },
            "overdue": 3
        },
        "top_creators": [
            {
                "created_by": 2,
                "tasks_count": 10,
                "creator": {...}
            }
        ]
    }
}
```

## Роли и права доступа

### Admin
- Полный доступ ко всем ресурсам
- Может создавать/редактировать/удалять любые проекты и задачи
- Может управлять пользователями

### Manager
- Может создавать проекты
- Может создавать задачи
- Может редактировать/удалять свои проекты
- Может просматривать список пользователей

### User
- Может просматривать назначенные задачи
- Может обновлять статус своих задач
- Может просматривать свой профиль

## Email уведомления

Система отправляет email уведомления в следующих случаях:

1. **Назначение задачи** - когда пользователю назначается новая задача
2. **Изменение статуса задачи** - когда меняется статус задачи
3. **Изменение статуса проекта** - когда меняется статус проекта

Уведомления отправляются через очередь (queue), что не блокирует основной поток выполнения.

## Структура проекта

```
task-management-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/    # API контроллеры
│   │   ├── Requests/           # Form Requests для валидации
│   │   └── Resources/          # API Resources для форматирования
│   ├── Models/                 # Eloquent модели
│   ├── Repositories/           # Репозитории (Repository Pattern)
│   ├── Services/               # Бизнес-логика (Service Layer)
│   ├── Jobs/                   # Queue Jobs
│   ├── Mail/                   # Mail классы
│   └── Policies/               # Политики авторизации
├── database/
│   ├── migrations/             # Миграции БД
│   ├── seeders/                # Seeders с тестовыми данными
│   └── factories/              # Фабрики для генерации данных
├── resources/views/emails/     # Blade шаблоны для email
├── routes/
│   └── api.php                 # API маршруты
└── README.md                   # Документация
```

## Архитектурные паттерны

Проект следует принципам SOLID и использует следующие паттерны:

- **Repository Pattern** - изоляция логики доступа к данным
- **Service Layer** - бизнес-логика приложения
- **Policy Pattern** - авторизация и права доступа
- **Form Requests** - валидация входных данных
- **API Resources** - форматирование ответов API
- **Observer Pattern** - через Events/Jobs для уведомлений

## Примеры запросов (cURL)

### Вход в систему
```bash
curl -X POST http://your-domain/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'
```

### Получить список задач
```bash
curl -X GET http://your-domain/api/tasks \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

### Создать задачу
```bash
curl -X POST http://your-domain/api/tasks \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "New Task",
    "description": "Task description",
    "project_id": 1,
    "assigned_to": 5,
    "priority": "high",
    "due_date": "2024-12-31"
  }'
```

## Postman коллекция

Для удобства тестирования API рекомендуется использовать Postman. Импортируйте endpoints из README или создайте коллекцию вручную.

Не забудьте:
1. Создать переменную окружения `base_url` = `http://your-domain/api`
2. Создать переменную `token` и автоматически обновлять её после логина
3. Добавить заголовок `Authorization: Bearer {{token}}` к защищенным запросам

## Решение проблем

### Ошибка 500 при запросах
Проверьте права доступа к директориям `storage` и `bootstrap/cache`:
```bash
chmod -R 775 storage bootstrap/cache
```

### Очередь не работает
Убедитесь, что запущен worker:
```bash
php artisan queue:work
```

### Email не отправляются
Проверьте настройки MAIL в `.env` файле и убедитесь, что очередь запущена.

## Лицензия

MIT License
