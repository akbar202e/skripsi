# AI Agent Instructions for UPT2 Project

## Project Overview
This is a Laravel-based web application using the Filament admin panel and Spatie Roles & Permissions for access control. The project is a request management system ("Permohonan") with user roles and workflow states. It includes features for managing requests, user roles, and permissions.

## Key Architecture Components
- **Models**: Located in `app/Models/`
  - `Permohonan.php`: Core request model with soft deletes and relationships to users.
  - `User.php`: User model with role-based permissions.
  - `JenisPengujian.php`: Represents testing types, linked to requests.
- **Admin Panel**: Built with Filament v3 in `app/Filament/`
  - Resources define CRUD interfaces and forms.
  - Uses Heroicons for navigation (`heroicon-o-*` naming pattern).
- **Access Control**: Implemented via `filament-spatie-roles-permissions`.
  - Policies in `app/Policies/`.
  - Role/permission configuration in `config/filament-spatie-roles-permissions.php`.
- **Observers**: Lifecycle events are handled by observers, e.g., `PermohonanObserver` for request state changes.

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

4. **Testing**:
   - PHPUnit tests are located in `tests/`.
   - Run tests with:
     ```bash
     php artisan test
     ```

## Project Patterns
1. **Model Observers**:
   - Example: `PermohonanObserver` handles request state changes.
   - Register observers in `AppServiceProvider.php`.

2. **Resource Forms**:
   - Follow Filament's form schema pattern:
     ```php
     Forms\Components\TextInput::make('field')
         ->required()
         ->maxLength(100)
         ->columnSpanFull();
     ```

3. **Relationships**:
   - Use type-hinted return types:
     ```php
     public function relationName(): BelongsTo
     {
         return $this->belongsTo(RelatedModel::class);
     }
     ```

4. **Policies**:
   - Policies are located in `app/Policies/` and enforce access control rules.

## Common Gotchas
1. Run migrations after model changes.
2. Register Filament resources in `config/filament.php`.
3. Clear cache after updating roles/permissions:
   ```bash
   php artisan cache:clear
   ```
4. Ensure `vite.config.js` is correctly configured for asset compilation.

## Key Dependencies
- PHP 8.2+
- Laravel 12.x
- Filament 3.3
- Spatie Roles & Permissions (via althinect/filament-spatie-roles-permissions)

## Additional Notes
- **Database Migrations**: Custom migrations are located in `database/migrations/`.
- **Seeders**: Example data is seeded via `database/seeders/`.
- **Testing Types**: `JenisPengujian` model and seeder manage testing types.
- **File Uploads**: Requests (`Permohonan`) support file uploads, managed in the `add_files_and_status_to_permohonans_table` migration.