# HajiPay

QR-based Attendance & Payroll Management System for Bangladeshi garment factories, built with Laravel 11, Livewire, Blade, Alpine.js, Tailwind-style UI, and MySQL.

## Stack

- Laravel 11
- Livewire 4
- Blade + Alpine.js
- MySQL or SQLite for local testing
- DomPDF
- Simple QR Code
- Laravel Sanctum
- Laravel Excel

## Local Setup

1. Install dependencies:
```bash
composer install
npm install
```

2. Prepare environment:
```bash
copy .env.example .env
php artisan key:generate
php artisan storage:link
```

3. Configure database in `.env`.

4. Run migrations and seed demo data:
```bash
php artisan migrate:fresh --seed
```

5. Start the app:
```bash
php artisan serve
```

## Demo Credentials

- Super Admin: `admin@hajipay.test` / `password`
- HR Manager: `hr@hajipay.test` / `password`
- Supervisor: `supervisor@hajipay.test` / `password`

## Seeder Output

The default seeder creates:

- 1 demo company: `Dhaka Garments Ltd.`
- 3 shifts: Morning, Evening, Night
- 5 departments
- 50 demo workers
- 90 days of attendance
- 2 months of finalized payroll data

## Core Features

- Live dashboard with attendance feed and weekly performance blocks
- Worker management with QR identity generation and printable ID cards
- Daily and monthly attendance review with manual corrections
- Payroll generation, review, deduction editing, and payslip PDF download
- Shift, holiday, company, salary, and user settings
- Sanctum-protected REST API for external scanner app

## API Endpoints

All scanner endpoints are prefixed with `/api/v1`.

- `POST /api/v1/auth/login`
- `POST /api/v1/auth/logout`
- `GET /api/v1/workers/cache`
- `POST /api/v1/attendance/scan`
- `POST /api/v1/attendance/bulk-sync`
- `GET /api/v1/attendance/today`
- `GET /api/v1/shifts`

## Notes

- OT formula follows Bangladesh labor rule: `(Basic / 208) * 2 * OT Hours`
- Night shift attendance is resolved across midnight
- Finalized payroll batches are blocked from regeneration
- Uploads are stored under `storage/app/public`
