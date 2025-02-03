<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\TimelineEvent;
class GiftcardPurchases
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        TimelineEvent::create([
            'patient_id' => $event->buyerId,
            'event_type' => 'giftcard_purchased',
            'subject_type' => get_class($event->giftcard),
            'subject_id'   => $event->giftcard->id,
            'metadata' => json_encode([
                'amount' => $event->giftcard->amount,
                'recipient' => $event->giftcard->recipient_id, // if applicable
            ]),
        ]);
    }
}
