# Laravel E-Commerce Store

## Overview
A full-featured e-commerce web application built with Laravel 13. Includes both customer-facing storefront and an admin dashboard.

## Tech Stack
- **Backend**: PHP 8.4, Laravel 13
- **Frontend**: Blade templates, Tailwind CSS, Alpine.js, Vite
- **Database**: SQLite (default)
- **Auth**: Laravel Breeze + Laravel Socialite (Google OAuth)

## Features
- Product catalog with categories
- Shopping cart and checkout
- User accounts and order history
- Wishlist and product reviews
- Admin dashboard for managing products, categories, orders, and settings
- Age-gate middleware for restricted content

## Project Structure
```
app/
  Http/Controllers/   - Route controllers (Admin/, Auth/ subdirs)
  Models/             - Eloquent models (Product, Order, User, etc.)
  Middleware/         - CheckAdmin, CheckAgeGate
database/
  migrations/         - DB schema
  seeders/            - DatabaseSeeder
resources/
  views/              - Blade templates
  css/app.css         - Tailwind CSS entry
  js/app.js           - Alpine.js entry
routes/
  web.php             - All web routes
  auth.php            - Auth routes
public/build/         - Compiled Vite assets
```

## Development Setup
- Workflow runs: `php artisan serve --host=0.0.0.0 --port=5000`
- Frontend assets built with Vite: `npm run build`
- Trusted proxies configured via `bootstrap/app.php` for Replit proxy

## Environment
- APP_URL set to Replit dev domain
- DB_CONNECTION=sqlite (database/database.sqlite)
- SESSION_DRIVER=database
- TRUSTED_PROXIES=* (set via environment variable)

## Commands
```bash
composer install          # Install PHP dependencies
npm install && npm run build  # Install and build JS/CSS
php artisan migrate       # Run database migrations
php artisan db:seed       # Seed database
php artisan storage:link  # Create storage symlink
```
