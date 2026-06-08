# Painting JHG

A Laravel application for cataloging and managing the art collection across JHG hotels. Painting JHG provides a central place to list every painting on display and store detailed information for each piece.

## About

Painting JHG helps staff browse the full painting inventory across all JHG hotel properties. Each painting record includes photo, title, media, production year, dimensions (with/without frame), location (hotel), ownership and purchase details, and certificate of authenticity.

Hotels are seeded from the same JHG property list used in MividaSpa-JHG (46 properties).

## Painting Data Fields

| Field | Type |
|---|---|
| Photo | BLOB (stored in database) |
| Title | String |
| Media | String |
| Production Year | Number |
| Dimensions With Frame | Number |
| Dimensions Without Frame | Number |
| Location | Hotel (LOV via `/api/hotels`) |
| Owned By | String |
| Purchased By | String |
| Purchased From | String |
| Paid By | String |
| Certificate of Authenticity | String |

## Features

- **Login-only access** — No public registration; users are created via seeder
- **Hotel catalog** — Browse all seeded JHG hotels with painting counts
- **Full painting CRUD** — Create, view, edit, and delete paintings with photo upload
- **Hotels API** — `GET /api/hotels` returns active hotels for location dropdown
- **Filters** — Search and filter paintings by hotel, title, media, and year

## Default Users

| Username | Password | Email |
|---|---|---|
| `admin` | `password123` | admin@painting-jhg.com |
| `manager` | `password123` | manager@painting-jhg.com |

## Tech Stack

- Laravel 13
- PHP 8.3+
- Blade + Tailwind CSS v4 + Vite
- SQLite / MySQL (configurable via `.env`)

## Getting Started

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
```

### Development

```bash
composer dev
```

Visit `/login` and sign in with one of the seeded users above.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
