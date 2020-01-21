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

    /** @test */
    public function it_returns_404_when_post_type_registered_without_model(): void
    {
        $response = $this->get('/api/products');
        $response->assertStatus(404);

        $response = $this->post('/api/products', []);
        $response->assertStatus(404);
    }
}
