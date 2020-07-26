# Backend-Products

## Installation

1. Git clone the project
2. Run "composer install" to install all its dependencies
3. Copy .env-example to a new file called .env and set DB credentials(Create a new DB)
4. Run "php artisan key:generate" in the console
5. Run "php artisan migrate" in the console
6. Run "php artisan passport:install" in the console
7. You can run "php artisan db:seed" if you choose to test fake data
8. Run the project "php artisan serve" in the root directory to run locally your project
9. Optionally, you can use Postman importing the file called "endpoint-testing.json"

## Endpoints

### GET /api/product
- Get products according to user's role.
- Examples:
```
> http://127.0.0.1:8000/api/product
```

### POST /api/product
- Create a new product only if user's role is SP.
- Examples:
```
> http://127.0.0.1:8000/api/product
```

### PUT /api/product/{productId}
- Approve an existent not-approved product only if user's role is AP.
- Examples:
```
> http://127.0.0.1:8000/api/product/1
```

### POST /api/user/register
- Create a new user.
- Examples:
```
> http://127.0.0.1:8000/api/user/register
```

### POST /api/user/login
- Login user.
- Examples:
```
> http://127.0.0.1:8000/api/user/register
```

### GET/api/user/logout
- Logout current logged in user.
- Examples:
```
> http://127.0.0.1:8000/api/user/register
```

### Author

Marcus Palombello