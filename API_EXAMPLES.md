# Примеры использования API

## Содержание
- [Аутентификация](#аутентификация)
- [Работа с пользователями](#работа-с-пользователями)
- [Работа с проектами](#работа-с-проектами)
- [Работа с задачами](#работа-с-задачами)
- [Статистика](#статистика)

---

## Аутентификация

### Регистрация нового пользователя

**Запрос:**
```bash
curl -X POST http://task-api.local/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@example.com",
    "password": "SecurePassword123",
    "password_confirmation": "SecurePassword123",
    "role_id": 3,
    "phone": "+1234567890"
  }'
```

**Ответ:**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 9,
    "first_name": "John",
    "last_name": "Doe",
    "full_name": "John Doe",
    "email": "john.doe@example.com",
    "phone": "+1234567890",
    "status": "active",
    "avatar": null,
    "role": {
      "id": 3,
      "slug": "user",
      "name": "User",
      "permissions": ["tasks.view", "tasks.update"],
      "is_active": true
    },
    "created_at": "2024-02-08 10:30:00",
    "updated_at": "2024-02-08 10:30:00"
  },
  "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ1234567890"
}
```

### Вход в систему

**Запрос:**
```bash
curl -X POST http://task-api.local/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password123"
  }'
```

**Ответ:**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "first_name": "Admin",
    "last_name": "User",
    "full_name": "Admin User",
    "email": "admin@example.com",
    "phone": "+1234567890",
    "status": "active",
    "avatar": null,
    "role": {
      "id": 1,
      "slug": "admin",
      "name": "Administrator",
      "permissions": ["users.view", "users.create", "users.update", "users.delete", "projects.view", "projects.create", "projects.update", "projects.delete", "tasks.view", "tasks.create", "tasks.update", "tasks.delete", "statistics.view"],
      "is_active": true
    },
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-01-01 00:00:00"
  },
  "token": "2|xYzAbC123456789dEfGhIjKlMnOpQrStUvWx"
}
```

### Получение информации о текущем пользователе

**Запрос:**
```bash
curl -X GET http://task-api.local/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Ответ:**
```json
{
  "user": {
    "id": 1,
    "first_name": "Admin",
    "last_name": "User",
    "full_name": "Admin User",
    "email": "admin@example.com",
    "phone": "+1234567890",
    "status": "active",
    "avatar": null,
    "role": {
      "id": 1,
      "slug": "admin",
      "name": "Administrator",
      "permissions": ["users.view", "users.create", "..."],
      "is_active": true
    },
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-01-01 00:00:00"
  }
}
```

### Выход из системы

**Запрос:**
```bash
curl -X POST http://task-api.local/api/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Ответ:**
```json
{
  "message": "Logged out successfully"
}
```

---

## Работа с пользователями

### Получение списка всех пользователей (Admin/Manager)

**Запрос:**
```bash
curl -X GET "http://task-api.local/api/users?per_page=15" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Ответ:**
```json
{
  "data": [
    {
      "id": 1,
      "first_name": "Admin",
      "last_name": "User",
      "full_name": "Admin User",
      "email": "admin@example.com",
      "phone": "+1234567890",
      "status": "active",
      "avatar": null,
      "role": {
        "id": 1,
        "slug": "admin",
        "name": "Administrator"
      },
      "created_at": "2024-01-01 00:00:00",
      "updated_at": "2024-01-01 00:00:00"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 8
  }
}
```

### Получение информации о конкретном пользователе

**Запрос:**
```bash
curl -X GET http://task-api.local/api/users/5 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Ответ:**
```json
{
  "data": {
    "id": 5,
    "first_name": "Alice",
    "last_name": "Smith",
    "full_name": "Alice Smith",
    "email": "alice.smith@example.com",
    "phone": "+1234567893",
    "status": "active",
    "avatar": null,
    "role": {
      "id": 3,
      "slug": "user",
      "name": "User",
      "permissions": ["tasks.view", "tasks.update"],
      "is_active": true
    },
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-01-01 00:00:00"
  }
}
```

### Обновление профиля пользователя

**Запрос:**
```bash
curl -X PUT http://task-api.local/api/users/5 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Alice Updated",
    "phone": "+9876543210"
  }'
```

**Ответ:**
```json
{
  "message": "User updated successfully",
  "data": {
    "id": 5,
    "first_name": "Alice Updated",
    "last_name": "Smith",
    "full_name": "Alice Updated Smith",
    "email": "alice.smith@example.com",
    "phone": "+9876543210",
    "status": "active",
    "avatar": null,
    "role": {
      "id": 3,
      "slug": "user",
      "name": "User"
    },
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-02-08 10:45:00"
  }
}
```

---

## Работа с проектами

### Получение списка проектов

**Без фильтров:**
```bash
curl -X GET "http://task-api.local/api/projects?per_page=15" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**С фильтрацией по статусу:**
```bash
curl -X GET "http://task-api.local/api/projects?status=active&per_page=15" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Ответ:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Website Redesign",
      "description": "Complete redesign of the company website with modern UI/UX",
      "status": "active",
      "creator": {
        "id": 1,
        "first_name": "Admin",
        "last_name": "User",
        "full_name": "Admin User",
        "email": "admin@example.com"
      },
      "created_at": "2024-01-01 00:00:00",
      "updated_at": "2024-01-01 00:00:00"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 3
  }
}
```

### Создание проекта (Manager/Admin)

**Запрос:**
```bash
curl -X POST http://task-api.local/api/projects \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "E-commerce Platform",
    "description": "Building a new e-commerce platform from scratch",
    "status": "active"
  }'
