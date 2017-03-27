# Tuition.io pre-employment project

## Setup

setup the database

```
php artisan migrate:refresh
```

seed the database

```
php artisan db:seed
```

## Create an Administrator

```
php artisan administrator:create {email} {password}
```

## Run it

```
php artisan serve
```

## TODOS

* unit tests
* use webpack for transpiling, bundling, minification.
* use es6 classes to organize into multiple files instead of one monolith.
* encapsulate axios in an api service.
* convert Auth object to a VUEX object.
* highlight field with error message.
* move error messages closer to the field with the errors.
* allow browser refresh.
