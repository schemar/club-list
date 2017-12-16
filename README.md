# Club List
Club List is a Symfony-based web application for clubs.
It is a member directory. 

## Features
- Listing, sorting, and filtering members
- Member profiles with detailed information
- Setting up custom member statuses
- Invite-only registration

## Set-Up
### Prerequisites
- Web server and PHP process manager (e.g. niginx and php-fpm)
- PHP
- APCu
- MariaDB (or MySQL)

### Development Set-Up
Clone and configure the project
```
git clone git@github.com:schemar/simplest-weather-app.git
cd club-list
composer install
composer dump-autoload --optimize
php app/console doctrine:migrations:migrate
php app/console app:setup
php app/console server:run
```
- Set all required parameters.
- Open `127.0.0.1:8000` in your browser.

### Production Set-Up
Clone and configure the project
```
git clone git@github.com:schemar/simplest-weather-app.git
cd club-list
composer install
composer dump-autoload --optimize
php app/console doctrine:migrations:migrate
php app/console app:setup
```
- Set all required parameters.
- Make sure you use a good secret!
- Create a favicon at `web/favicon.ico`.

Set-up your web server and php process manager.