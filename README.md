# LaraPress

Пакет генерирующий REST API CRUD для модели

## Установка

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
