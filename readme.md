# orders-management-platform

## Requirements
1. PHP >= 7.0.0
2. OpenSSL PHP Extension
3. PDO PHP Extension
4. Mbstring PHP Extension
5. Tokenizer PHP Extension
6. XML PHP Extension
7. Installed composer
7. Installed nodejs and npm

## Installing
1. Clone this repository
2. Open terminal and run ```composer install``` to install all 
server side dependencies
3. Run ```npm install``` to install all js packages.
4. Duplicate ```.env.example``` file from root and name it ```.env```
5. Open ```.env``` and make configuration for database and etc.
6. Open terminal and run ````php artisan migrate```` to build database
tables add ```--seed``` option if you want to populate data in tables
or execute ```php artisan db:seed``` after migrations completed

## Unit tests
1. Open ```phpunit.xml``` in root directory and configure test db

## More commands
1. Run server ```php artisan serve``` and you can open site at 
```http://localhost:8000```
2. Run tests with command ```./vendor/bin/phpunit``` or ```phpunit``` if you have
phpunit installed on your OS.