```

**Ответ:**
```json
{
  "message": "Project created successfully",
  "data": {
    "id": 4,
    "name": "E-commerce Platform",
    "description": "Building a new e-commerce platform from scratch",
    "status": "active",
    "creator": {
      "id": 2,
      "first_name": "John",
      "last_name": "Manager",
      "full_name": "John Manager",
      "email": "john.manager@example.com"
    },
    "created_at": "2024-02-08 11:00:00",
    "updated_at": "2024-02-08 11:00:00"
  }
}
```

### Получение детальной информации о проекте

**Запрос:**
```bash
curl -X GET http://task-api.local/api/projects/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Ответ:**
```json
{
  "data": {
    "id": 1,
    "name": "Website Redesign",
    "description": "Complete redesign of the company website with modern UI/UX",
    "status": "active",
    "creator": {
      "id": 1,
      "first_name": "Admin",
      "last_name": "User",
      "full_name": "Admin User",
      "email": "admin@example.com"
    },
    "tasks": [
      {
        "id": 1,
        "title": "Design Homepage Mockup",
        "status": "completed",
        "priority": "high"
      },
      {
        "id": 2,
        "title": "Develop Header Component",
        "status": "in_progress",
        "priority": "high"
      }
    ],
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-01-01 00:00:00"
  }
}
```

### Обновление проекта (Owner/Admin)

**Запрос:**
```bash
curl -X PUT http://task-api.local/api/projects/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Website Redesign v2.0",
    "status": "completed"
  }'
```

**Ответ:**
```json
{
  "message": "Project updated successfully",
  "data": {
    "id": 1,
    "name": "Website Redesign v2.0",
    "description": "Complete redesign of the company website with modern UI/UX",
    "status": "completed",
    "creator": {
      "id": 1,
      "first_name": "Admin",
      "last_name": "User",
      "full_name": "Admin User",
      "email": "admin@example.com"
    },
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-02-08 11:15:00"
  }
}
```

### Удаление проекта (Owner/Admin)

**Запрос:**
```bash
curl -X DELETE http://task-api.local/api/projects/4 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Ответ:**
```json
{
  "message": "Project deleted successfully"
}
```

---

## Работа с задачами

### Получение списка задач

**Без фильтров:**
```bash
curl -X GET "http://task-api.local/api/tasks?per_page=15" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**С множественными фильтрами:**
```bash
curl -X GET "http://task-api.local/api/tasks?status=pending&priority=high&project_id=1&sort_by=due_date&sort_order=asc&per_page=15" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Ответ:**
```json
{
  "data": [
    {
      "id": 3,
      "title": "Write Content for About Page",
      "description": "Create compelling copy for the about us section",
      "status": "pending",
      "priority": "medium",
      "due_date": "2024-02-15",
      "is_overdue": false,
      "project": {
        "id": 1,
        "name": "Website Redesign",
        "status": "active"
      },
      "assignee": {
        "id": 7,
        "first_name": "Charlie",
        "last_name": "Williams",
        "full_name": "Charlie Williams",
        "email": "charlie.williams@example.com"
      },
      "creator": {
        "id": 1,
        "first_name": "Admin",
        "last_name": "User",
        "full_name": "Admin User",
        "email": "admin@example.com"
      },
      "created_at": "2024-01-01 00:00:00",
      "updated_at": "2024-01-01 00:00:00"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 2,
    "per_page": 15,
    "total": 20
  }
}
```

### Создание задачи (Manager/Admin)

**Запрос:**
```bash
curl -X POST http://task-api.local/api/tasks \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Implement User Authentication",
    "description": "Add JWT authentication to the API",
    "status": "pending",
    "priority": "high",
    "project_id": 2,
    "assigned_to": 5,
    "due_date": "2024-03-01"
  }'
