
# ECF Kevin SANTANDER

Creation of a website for a hotel group that wants to offer the possibility to book from their own website
An administration space is available for managers 


## Requirement

- PHP 8.0 or higher;
- Maria DB
- Npm for the assets build
- And the usual Symfony application requirements.


## Installation

Install my ECF project in local

```bash
  git clone https://github.com/Biglapin/ECF-KEVIN-SANTANDER.git
  cd ECF-KEVIN-SANTANDER/

  #Before continuing the next step, check that you have an .env file with this in it: 
  #APP_SECRET=""
  #DATABASE_URL="mysql://root:@127.0.0.1:3306/ecfhotel"
  #MAILER_DSN=mailjet+smtp://ACCESS_KEY:SECRET_KEY@default

  composer install
  php bin/console doctrine:database:create  
  php bin/console doctrine:migrations:migrate
  composer require symfony/webpack-encore-bundle
  npm install
  npm run watch
  symfony serve
```

Create administrator.

Use de register form /register
In the bdd, add the role ROLE_SUPER_ADMIN

It will be possible to create manager after that on the route /admin.
You can manage role as you want from the admin dashboard.

## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`DATABASE_URL="mysql://root:@127.0.0.1:3306/ecfhotel"`


For security reasons, the Mailjet API accesses are not given here. This works only on the online part 
