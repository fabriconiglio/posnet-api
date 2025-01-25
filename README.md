# POSNET API

API que procesa pagos con tarjetas de crédito (VISA/AMEX).

## Requisitos

- PHP 8.1+
- Laravel 10.x
- Composer

## Instalación

```bash
git clone https://github.com/fabriconiglio/posnet-api
cd posnet-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
