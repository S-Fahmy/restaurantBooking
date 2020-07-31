<?php

namespace Tests;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->disableExceptionHandling();
    }

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler
        {
            public function __construct()
            {
            }
            public function report(\Throwable $e)
            {
            }
            public function render($request, \Throwable $e)
            {
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }





    public function create($className, $attributes = [], $times = null)
    {

        return factory($className, $times)->create($attributes);
    }

    public function make($className, $attributes = [], $times = null)
    {

        return factory($className, $times)->make($attributes);
    }

    // public function signIn($user = null)
    // {

    //     $user = $user ?: $this->create('App\User');

    //     $this->actingAs($user);

    //     return $user;
    // }
}
