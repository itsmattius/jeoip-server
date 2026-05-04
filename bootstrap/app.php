<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(strval(env('APP_TIMEZONE', 'UTC')));

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();

$app->configure('app');
$app->configure('geoip');

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Laravel\Lumen\Console\Kernel::class
);
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Laravel\Lumen\Exceptions\Handler::class
);

$app->register(Jeoip\Server\AppServiceProvider::class);
$app->register(Jeoip\Ip2Location\GeoIPServiceProvider::class);
$app->middleware(Jeoip\Server\Http\Middleware\CorsMiddleware::class);

return $app;
