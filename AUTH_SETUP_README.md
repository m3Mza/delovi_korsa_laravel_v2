# Delovi Korsa - Authentication & Admin System Setup

## Overview
This system implements a complete authentication system with two user types:
- **Kupac (Customer)**: Can register, login, and manage wishlist
- **Admin**: Can manage products (CRUD operations)

## Database Setup

### Step 1: Create the korisnici table
Run the SQL script located at: `database/migrations/create_korisnici_table.sql`

This will create:
- The `korisnici` table with fields: id, ime, prezime, email, lozinka, tip_korisnika, telefon, adresa
- A default admin user with credentials:
  - Email: `admin@delovi-korsa.com`
  - Password: `admin123`

### Step 2: Create the wishlist table
Run the SQL script located at: `database/migrations/create_wishlist_table.sql`

This creates the wishlist table with foreign key relationships to korisnici and proizvodi.

## Features

### Authentication System
- **Login**: `/login`
- **Register**: `/register` (creates kupac users only)
- **Logout**: POST to `/logout`

### Kupac (Customer) Features
- Register new account
- Login/Logout
- Add products to wishlist
- View wishlist at `/wishlist`
- Remove products from wishlist

### Admin Features
- Admin dashboard at `/admin/dashboard`
- View all products
- Create new products at `/admin/create`
- Edit products at `/admin/edit/{id}`
- Delete products
- Admin users must be manually inserted into the database

## Routes

### Public Routes
```
GET  /                  - Home page
GET  /login             - Login form
POST /login             - Process login
GET  /register          - Registration form
POST /register          - Process registration
```

### Authenticated Routes (Kupac)
```
GET    /wishlist              - View wishlist
POST   /wishlist/add/{id}     - Add product to wishlist
DELETE /wishlist/remove/{id}  - Remove product from wishlist
POST   /logout                - Logout
```

### Admin Routes
```
GET    /admin/dashboard       - Admin dashboard (product list)
GET    /admin/create          - Create product form
POST   /admin/store           - Store new product
GET    /admin/edit/{id}       - Edit product form
PUT    /admin/update/{id}     - Update product
DELETE /admin/destroy/{id}    - Delete product
```

## File Structure

### Controllers
- `LoginController.php` - Handles authentication
- `RegisterController.php` - Handles user registration
- `AdminController.php` - Admin panel functionality
- `WishlistController.php` - Wishlist management

### Models
- `Korisnik.php` - User model with authentication
- `Proizvod.php` - Product model with wishlist relationship

### Views
- `auth/login.blade.php` - Login form
- `auth/register.blade.php` - Registration form
- `admin/dashboard.blade.php` - Admin product list
- `admin/create.blade.php` - Create product form
- `admin/edit.blade.php` - Edit product form
- `wishlist/index.blade.php` - User wishlist view

## Configuration

### Auth Configuration
The `config/auth.php` file has been updated to use the `Korisnik` model instead of `User`:

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\Korisnik::class,
    ],
],
```

## Creating Additional Admin Users

To create more admin users, run this SQL query:

```sql
INSERT INTO korisnici (ime, prezime, email, lozinka, tip_korisnika, telefon, adresa) 
VALUES ('Admin', 'Name', 'admin@example.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5kosgVQo/flkW', 'admin', '123456789', 'Address');
```

To generate a new password hash in PHP:
```php
echo password_hash('your_password', PASSWORD_BCRYPT);
```

## Security Notes

1. Admin access is controlled in the `AdminController` constructor
2. Only authenticated users can access wishlist features
3. Passwords are hashed using bcrypt
4. CSRF protection is enabled on all forms
5. The default admin password should be changed after first login

## Testing the System

1. **Test Registration**:
   - Go to `/register`
   - Create a new kupac account
   - You should be logged in automatically

2. **Test Login**:
   - Go to `/login`
   - Use the credentials you created or the default admin account

3. **Test Admin Panel** (as admin):
   - Login with admin credentials
   - Navigate to `/admin/dashboard`
   - Create, edit, and delete products

4. **Test Wishlist** (as kupac):
   - Login as a kupac user
   - Add products to wishlist
   - View wishlist at `/wishlist`
   - Remove products from wishlist

## Troubleshooting

If you encounter authentication issues:
1. Ensure the `korisnici` table exists in your database
2. Check that `config/auth.php` uses `App\Models\Korisnik::class`
3. Clear Laravel cache: `php artisan config:clear`
4. Verify the password field in Korisnik model uses 'lozinka'

## Next Steps

Consider adding:
- Password reset functionality
- Email verification
- Profile editing for users
- Product images upload
- Shopping cart integration with checkout
- Order management system
