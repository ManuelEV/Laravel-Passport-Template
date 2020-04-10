# Laravel-Passport-Template


## Iniciacizar passport-api


- composer install

- npm install

- php artisan key:generate

- php artisan migrate:fresh --seed

- php artisan passport:install --force

- php artisan serve


### Register user - Postman

```json
url: http://localhost:8000/api/register
Headers:
Content-Type: application/x-www-form-urlencoded

Body:

{
    "name": "Your_name",
    "email": "Your_email",
    "password": "Your_password"
}

```

You are going to get a Token to access the API.

### Login user

```json
url: http://localhost:8000/api/login
Headers:
Content-Type: application/x-www-form-urlencoded

Body:

{
    "email": "Your_email",
    "password": "Your_password"
}

```

You are going to get a Token to access the API.

### Access to the API

```json
url: http://localhost:8000/api/user
Headers:
Accept: application/json
Authorization: 'Bearer YOUR_TOKEN'


```

Response:

```json
{
    "id": 2,
    "name": "cliente2",
    "email": "cliente2@mail.com",
    "email_verified_at": null,
    "created_at": "2020-04-04 17:15:07",
    "updated_at": "2020-04-04 17:15:07"
}
```
