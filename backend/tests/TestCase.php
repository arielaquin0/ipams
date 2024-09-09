<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected ?string $authToken = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');

        $this->authenticate();
    }

    protected function authenticate(): void
    {
        $response = $this->post('/api/login', [
            'username' => 'admin',
            'password' => '123456',
            'clientIp' => '127.0.0.1',
        ]);

        $response->assertStatus(ResponseAlias::HTTP_OK);

        $this->authToken = $response->json('token');
    }

    public function withCustomToken(): self
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'token' => "{$this->authToken}"
       ]);

        return $this;
    }
}
