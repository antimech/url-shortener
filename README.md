# URL Shortener

A simple URL shortener web app made with Laravel and Vue.js


## Installation

```Shell
git clone https://github.com/antimech/url-shortener.git
cd url-shortener
composer install
npm install
```

Update your `.env` file with the database you want to use:
```diff
-DB_CONNECTION=mysql
-DB_HOST=127.0.0.1
-DB_PORT=3306
-DB_DATABASE=blog
-DB_USERNAME=root
-DB_PASSWORD=
+DB_CONNECTION=sqlite
```

Migrate the database:
```Shell
php artisan migrate
```

Fill the database with random data for demo purposes:
```Shell
php artisan db:seed
```

Run it:
```Shell
php artisan serve
```

```Shell
npm run dev
```


## Testing

```Shell
php artisan test
```
