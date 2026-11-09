<?php

namespace App\Providers;

use App\Events\EnquirySubmitted;
use App\Listeners\LogEnquiryAuditListener;
use App\Listeners\RecordEnquiryAnalyticsListener;
use App\Listeners\SendEnquiryNotificationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected static $shouldDiscoverEvents = false;

    /**
     * @var array<class-string, list<class-string>>
     */
    protected $listen = [
        EnquirySubmitted::class => [
            SendEnquiryNotificationListener::class,
            LogEnquiryAuditListener::class,
            RecordEnquiryAnalyticsListener::class,
        ],
    ];
}
