<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $accountSid;
    private $authToken;
    private $twilioPhoneNumber;

    public function __construct($accountSid, $authToken, $twilioPhoneNumber)
    {
        $this->accountSid = $accountSid;
        $this->authToken = $authToken;
        $this->twilioPhoneNumber = $twilioPhoneNumber;
    }

    public function sendSMS($to, $message)
    {
        $client = new Client($this->accountSid, $this->authToken);

        $client->messages->create(
            $to,
            [
                'from' => $this->twilioPhoneNumber,
                'body' => $message,
            ]
        );
    }
}
