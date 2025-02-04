<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use app\Events\GiftcardPurchases;
use App\Models\TimelineEvent;
use App\Models\Giftsend;
use Illuminate\Support\Facades\Log;
class ListenerGiftcardPurchases
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
    public function handle(GiftcardPurchases $event)
    {
       $transaction_result = Giftsend::where('transaction_id',$event->transaction_entry['transaction_id'])->first()->toArray();
    //    $giftcardnumber = implode(",",$event->GeneratedGiftcards) ;
    try {
        TimelineEvent::create([
            'patient_id' => $transaction_result['gift_send_to'], 
            'event_type' => 'Giftcard Purchase',
            'subject' => 'Giftcards Transaction',
            'metadata' => "Giftcard purchases for".$transaction_result['gift_send_to']."<br> Giftcards:"

        ]);
        Log::info('Timeline event stored', ['transaction_id' => $event->transaction_entry['transaction_id']]);
    }catch (\Exception $e) {
        Log::error('Failed to store timeline event', ['error' => $e->getMessage()]);
    }
    }
}
