# Краткая инструкция по установке

## Быстрый старт для Apache + PostgreSQL

### 1. Требования
- PHP 8.2 или выше
- PostgreSQL 12 или выше
- Apache с mod_rewrite
- Composer

### 2. Установка

```bash
# Клонировать проект
git clone <repository> task-management-api
cd task-management-api

# Установить зависимости
composer install

# Настроить окружение
cp .env.example .env
# Отредактируйте .env и укажите данные PostgreSQL

# Генерация ключа
php artisan key:generate

# Создать БД в PostgreSQL
psql -U postgres
CREATE DATABASE task_management;
\q

# Миграции и тестовые данные
php artisan migrate --seed

# Создать символическую ссылку
php artisan storage:link

# Права доступа
chmod -R 775 storage bootstrap/cache
```

### 3. Настройка Apache

Файл `/etc/apache2/sites-available/task-api.conf`:

```apache
<VirtualHost *:80>
    ServerName task-api.local
    DocumentRoot /var/www/task-management-api/public

    <Directory /var/www/task-management-api/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/task-api-error.log
    CustomLog ${APACHE_LOG_DIR}/task-api-access.log combined
</VirtualHost>
```

Активация:
```bash
sudo a2ensite task-api
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 4. Запуск очереди

```bash
php artisan queue:work
```

### 5. Тестирование

Войдите как администратор:
```bash
curl -X POST http://task-api.local/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'
```

Готово! API доступен по адресу `http://task-api.local/api`
