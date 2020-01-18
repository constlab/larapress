<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class PostTypeWithoutModelTest extends TestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('larapress.post_types.product', []);
    }

    public function testForCheckingRoutes(): void
    {
        $response = $this->get('/api/products');
        $response->assertStatus(404);

        $response = $this->post('/api/products', []);
        $response->assertStatus(404);
    }
}
