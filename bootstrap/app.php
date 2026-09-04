<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TrackWebsiteVisit;
use App\Http\Middleware\EnsureLandingSubscriptionPaid;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(function () {
        require __DIR__.'/../routes/web.php';
    }, commands: __DIR__.'/../routes/console.php', health: '/up')
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(EnsureLandingSubscriptionPaid::class);
        $middleware->append(TrackWebsiteVisit::class);
    })
    ->withExceptions(function ($exceptions): void {
        //
    })->create();
