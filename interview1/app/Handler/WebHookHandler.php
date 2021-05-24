<?php

namespace App\Handler;

use App\Models\WebhookData;
use Spatie\WebhookClient\ProcessWebhookJob;

class WebHookHandler extends ProcessWebhookJob{

    public function handle(){

        // logger('I was here');

        $data = json_decode($this->webhookCall, true)['payload'];
        
        logger($data);

        $hook = new WebhookData();
        $hook->product_name = $data['product']['product_name'];
        $hook->price = $data['product']['price'];
        $hook->size = $data['product']['size'];
        $hook->quantity = $data['product']['quantity'];
        $hook->save();

    }
}