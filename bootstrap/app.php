<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();
$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    App\Contracts\Repository\WalletRepositoryInterface::class,
    App\Repository\WalletRepository::class
);

$app->singleton(
    App\Contracts\Repository\UserRepositoryInterface::class,
    App\Repository\UserRepository::class
);

$app->singleton(
    App\Contracts\Repository\TransactionRepositoryInterface::class,
    App\Repository\TransactionRepository::class
);

$app->singleton(
    App\Contracts\Services\User\Payment\ServiceInterface::class,
    function ($app) {
        return new App\Services\Transference\Request\Service(
            $app->make(App\Contracts\Services\Transference\ServiceInterface::class),
            $app->make(App\Contracts\Services\User\Payment\ValidatorInterface::class),
            $app->make(App\Contracts\Services\Transference\Message\RabbitMQPublisherInterface::class)
        );
    }
);

$app->singleton(
    App\Contracts\Services\Transference\ServiceInterface::class,
    function ($app) {
        return new App\Services\Transference\Service(
            $app->make(App\Contracts\Repository\TransactionRepositoryInterface::class),
            $app->make(App\Contracts\Repository\WalletRepositoryInterface::class)
        );
    }
);

$app->bind(
    App\Contracts\Services\User\Payment\ValidatorInterface::class,
    function ($app) {
        return new App\Services\Transference\Request\Validator(
            $app->make(App\Contracts\Repository\WalletRepositoryInterface::class)
        );
    }
);

$app->bind(
    App\Contracts\Services\User\Payment\Request\ResolverInterface::class,
    function ($app) {
        return new App\Services\Transference\Request\HttpRequest\Handler(
            $app->make(App\Contracts\Repository\UserRepositoryInterface::class),
            $app->make(App\Contracts\Services\User\Payment\ServiceInterface::class)
        );
    }
);

$app->bind(
    App\Contracts\Services\Transference\Message\RabbitMQPublisherInterface::class,
    App\Services\Transference\Message\RabbitMQPublisher::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration driectory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');
$app->configure('amqp');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(Prettus\Repository\Providers\LumenRepositoryServiceProvider::class);
$app->register(Anik\Amqp\ServiceProviders\AmqpServiceProvider::class);
// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
