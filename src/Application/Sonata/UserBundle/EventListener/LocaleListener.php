<?php
namespace Application\Sonata\UserBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class LocaleListener
 * @package Application\Sonata\UserBundle\EventListener
 */
class LocaleListener implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * LocaleListener constructor.
     * @param string $defaultLocale
     */
    public function __construct($defaultLocale = 'fr')
    {
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        if (is_null($request->attributes->get('_locale'))) {
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        } else {
            $request->getSession()->set('_locale', $request->attributes->get('_locale'));
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 15)),
        );
    }
}
