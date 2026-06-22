# Deployment Guide

Run `composer install --no-dev --optimize-autoloader`, configure `.env`, run `php artisan migrate --force`, link storage, start queue workers, configure cron for `php artisan schedule:run`, and warm caches with `php artisan optimize`.
