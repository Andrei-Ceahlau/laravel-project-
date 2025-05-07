# Laravel E-commerce

Un magazin online simplu construit cu Laravel.

## Cerințe

-   PHP 8.1+
-   Composer
-   Node.js și NPM

## Instalare

1. Clonați repository-ul:

```
git clone https://github.com/Andrei-Ceahlau/laravel-project.git
```

2. Instalați dependențele:

```
composer install
npm install
```

3. Copiați fișierul de mediu:

```
cp .env.example .env
```

4. Generați cheia de aplicație:

```
php artisan key:generate
```

5. Configurați baza de date în fișierul `.env`

6. Rulați migrările și seederii:

```
php artisan migrate --seed
```

## Pornire

Pentru a porni aplicația în mediul de dezvoltare:

```
php artisan serve
```

Pentru compilarea resurselor frontend:

```
npm run dev
```

Accesați aplicația la: http://localhost:8000
