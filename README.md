# Grocery Laravel Project

## Overview

This project provides a streamlined solution for managing pre-orders in online shops. It integrates role-based access control, rate limiting, reCAPTCHA validation, and email notifications to enhance customer experience and security.

## Requirements

- **Laravel**: 11
- **PHP**: 8.2.0 or higher
- **Database**: PostgreSQL
- **Composer**: Latest version

---

## Installation Guide

### 1. Download and Unzip

1. Download the zip file.
2. Unzip it and enter the project directory.

### 2. Install Dependencies

Run the following command:

```bash
composer install
```

### 3. Install Pre-Order Package

```bash
composer require dev_mamun/shop-pre-order
```

### 4. Configure Environment File

1. Create a copy of `.env.example` and name it `.env`.
2. Update the `.env` file with your configuration:

**Database Configuration:**

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=pre-sale
DB_USERNAME=postgres
DB_PASSWORD=root
```

**Mail Configuration:**

```
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=0147ea4f8050ed
MAIL_PASSWORD=deccaf237d7593
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**reCAPTCHA Configuration:**

```
RECAPTCHA_SITE_KEY=6Lcs-acqAAAAACCV4-7ROiE4dZis3mWaJxzrXr2u
RECAPTCHA_SECRET_KEY=6Lcs-acqAAAAAKNZgB1IziaqG8jpa45CXetuTvMA
```

> \*\*To get recaptcha credentials go to [https://www.google.com/recaptcha/admin/create](https://www.google.com/recaptcha/admin/create)
> \*\*
>
> and create recaptcha v2
>
> \
> **Note**: Use your own credentials to fill out the `.env` file.

### 5. Run Application Setup

```bash
php artisan app:install
```

This command will:

- Perform database migrations.
- Seed the database with default values.
- Set up Passport authentication.

---

## Usage

### Start Application

```bash
php artisan serve
```

### Start Queue Worker

```bash
php artisan queue:work
```

### Default Login Credentials

- **Admin:**
  - Email: [admin@gmail.com](mailto\:admin@gmail.com)
  - Password: 123456
- **Manager:**
  - Email: [manager@gmail.com](mailto\:manager@gmail.com)
  - Password: 123456

---

## Frontend Setup

To integrate the UI, visit the repository below:
[Frontend UI Repository](https://github.com/devmamun/grocery-vue)
Follow the installation guidelines provided.

---

## Support

For issues or contributions, visit the repository and submit a pull request or open an issue.

**Author**: Md. Al Mamun
**License**: MIT

