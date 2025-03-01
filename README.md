# Bus Ticket Booking System

A Laravel-based bus ticket booking management system that helps manage bus routes, schedules, and ticket transactions.

## Features

- Bus fleet management
- Route and city management
- Trip scheduling
- Ticket booking and transaction handling
- Dashboard with real-time statistics
- User authentication and authorization

## Database Structure

The tables are ordered based on their dependencies, from independent to dependent tables:

### Users (Default Laravel Auth)

| Column         | Type      | Constraints | Fillable |
| -------------- | --------- | ----------- | -------- |
| id             | bigint    | PK          | -        |
| name           | string    | -           | ✓        |
| email          | string    | unique      | ✓        |
| password       | string    | -           | ✓        |
| remember_token | string    | nullable    | -        |
| created_at     | timestamp | nullable    | -        |
| updated_at     | timestamp | nullable    | -        |

> Default Laravel authentication table for admin users.

### Buses

| Column     | Type      | Constraints | Fillable |
| ---------- | --------- | ----------- | -------- |
| id         | bigint    | PK          | -        |
| name       | string    | -           | ✓        |
| capacity   | integer   | -           | ✓        |
| created_at | timestamp | nullable    | -        |
| updated_at | timestamp | nullable    | -        |

> Independent table for managing bus fleet. Each bus can have multiple trips.
>
> - Has many `trips`

### Cities

| Column     | Type      | Constraints | Fillable |
| ---------- | --------- | ----------- | -------- |
| id         | bigint    | PK          | -        |
| name       | string    | unique      | ✓        |
| created_at | timestamp | nullable    | -        |
| updated_at | timestamp | nullable    | -        |

> Independent table for managing cities. Each city can be origin or destination for routes.
>
> - Has many `routes` as fromCity
> - Has many `routes` as toCity

### Routes

| Column       | Type      | Constraints | Fillable |
| ------------ | --------- | ----------- | -------- |
| id           | bigint    | PK          | -        |
| from_city_id | bigint    | FK(cities)  | ✓        |
| to_city_id   | bigint    | FK(cities)  | ✓        |
| price        | integer   | -           | ✓        |
| created_at   | timestamp | nullable    | -        |
| updated_at   | timestamp | nullable    | -        |

> Depends on `cities` table. Represents bus routes between two cities.
>
> - Belongs to `cities` as fromCity
> - Belongs to `cities` as toCity
> - Has many `trips`

### Trips

| Column         | Type      | Constraints       | Fillable |
| -------------- | --------- | ----------------- | -------- |
| id             | bigint    | PK                | -        |
| bus_id         | bigint    | FK(buses)         | ✓        |
| route_id       | bigint    | FK(routes)        | ✓        |
| departure_time | datetime  | -                 | ✓        |
| arrival_time   | datetime  | -                 | ✓        |
| status         | string    | default:scheduled | ✓        |
| created_at     | timestamp | nullable          | -        |
| updated_at     | timestamp | nullable          | -        |

> Depends on `buses` and `routes` tables. Represents scheduled trips.
>
> - Belongs to `buses`
> - Belongs to `routes`
> - Has many `transactions`

### Transactions

| Column             | Type      | Constraints     | Fillable |
| ------------------ | --------- | --------------- | -------- |
| id                 | bigint    | PK              | -        |
| trip_id            | bigint    | FK(trips)       | ✓        |
| customer_name      | string    | -               | ✓        |
| customer_contact   | string    | -               | ✓        |
| quantity           | integer   | default:1       | ✓        |
| total_price        | integer   | -               | ✓        |
| payment_status     | string    | default:pending | ✓        |
| transaction_status | string    | default:pending | ✓        |
| notes              | text      | nullable        | ✓        |
| created_at         | timestamp | nullable        | -        |
| updated_at         | timestamp | nullable        | -        |

> Depends on `trips` table. Represents ticket bookings/transactions.
>
> - Belongs to `trips`
> - Has access to route and bus info through trip relationship

## Migration Order

The migrations should be executed in this order to maintain referential integrity:

1. `create_users_table.php` - Default Laravel auth
2. `create_buses_table.php` - Independent table
3. `create_cities_table.php` - Independent table
4. `create_routes_table.php` - Depends on cities
5. `create_trips_table.php` - Depends on buses and routes
6. `create_transactions_table.php` - Depends on trips

## Routes List

### Web Routes (Blade Views)

| Method | URI           | Name               | Description               |
| ------ | ------------- | ------------------ | ------------------------- |
| GET    | /dashboard    | dashboard.index    | Dashboard with statistics |
| GET    | /buses        | buses.index        | List all buses            |
| GET    | /cities       | cities.index       | List all cities           |
| GET    | /routes       | routes.index       | List all routes           |
| GET    | /trips        | trips.index        | List all trips            |
| GET    | /transactions | transactions.index | List all transactions     |

### Resource Routes

- `buses` - Full CRUD for buses
- `cities` - Full CRUD for cities
- `routes` - Full CRUD for routes
- `trips` - Full CRUD for trips
- `transactions` - Full CRUD for transactions

### Custom Routes

| Method | URI                                | Name                | Description          |
| ------ | ---------------------------------- | ------------------- | -------------------- |
| PATCH  | /transactions/{transaction}/cancel | transactions.cancel | Cancel a transaction |

## Installation

1. Clone the repository

```bash
git clone https://github.com/yourusername/bus-ticket-booking.git
```

2. Install dependencies

```bash
pnpm install
```

3. Copy environment file

```bash
cp .env.example .env
```

4. Generate application key

```bash
php artisan key:generate
```

5. Run migrations with seeders

```bash
php artisan migrate --seed
```

## Development

- Built with Laravel 10
- Uses Tailwind CSS for styling
- Uses Blade for templating
- Uses MySQL/MariaDB for database

## Status Enums

### Payment Status

- `pending` - Menunggu Pembayaran
- `paid` - Sudah Dibayar
- `expired` - Kadaluarsa
- `failed` - Gagal
- `refunded` - Dikembalikan

### Transaction Status

- `pending` - Menunggu Konfirmasi
- `confirmed` - Dikonfirmasi
- `completed` - Selesai
- `cancelled` - Dibatalkan

### Trip Status

- `scheduled` - Terjadwal
- `departed` - Berangkat
- `arrived` - Sampai
- `cancelled` - Dibatalkan

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