```

**Ответ:**
```json
{
  "message": "Task created successfully",
  "data": {
    "id": 21,
    "title": "Implement User Authentication",
    "description": "Add JWT authentication to the API",
    "status": "pending",
    "priority": "high",
    "due_date": "2024-03-01",
    "is_overdue": false,
    "project": {
      "id": 2,
      "name": "Mobile App Development",
      "status": "active"
    },
    "assignee": {
      "id": 5,
      "first_name": "Alice",
      "last_name": "Smith",
      "full_name": "Alice Smith",
      "email": "alice.smith@example.com"
    },
    "creator": {
      "id": 2,
      "first_name": "John",
      "last_name": "Manager",
      "full_name": "John Manager",
      "email": "john.manager@example.com"
    },
    "created_at": "2024-02-08 11:30:00",
    "updated_at": "2024-02-08 11:30:00"
  }
}
```

### Получение детальной информации о задаче

**Запрос:**
```bash
curl -X GET http://task-api.local/api/tasks/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Ответ:**
```json
{
  "data": {
    "id": 1,
    "title": "Design Homepage Mockup",
    "description": "Create wireframes and mockups for the new homepage",
    "status": "completed",
    "priority": "high",
    "due_date": "2024-02-03",
    "is_overdue": false,
    "project": {
      "id": 1,
      "name": "Website Redesign",
      "description": "Complete redesign of the company website with modern UI/UX",
      "status": "active"
    },
    "assignee": {
      "id": 5,
      "first_name": "Alice",
      "last_name": "Smith",
      "full_name": "Alice Smith",
      "email": "alice.smith@example.com",
      "phone": "+1234567893",
      "status": "active"
    },
    "creator": {
      "id": 1,
      "first_name": "Admin",
      "last_name": "User",
      "full_name": "Admin User",
      "email": "admin@example.com"
    },
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-02-03 15:30:00"
  }
}
```

### Обновление задачи

**Обновление статуса (доступно User):**
```bash
curl -X PUT http://task-api.local/api/tasks/2 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "status": "completed"
  }'
```

**Полное обновление (Manager/Admin):**
```bash
curl -X PUT http://task-api.local/api/tasks/2 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Updated Task Title",
    "status": "in_progress",
    "priority": "medium",
    "assigned_to": 6,
    "due_date": "2024-03-15"
  }'
```

**Ответ:**
```json
{
  "message": "Task updated successfully",
  "data": {
    "id": 2,
    "title": "Updated Task Title",
    "description": "Implement responsive header with navigation",
    "status": "in_progress",
    "priority": "medium",
    "due_date": "2024-03-15",
    "is_overdue": false,
    "project": {
      "id": 1,
      "name": "Website Redesign",
      "status": "active"
    },
    "assignee": {
      "id": 6,
      "first_name": "Bob",
      "last_name": "Johnson",
      "full_name": "Bob Johnson",
      "email": "bob.johnson@example.com"
    },
    "creator": {
      "id": 1,
      "first_name": "Admin",
      "last_name": "User",
      "full_name": "Admin User",
      "email": "admin@example.com"
    },
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-02-08 11:45:00"
  }
}
```

### Удаление задачи (Owner/Admin)

**Запрос:**
```bash
curl -X DELETE http://task-api.local/api/tasks/21 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Ответ:**
```json
{
  "message": "Task deleted successfully"
}
```

---

## Статистика

### Получение общей статистики (Admin/Manager)

**Запрос:**
```bash
curl -X GET http://task-api.local/api/statistics \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Ответ:**
```json
{
  "data": {
    "total_projects": 3,
    "total_tasks": 20,
    "tasks_by_status": {
      "pending": 8,
      "in_progress": 5,
      "completed": 7
    },
    "overdue_tasks": 1,
    "top_active_users": [
      {
        "id": 1,
        "name": "Admin User",
        "email": "admin@example.com",
        "tasks_created": 6
      },
      {
        "id": 2,
        "name": "John Manager",
        "email": "john.manager@example.com",
        "tasks_created": 7
      },
      {
        "id": 3,
        "name": "Sarah Manager",
        "email": "sarah.manager@example.com",
        "tasks_created": 7
      }
    ]
  }
}
```

---

## Коды ошибок

### 401 Unauthorized
```json
{
  "message": "Unauthenticated"
}
```

### 403 Forbidden
```json
{
  "message": "Forbidden. You do not have permission to access this resource."
}
```

### 404 Not Found
```json
{
  "message": "Project not found"
}
```

### 422 Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": [
      "The email has already been taken."
    ],
    "password": [
      "The password confirmation does not match."
    ]
  }
}
```

### 500 Server Error
```json
{
  "message": "Server Error",
  "error": "Internal server error occurred"
}
```
