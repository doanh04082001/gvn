# DOCUMENTATION

## Languages / Environment
- PHP >= 7.4
- HTML / CSS / Bootstrap4
- Apache > 2.4 or NginX
- MySQL8 or MariaDB 10.4

## Docker
- If you build environment via Docker then you can download **laravel-docker-ubuntu** at [Docker](https://github.com/dongttfd?tab=repositories&q=docker), contact with owner to build

## Change configuration at ```.env``` file
```
# DB configuration
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

# Sonar configuration
SONAR_SERVER='http://localhost:9000'
SONAR_TOKEN
SONAR_ACCOUNT
SONAR_PASSWORD

# Firebase configuration
FIREBASE_DATABASE_URL=
FIREBASE_CREDENTIALS='storage/firebase/<firebase-service-acount>.json'
FIREBASE_CLIENT_CREDENTIALS='storage/firebase/<firebase-client>.json'

# Superadmin account
SUPER_ADMIN_ID=
SUPER_ADMIN_PASSWORD=

# Google map key
MIX_GOOGLE_MAPS_API_KEY=

# Datatable language
MIX_DATATABLE_LANGUAGE="/vendor/datatables/${APP_LANG}.json"

# JWT key
JWT_SECRET=

```

## Start run
- Copy ```.env.example``` to ```.env```
- **To install php packages:** Run ```composer install```
- **To Build js, css for Admin:** Run ```npm run watch```
- **Generate app key:** Run ```php artisan key:generate```
- **Generate JWT key:** Run ```php artisan jwt:secret```

## Packages

#### Dev packagess
- IDE: [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
- Debug: [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)

#### Project packages

- Repository: [prettus/l5-repository](https://github.com/andersao/l5-repository)
- Api Document Generateor: [knuckleswtf/scribe](https://github.com/knuckleswtf/scribe)
- Permission package: [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
- Laravel adminlte: [jeroennoten/laravel-adminlte](https://github.com/jeroennoten/Laravel-AdminLTE)
- JWT auth: [tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth)
- jQuery DataTables API for Laravel: [yajra/laravel-datatables-oracle](https://github.com/yajra/laravel-datatables)
- Firebase for Laravel: [kreait/laravel-firebase](https://github.com/kreait/laravel-firebase)

## Note for developer
- **To Fix VsCode && PHP Intelephense:** If you have been use VSCode and using [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client) package then you need run ```php artisan ide-helper:generate``` to fix *Facade Class* loader, that is using [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper) for Development which imported project
- **To Generate Api Document:** Run command to upgrade document of Api ```php artisan scribe:generate``` and check at: ```http://<your-host>/docs```
- **To Generate Repository:** Run command to generate Repository ```php artisan make:repository <model-name> ```. Optional to skip migrations and model: ```--skip-migration --skip-model```
- **How To write css/js/images?** [Tutorial link](https://youtu.be/gSE_lVoIsl0)
- **How To implement laravel-permission?** [Tutorial link](https://youtu.be/h9siajPO5VU)

## Deploy
- Install packages if have new packages: ```composer install```
- Generate new API docs: ```php artisan scribe:generate```
- Refresh permissions if have new upgrade permissions: ```php artisan db:seed --class=RoleAndPermissionSeeder```

## Code smells checking
- Download sonarqube-docker and install (read on README): [Sonarqube Webserver on Docker](https://github.com/dongttfd/sonarqube-docker)
- Create Project on Sonarqube Page: [http://localhost:9000](http://localhost:9000) with login account `admin/admin`
- Install [SonarScanner](https://docs.sonarqube.org/latest/analysis/scan/sonarscanner/) to scan project. This project success to install SonarScanner via  [sonarqube-scanner npm packages](https://www.npmjs.com/package/sonarqube-scanner), please `run npm install`
- Edit **sonar scanner** configuration at file `sonarqube-scanner.js`
```
serverUrl: 'http://localhost:9000', // your Sonarqube Page URL
token: "<project-token>", // create from project (step 2)
```
- To scan project run: `npm run sonarqube`
- Go to Project at your Sonar Page and check code smell
#### **Note**: Recommend run on branch `develop` at the first running

## Other Documents
[Laravel document](https://laravel.com/docs)
#   g v n  
 