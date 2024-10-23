## Coin application

To run this application:

- docker compose build
- docker compose up -d
- open docker container and run: composer install;
- open docker container and run: cp .env.example .env;
- open docker container and run: php artisan key:generate;
- open docker container and run: php artisan migrate 
- open docker container and run: php artisan coins:import

## Test the project

- open docker container and run: `php vendor/bin/phpunit`

## End points

- [Recent prices](http://localhost:8080/api/coins/recent-prices?symbol=btc)
- [Estimated prices](http://localhost:8080/api/coins/estimated-prices?symbol=btc&date=2024-10-22T05:41:59.435Z)

