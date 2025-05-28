# EduSign 2.0

Système de gestion des présences avec QR codes pour les établissements d'enseignement.

## Structure du projet

Le projet est composé de deux parties principales :

- `edusign-backend/` : Backend Laravel avec API REST
- `edusign-mobile/` : Application mobile React Native (Expo)

## Installation

### Backend

1. Installer les dépendances PHP :
```bash
cd edusign-backend
composer install
```

2. Copier le fichier d'environnement :
```bash
cp .env.example .env
```

3. Générer la clé d'application :
```bash
php artisan key:generate
```

4. Configurer la base de données dans le fichier `.env` :
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edusign
DB_USERNAME=root
DB_PASSWORD=
```

5. Exécuter les migrations :
```bash
php artisan migrate
```

6. Créer un utilisateur administrateur :
```bash
php artisan db:seed
```

### Application Mobile

1. Installer les dépendances :
```bash
cd edusign-mobile
npm install
```

2. **IMPORTANT : Configurer l'URL de l'API**

   Ouvrir le fichier `app/config.ts` et modifier l'URL de l'API avec l'adresse IP de votre machine :
   ```typescript
   export const API_URL = 'http://VOTRE_IP_LOCALE:8000/api';
   ```

   Par exemple, si votre IP locale est 192.168.1.100 :
   ```typescript
   export const API_URL = 'http://192.168.1.100:8000/api';
   ```

   > ⚠️ Ne pas utiliser `localhost` ou `127.0.0.1` car l'application mobile ne pourra pas accéder à l'API. Utilisez toujours l'adresse IP de votre machine sur le réseau local.

## Démarrage

1. Démarrer le backend :
```bash
cd edusign-backend
php artisan serve
```

2. Démarrer l'application mobile :
```bash
cd edusign-mobile
npx expo start
```

3. Scanner le QR code avec l'application Expo Go sur votre appareil mobile

## Fonctionnalités

- Interface web pour les administrateurs
  - Gestion des cours
  - Gestion des séances
  - Génération de QR codes
  - Suivi des présences

- Application mobile pour les étudiants
  - Scanner les QR codes
  - Voir les séances
  - Gérer les présences

## Technologies utilisées

- Backend
  - Laravel 10
  - MySQL/SQLite
  - PHP 8.1+

- Mobile
  - React Native
  - Expo
  - TypeScript

