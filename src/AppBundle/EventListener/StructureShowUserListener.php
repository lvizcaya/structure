<?php
namespace AppBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\ShowUserEvent;

class StructureShowUserListener {
	protected $tokenStorage;

	public function __construct($tokenStorage)
	{
	    $this->tokenStorage = $tokenStorage;
	}

    public function onShowUser(ShowUserEvent $event) {
        $user = $this->getUser();
        $event->setUser($user);
    }

    protected function getUser() {
    	if (null === $token = $this->tokenStorage->getToken()) {
	        return;
	    }
	    if (!is_object($user = $token->getUser())) {
	        return;
	    }
	    return $user;
    }
}
