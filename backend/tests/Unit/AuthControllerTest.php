<?php
use App\Repositories\Auth\AuthRepository;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    private $authRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authRepository =  $this->app->make(AuthRepository::class);
    }

    public function testAuthenticatesUserWithCorrectCredentials()
    {
        $response = $this->authRepository->doLogin([
            'username' => 'admin',
            'password' => '123456',
            'clientIp' => '127.0.0.1',
        ]);

        $this->assertEquals(200, $response['code']);
    }

    public function testDoesNotAuthenticateUserWithIncorrectCredentials()
    {
        $response = $this->authRepository->doLogin([
            'username' => 'admin',
            'password' => 'incorrect',
            'clientIp' => '127.0.0.1',
        ]);

        $this->assertEquals(401, $response['code']);
    }
}
