<?php

declare(strict_types=1);

/**
 * Get post type name by model class name
 *
 * @param string $modelClassName
 *
 * @return string
 * @noinspection PhpInconsistentReturnPointsInspection
 */
function get_post_type(string $modelClassName): string
{
    $postTypes = config('larapress.post_types', []);
    foreach ($postTypes as $name => $options) {
        if ($options['model'] === $modelClassName) {
            return $name;
        }
    }
    abort(500, "Post type with model {$modelClassName} not found.");
}

/**
 * Get post type names from config
 * Except types without model
 *
 * @return array
 */
function get_post_type_names(): array
{
    $postTypes = config('larapress.post_types', []);
    $postTypes = array_filter($postTypes, function (array $item) {
        return isset($item['model']);
    });
    $postTypes = array_keys($postTypes);
    sort($postTypes);
    return $postTypes;
}
