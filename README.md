# Laravel Saasy

## Packages

- devdojo/auth
- spatie/laravel-permission
- livewire/volt
- filament/filament
- laravel/cashier

- laravel/sanctum
- lab404/laravel-impersonate
- laravel/folio

## Auth

```bash
php artisan vendor:publish --tag=auth:assets
php artisan vendor:publish --tag=auth:config
php artisan vendor:publish --tag=auth:migrations
```

## Permissions

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# add in config/permission.php
'permission' => App\Models\Permission::class,
'role' => App\Models\Role::class,
```

## Cachier

```bash
php artisan vendor:publish --tag="cashier-migrations"
php artisan vendor:publish --tag="cashier-config"
```

## TODO 

[ ] Fix redirect after user change email in profile.

