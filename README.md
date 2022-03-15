### Creation du projet Symfony 5.4 

symfony new ecf-kevin-santander --full --version=5.4
composer require symfony/webpack-encore-bundle
npm install

### Installation de boostrap 
npm install bootstrap

## Ajouter dans le fichier assets/app.js les lignes ci-dessous
import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
npm run build


symfony console make:controller Home

En local, décommenter la bdd 
DATABASE_URL="mysql://root:@127.0.0.1:3306/ecfhotel?serverVersion=5.7&charset=utf8mb4"
lancer la commande : 
php bin/console doctrine:database:create