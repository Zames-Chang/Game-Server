<?php

use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function apiAs($method, $uri, array $data = [], array $headers = [], $user = null)
    {
        $user = $user ? $user : factory(User::class)->create();

        $headers = array_merge(
            ['Authorization' => 'Bearer ' . JWTAuth::fromUser($user)],
            $headers
        );

        return $this->json($method, $uri, $data, $headers);
    }
}
