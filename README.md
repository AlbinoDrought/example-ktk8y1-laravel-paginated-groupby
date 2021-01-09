# Paginating with `groupBy`

See https://old.reddit.com/r/laravel/comments/ktk8y1/since_groupby_doesnt_work_with_pagination_would_i/

## Running

```
git clone git@github.com:AlbinoDrought/example-ktk8y1-laravel-paginated-groupby.git
cd example-ktk8y1-laravel-paginated-groupby
cp .env.example .env
composer install
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

Visit http://localhost:8000/api/activities

See [ActivityController.php](./app/Http/Controllers/ActivityController.php)
