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