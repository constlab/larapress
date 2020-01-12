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
        $response = $this->get('/api/product');
        $response->assertStatus(404);

        $response = $this->post('/api/product', []);
        $response->assertStatus(404);
    }
}
