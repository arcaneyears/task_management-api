# Структура проекта Task Management API

## Обзор архитектуры

Проект следует принципам чистой архитектуры и SOLID. Используются следующие слои:

### 1. Models (app/Models/)
Eloquent модели для работы с БД:
- `User.php` - модель пользователя с ролями и связями
- `Role.php` - модель роли с правами доступа
- `Project.php` - модель проекта
- `Task.php` - модель задачи

### 2. Repositories (app/Repositories/)
Слой доступа к данным (Repository Pattern):
- `BaseRepository.php` - базовый репозиторий с общими методами
- `UserRepository.php` - работа с пользователями
- `ProjectRepository.php` - работа с проектами
- `TaskRepository.php` - работа с задачами, фильтрация, статистика

### 3. Services (app/Services/)
Бизнес-логика приложения (Service Layer):
- `AuthService.php` - регистрация, авторизация
- `UserService.php` - управление пользователями
- `ProjectService.php` - управление проектами, уведомления
- `TaskService.php` - управление задачами, уведомления
- `StatisticsService.php` - аналитика и статистика

### 4. Controllers (app/Http/Controllers/Api/)
API контроллеры:
- `AuthController.php` - регистрация, вход, выход
- `UserController.php` - CRUD пользователей
- `ProjectController.php` - CRUD проектов
- `TaskController.php` - CRUD задач с фильтрацией
- `StatisticsController.php` - статистика дашборда

### 5. Requests (app/Http/Requests/)
Валидация входных данных (Form Requests):
- `Auth/RegisterRequest.php`
- `Auth/LoginRequest.php`
- `UpdateUserRequest.php`
- `StoreProjectRequest.php`
- `UpdateProjectRequest.php`
- `StoreTaskRequest.php`
- `UpdateTaskRequest.php`

### 6. Resources (app/Http/Resources/)
Форматирование API ответов:
- `UserResource.php`
- `RoleResource.php`
- `ProjectResource.php`
- `TaskResource.php`

### 7. Policies (app/Policies/)
Авторизация и права доступа:
- `UserPolicy.php` - кто может просматривать/редактировать пользователей
- `ProjectPolicy.php` - права на проекты
- `TaskPolicy.php` - права на задачи

### 8. Jobs (app/Jobs/)
Фоновые задачи для очереди:
- `SendTaskAssignedNotification.php`
- `SendTaskStatusChangedNotification.php`
- `SendProjectStatusChangedNotification.php`

### 9. Mail (app/Mail/)
Email классы:
- `TaskAssignedMail.php`
- `TaskStatusChangedMail.php`
- `ProjectStatusChangedMail.php`

### 10. Views (resources/views/emails/)
Blade шаблоны для email:
- `task-assigned.blade.php`
- `task-status-changed.blade.php`
- `project-status-changed.blade.php`

## База данных

### Таблицы:
1. `roles` - роли пользователей
2. `users` - пользователи
3. `projects` - проекты
4. `tasks` - задачи
5. `personal_access_tokens` - токены Sanctum
6. `jobs` - очередь задач

### Связи:
- User belongsTo Role
- Project belongsTo User (creator)
- Task belongsTo Project
- Task belongsTo User (assigned_to)
- Task belongsTo User (created_by)

## Принципы разработки

### SOLID:
- **S** - каждый класс имеет одну ответственность
- **O** - классы открыты для расширения, закрыты для изменения
- **L** - наследование используется корректно
- **I** - интерфейсы разделены по назначению
- **D** - зависимости инвертированы через DI

### Паттерны:
- Repository Pattern - изоляция доступа к данным
- Service Layer - бизнес-логика
- Policy Pattern - авторизация
- Observer Pattern - события и уведомления
- Factory Pattern - создание тестовых данных

### Best Practices:
- Form Requests для валидации
- API Resources для форматирования
- Eloquent ORM для работы с БД
- Queue для асинхронных задач
- Middleware для защиты маршрутов
- Индексы для оптимизации запросов

## Безопасность

- Sanctum для аутентификации по токенам
- Хеширование паролей (bcrypt)
- Валидация всех входных данных
- Policy для авторизации
- CSRF защита
- Защита от SQL-инъекций (Eloquent)
- Rate limiting (опционально)

## Производительность

- Eager loading для избежания N+1 проблемы
- Индексы на часто используемых полях
- Пагинация (15 элементов)
- Очереди для тяжелых операций
- Кеширование (опционально через Redis)

## Тестирование

Структура готова для написания тестов:
- Unit tests для сервисов и репозиториев
- Feature tests для API endpoints
- Policy tests для проверки прав доступа

## Масштабирование

Проект готов к масштабированию:
- Можно добавить Redis для кеширования
- Можно настроить несколько queue workers
- Можно использовать database replication
- Можно добавить rate limiting
- Можно внедрить CDN для статики
