# Paginating with `groupBy`

See https://old.reddit.com/r/laravel/comments/ktk8y1/since_groupby_doesnt_work_with_pagination_would_i/

## Running

```
git clone git@github.com:AlbinoDrought/example-ktk8y1-laravel-paginated-groupby.git
cd example-ktk8y1-laravel-paginated-groupby
# The below steps can be run automatically with `make`, if you have it available
cp .env.example .env
composer install
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

Visit:

- http://localhost:8000/api/activities?mode=grouped : grouping by created_at
- http://localhost:8000/api/activities?mode=collection-group : no SQL group by, grouping inside Laravel
- http://localhost:8000/api/activities?mode=collection-group-ignore-dupes : SQL DISTINCT, at most one record per thing per day
- http://localhost:8000/api/activities?mode=ignore-dupes : SQL DISTINCT, at most one record per thing per day, ungrouped by API

See [ActivityController.php](./app/Http/Controllers/ActivityController.php)
