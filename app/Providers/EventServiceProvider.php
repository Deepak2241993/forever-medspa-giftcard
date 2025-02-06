<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\GiftcardPurchases;
use App\Events\TimelineGiftcardRedeem;
use App\Events\TimelineGiftcardCancel;
use App\Events\ServicePurchases;
use App\Events\ServicePurchasesPayment;


use App\Listeners\ListenerGiftcardPurchases;
use App\Listeners\TimelineLinstnerGiftcardRedee;
use App\Listeners\TimelineLinstnerGiftcardCancel;
use App\Listeners\ListenerServicePurchases;
use App\Listeners\ListenerServicePurchasesPayment;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TimelineGiftcardRedeem::class => [
            TimelineLinstnerGiftcardRedee::class,
        ],
        TimelineGiftcardCancel::class => [
            TimelineLinstnerGiftcardCancel::class,
        ],
        ServicePurchases::class => [
            ListenerServicePurchases::class,
        ],
        ServicePurchasesPayment::class => [
            ListenerServicePurchasesPayment::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
