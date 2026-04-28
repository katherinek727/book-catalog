# Book Catalog

A Yii2 Basic web application for managing books and authors, with SMS subscription notifications via SmsPilot.

## Requirements

- PHP 8.0+
- MySQL 5.7+ / MariaDB 10.3+
- Composer
- XAMPP / WAMP or any PHP+MySQL stack

## Setup

### 1. Install dependencies

```bash
composer install
```

### 2. Configure database

Copy and edit the local DB config:

```bash
cp config/db.php config/db-local.php
```

Edit `config/db-local.php` with your credentials:

```php
return [
    'dsn'      => 'mysql:host=localhost;dbname=book_catalog',
    'username' => 'root',
    'password' => 'your_password',
];
```

Create the database:

```sql
CREATE DATABASE book_catalog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Run migrations

```bash
php yii migrate
```

### 4. Initialize RBAC

```bash
mkdir rbac
php yii rbac/init
```

### 5. Create a user

Open `php yii` console or use a seeder. Example via Tinker / console:

```php
$user = new app\models\User();
$user->username = 'admin';
$user->setPassword('password');
$user->generateAuthKey();
$user->save();
```

### 6. Configure cookie key

Set `COOKIE_VALIDATION_KEY` environment variable, or edit `config/web.php` directly (do not commit).

### 7. Serve the app

Point your web server document root to the `web/` folder, or use PHP built-in server:

```bash
php -S localhost:8080 -t web
```

## Features

- Book catalog with cover image upload
- Author management with many-to-many book relations
- Guest SMS subscription per author
- Top-10 authors report by year
- File-based RBAC (guest / user roles)
- SmsPilot SMS notifications on new book creation (DEMO key)

## Project Structure

```
config/       App configuration
controllers/  Web controllers
models/       ActiveRecord models
views/        View templates
migrations/   Database migrations
components/   SmsPilotService
commands/     Console commands (RBAC init)
rbac/         RBAC permission files
web/          Public web root
```
