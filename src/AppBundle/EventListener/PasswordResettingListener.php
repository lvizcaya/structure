<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\EventListener\ResettingListener;
use FOS\UserBundle\Event\FormEvent;

class PasswordResettingListener extends ResettingListener
{
    /**
     * {@inheritdoc}
     */
    public function onResettingResetSuccess(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        $user->setConfirmationToken(null);
        $user->setPasswordRequestedAt(null);
    }
}