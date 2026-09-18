# SK Blog System — Laravel Authentication & Admin Foundation

A Laravel 12 project currently implementing the **authentication and administration foundation** for a blog-management system.

> The verified current codebase contains authentication/admin infrastructure. It is not presented as a complete publishing platform until post/article/comment domains are implemented.

## Verified Features

- admin login by email or username
- Laravel session authentication
- account-state checks for Active / Inactive / Pending users
- authenticated admin dashboard
- secure logout with session invalidation and token regeneration
- forgot-password workflow
- expiring password-reset tokens
- email delivery helper based on PHPMailer
- password hashing with Laravel Hash
- database migrations and seeders
- Vite/Tailwind frontend build foundation

## Technology Stack

| Area | Technology |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Auth | Laravel authentication/session system |
| Database | Laravel migrations / Eloquent-ready stack |
| Email | PHPMailer |
| Frontend build | Vite |
| Styling | Tailwind CSS 4 tooling |
| Testing | Pest + Laravel test tooling |

## Current Routes

Verified admin flows include:

```text
/admin/login
/admin/forgot-password
/admin/send-reset-link
/admin/reset-password/{token}
/admin/dashboard
/admin/logout
```

## Architecture Snapshot

```text
Request
  ↓
Laravel Routes
  ↓
AuthController / AdminController
  ↓
Validation + Authentication + Password Reset
  ↓
User / password_reset_tokens persistence
  ↓
Blade admin views + email templates
```

## Local Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

## Engineering Evidence

This repository demonstrates:

- Laravel controller/routing fundamentals
- authentication and session lifecycle
- password-reset token handling
- email workflow integration
- Blade/admin UI integration
- PHP/Laravel breadth beyond the primary Python stack

For a larger Laravel/Vue API project, see **User-Task-API_Project** on this profile.

## Author

**Shahriyar Khan**  
Software Engineer · Full-Stack Python Developer

- Portfolio: https://shahriyarkhan.com
- GitHub: https://github.com/Shahriyar-Kh
- LinkedIn: https://www.linkedin.com/in/shahriyar-khan-developer/
