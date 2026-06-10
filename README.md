# Painting JHG

A Laravel application for cataloging and managing the art collection across JHG hotels. Painting JHG provides a central place to list every painting on display and store detailed information for each piece.

## About

Painting JHG helps staff browse the full painting inventory across all JHG hotel properties. Each painting record includes photo, title, painter, price, media, production year, dimensions (with/without frame), flexible location assignment, ownership and purchase details, certificate of authenticity (text or file), and notes.

Hotels are seeded from the same JHG property list used in MividaSpa-JHG (46 properties). Custom locations can be created by any logged-in user when assigning paintings.

## Roles

| Role | Access |
|---|---|
| **Admin** | Dashboard KPIs, user management, location delete, full painting CRUD |
| **User** | Full painting CRUD, locations list/create/edit, search/create locations when assigning paintings |

After login, admins land on the dashboard; users land on the paintings list.

## Painting Data Fields

| Field | Type |
|---|---|
| Photo | BLOB (stored in database) |
| Title | String |
| Painter Name | String (required) |
| Price | Decimal (required) |
| Currency | USD, EUR, GBP, EGP, AED, SAR |
| Media | String |
| Production Year | Number |
| Width With Frame | Number (cm) |
| Height With Frame | Number (cm) |
| Width Without Frame | Number (cm) |
| Height Without Frame | Number (cm) |
| Location Type | Hotel / Other Location / N/A |
| Location | Hotel (search) or custom Location (search + create) |
| Owned By | String |
| Purchased By | String |
| Purchased From | String |
| Paid By | String |
| Certificate | Text or file upload (PDF/images) |
| Notes | Added on painting view page only (author + timestamp) |

## Features

- **Login-only access** — No public registration; users are managed by admins
- **Role-based navigation** — Admin dashboard, user management, and locations CRUD for admins
- **Flexible locations** — Assign paintings to hotels, custom locations, or N/A
- **Full painting CRUD** — Create, view, edit, and delete paintings with photo upload
- **Search APIs** — `GET /api/hotels` and `GET /api/locations` for live pickers; `POST /api/locations` for quick-create
- **Filters** — Search and filter paintings by location type, hotel, location, painter, and price

## Default Users

| Username | Password | Role | Email |
|---|---|---|---|
| `admin` | `password123` | Admin | admin@painting-jhg.com |
| `manager` | `password123` | User | manager@painting-jhg.com |
| `venus` | `basjhg@2026` | User | venus@painting-jhg.com |

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
php artisan storage:link
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
