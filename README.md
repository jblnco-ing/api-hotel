# Laravel api-hotel

Features Provided
- Permissions and roles
	- Admin (all permissions)
	- Employee
		- Create employees
		- Edit room capacity
		- Create room records (create reservation)
		- Edit room records (edit reservation)
		- View self data
	- Client
		- View self data
	- Anyone
		- View rooms list
		- View a room
- Room management
- Employee management

Technologies
- [spatie/laravel-permission](https://spatie.be/docs/laravel-permission/v4/introduction)
- [DarkaOnLine/L5-Swagger](https://laravel.com/docs/7.x/passport)
- [laravel/passport](https://laravel.com/docs/7.x/passport)

# Install

- RENAME `project/.env.example` to `.env`
- EDIT `API_HOST_LOCAL` in `.env`
- RUN `composer install`
- RUN  `php artisan migrate --seed`
- RUN  `php artisan passport:install`

# Run

- RUN  `php artisan serve`
- OPEN [http://localhost:8000](http://localhost:8000)

# View Documentation

- RUN  `php artisan l5-swagger:generate`
- OPEN [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

# Author

[Joel Blanco](https://jblnco.herokuapp.com)
