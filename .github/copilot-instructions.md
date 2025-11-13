# AI Agent Instructions for UPT2 Project

## Project Overview
This is a Laravel-based web application using Filament admin panel and Spatie Roles & Permissions for access control. The project appears to be a request management system ("Permohonan") with user roles and workflow states.

## Key Architecture Components
- **Models**: Located in `app/Models/`
  - `Permohonan.php`: Core request model with soft deletes and relationships to users
  - `User.php`: User model with role-based permissions
- **Admin Panel**: Built with Filament v3 in `app/Filament/`
  - Resources define CRUD interfaces and forms
  - Uses Heroicons for navigation (`heroicon-o-*` naming pattern)
- **Access Control**: Implemented via `filament-spatie-roles-permissions`
  - Policies in `app/Policies/`
  - Role/permission config in `config/filament-spatie-roles-permissions.php`

## Development Workflow
1. **Environment Setup**:
   ```bash
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```

2. **Development Server**:
   ```bash
   php artisan serve
   ```

3. **Asset Compilation**:
   ```bash
   npm install
   npm run dev
   ```

## Project Patterns
1. **Model Observers**: Used for model lifecycle events
   - Example: `PermohonanObserver` handles request state changes
   - Register in `AppServiceProvider.php`

2. **Resource Forms**: Follow Filament's form schema pattern
   ```php
   Forms\Components\TextInput::make('field')
       ->required()
       ->maxLength(100)
       ->columnSpanFull()
   ```

3. **Relationships**: Use type-hinted return types
   ```php
   public function relationName(): BelongsTo
   {
       return $this->belongsTo(RelatedModel::class);
   }
   ```

## Testing
- PHPUnit tests in `tests/` directory
- Run tests with: `php artisan test`

## Common Gotchas
1. Remember to run migrations after model changes
2. Filament resources must be registered in `config/filament.php`
3. Role permissions require cache clearing after updates:
   ```bash
   php artisan cache:clear
   ```

## Key Dependencies
- PHP 8.2+
- Laravel 12.x
- Filament 3.3
- Spatie Roles & Permissions (via althinect/filament-spatie-roles-permissions)