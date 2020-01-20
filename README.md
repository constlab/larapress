# LaraPress

Пакет генерирующий REST API CRUD для модели

## Установка

1. `composer require constlab/larapress`

## Функуионал

## Посты

**Модель**: `\LaraPress\Post\Post`

| URL  | Method | Controller |
| ------------- | ------------- | ------------- |
| /api/posts  | GET \| HEAD  | `\LaraPress\Post\Controllers\PostIndexController` |
| /api/posts/{id-or-slug}  | GET \| HEAD  | `\LaraPress\Post\Controllers\PostViewController` |
| /api/posts  | POST \| HEAD  | `\LaraPress\Post\Controllers\PostCreateController` |
| /api/posts/{id}  | PUT \| HEAD  | `\LaraPress\Post\Controllers\PostUpdateController` |
| /api/posts/{id}  | DELETE \| HEAD  | `\LaraPress\Post\Controllers\PostDeleteController` |

## Страницы

**Модель**: `\LaraPress\Page\Page`

| URL  | Method | Controller |
| ------------- | ------------- | ------------- |
| /api/pages  | GET \| HEAD  | `\LaraPress\Post\Controllers\PostIndexController` |
| /api/pages/{id-or-slug}  | GET \| HEAD  | `\LaraPress\Post\Controllers\PostViewController` |
| /api/pages  | POST \| HEAD  | `\LaraPress\Post\Controllers\PostCreateController` |
| /api/pages/{id}  | PUT \| HEAD  | `\LaraPress\Post\Controllers\PostUpdateController` |
| /api/pages/{id}  | DELETE \| HEAD  | `\LaraPress\Post\Controllers\PostDeleteController` |

## Создание нового типа записи

1. Создать модель наследующую класс `\LaraPress\Post\Post`
2. Добавить новый тип записи в конфиг `larapress.php` (где `wiki` название типа записи)

```php
<?php

return [

    'post_types' => [

        'wiki' => [
            'model' => \App\Models\WikiPost::class,
        ],

    ]
];
```
