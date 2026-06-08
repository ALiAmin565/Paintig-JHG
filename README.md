# DaiLAS Project

A Laravel application for cataloging and managing the art collection across a hotel. DaiLAS provides a central place to list every painting on display and store detailed information for each piece.

## About

Hotels often display artwork throughout their property — lobbies, corridors, guest rooms, restaurants, and meeting spaces. DaiLAS helps staff and guests browse the full painting inventory and view details such as title, artist, location, medium, dimensions, and other metadata for each work.

## Features

- **Full painting catalog** — List all paintings displayed across the hotel
- **Per-painting details** — View and manage detailed information for each artwork
- **Hotel-wide inventory** — Keep track of where each painting is located on the property

## Tech Stack

- [Laravel](https://laravel.com) — PHP web application framework
- PHP 8.2+
- MySQL / SQLite (configurable via `.env`)

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & npm

### Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

### Development

```bash
composer dev
```

Or run the server manually:

```bash
php artisan serve
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
