## Coin application

To run this application:

- docker compose build
- docker compose up -d

Open docker container and run:
  - composer install;
  - cp .env.example .env;
  - php artisan key:generate;
  - php artisan migrate 
  - php artisan queue:work
  - php artisan coins:import

## Test the project

- open docker container and run: `php vendor/bin/phpunit`

## End points
### Live
- [Recent prices](https://seashell-app-ql5jf.ondigitalocean.app/api/coins/recent-prices?symbol=BTC)
- [Estimated prices](https://seashell-app-ql5jf.ondigitalocean.app/api/coins/estimated-prices?symbol=BTC&date=2024-10-24T05:19:47.475Z)

### Local
- [Recent prices](http://localhost:8080/api/coins/recent-prices?symbol=btc)
- [Estimated prices](http://localhost:8080/api/coins/estimated-prices?symbol=btc&date=2024-10-22T05:41:59.435Z)

<img width="908" alt="Captura de Tela 2024-10-22 às 22 32 27" src="https://github.com/user-attachments/assets/307d3bf6-42dc-470b-943a-400541b132e1">
<img width="929" alt="Captura de Tela 2024-10-22 às 22 32 42" src="https://github.com/user-attachments/assets/091b6e95-a167-4f2d-ae4b-1650d231654a">
