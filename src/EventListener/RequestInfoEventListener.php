<?php

namespace App\EventListener;


use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\RequestInfo;
use App\Service\TwilioService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestInfoEventListener implements EventSubscriberInterface
{
    private RequestStack $requestStack;
    private TwilioService $twilioService;

    public function __construct(RequestStack $requestStack, TwilioService $twilioService)
    {
        $this->requestStack = $requestStack;
        $this->twilioService = $twilioService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['sendSmsOnRequestInfoCreation', EventPriorities::POST_WRITE],
        ];
    }

    public function sendSmsOnRequestInfoCreation(ViewEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();


        if ($request->isMethod('POST') && $event->getControllerResult() instanceof RequestInfo) {
            /** @var RequestInfo $requestInfo */
            $requestInfo = $event->getControllerResult();

            // Récupérez les données de l'entité RequestInfo
            $name = $requestInfo->getName();
            $email = $requestInfo->getEmail();
            $phone = $requestInfo->getPhone();
            $message = $requestInfo->getMessage();

            $smsMessage = 'Bonjour M/Me ' . $name . ' (' . $email . '): ' . $message;

            // Envoyez le SMS en utilisant Twilio
            $this->twilioService->sendSMS($phone, $smsMessage);
        }
    }
}
