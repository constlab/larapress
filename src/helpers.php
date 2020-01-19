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
