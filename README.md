<p align="center"><a href="https://ws-floor.waliczek.org" target="_blank"><img src="https://user-images.githubusercontent.com/5287607/133910770-3fe774f9-2cc0-4835-8191-6a6f679b9eb5.png" width="400"></a></p>

<p align="center">
<a href="https://opensource.org/licenses/MIT" target="_blank"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About ws-floor-backend

ws-floor-backend is a API service based on Laravel. It is build to serve backend for [ws-floor](https://ws-floor.waliczek.org) application. It has been build to help managing small and medium wekshop garages with focuse on updating customers on repair progress via emails. 

## How to use
### Clone repo:
`git clone https://github.com/majster-pl/ws-floor-backend.git`

### Install dependiencies:
`composer install --ignore-platform-reqs`

### Create .env file:
`cp .env.example .env`

### Generate APP_KEY
Generate application key using command below and enter generated key to .env file.

`php artisan key:generate`

### Setup folder permissions:
`chmod -R 755 storage`
`chmod -R 755 vendor`

### Setup public folder
loging to you server and run:
`php artisan storage:link`
above command will create link to storage/app/public folder

### Setup .env file
Change below in .env file:

	APP_KEY='read above how to generate app key'
	APP_ENV=local 'change to production if necessary'
	WEBAPP_URL="http://localhost:3000" - set to your webapp url
	ADMIN_HTTPS=true - if not set correctly you might not be able to login to admin panel
	DB_DATABASE='database name'
	DB_USERNAME='database user name'
	DB_PASSWORD='passowrd to database'
	# Pusher creditionals, can be found here: https://pusher.com/
	PUSHER_APP_ID=
    PUSHER_APP_KEY=
	PUSHER_APP_SECRET=
	PUSHER_APP_CLUSTER=mt1
	# Make sure you set your domain name where you want to run the API server, if local set to localhost if elsewhere enter your IP or domain name.
	SESSION_DOMAIN='your_domain.com (without quotes)'
	SANCTUM_STATEFUL_DOMAINS="your_domain.com (without quotes)"
	# [Mail setup] - to make sure notification emails are sent make sure you set mail server setting below
	MAIL_MAILER=
	MAIL_HOST=
	MAIL_PORT=
	MAIL_USERNAME=
	MAIL_PASSWORD=
	MAIL_ENCRYPTION=
	MAIL_FROM_ADDRESS=
	MAIL_FROM_NAME="${APP_NAME}"

## API Settings
You can change session lifetime, timezone by changing below in .env file

    SESSION_LIFETIME=30
    TIMEZONE=(change if different then Europe/London)

### API installation:
To finish installation run build in command and follow instrucions on screen.
This command will create migarions and create fake data if you choose to.
`php artisan api-install` 



## Contributing

Any contribution is always welcome!

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to Szymon Waliczek via [waliczek.szymon@gmail.com](mailto:waliczek.szymon@gmail.com).

## License

The ws-floor-backend is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
