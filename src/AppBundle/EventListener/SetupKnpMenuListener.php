<?php 

namespace AppBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\KnpMenuEvent;

class SetupKnpMenuListener
{
    protected $auth;

    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    public function onSetupMenu(KnpMenuEvent $event)
    {
        $menu         = $event->getMenu();
        $childOptions = $event->getChildOptions();
        $labelAttributes = ['icon' => 'fa fa-minus'];

        $menu->addChild('MENU', [
            'attributes' => array('class' => 'header'),
            'label' => 'sidebar.title'
        ]);

        $menu->addChild('Dashboard', [
            'route' => 'homepage',
            'label' => 'sidebar.dashboard'
        ])->setLabelAttribute('icon', 'fa fa-dashboard');

         if ($this->auth->isGranted('ROLE_USERS_MENU')) $menu->addChild('sidebar.users', ['route' => 'user_index',])->setLabelAttribute('icon', 'fa fa-users');

        // if ($this->auth->isGranted('ROLE_MESSAGES')) $menu->addChild('sidebar.messages', ['route' => 'messages_inbox',])->setLabelAttribute('icon', 'fa fa-envelope');

        /*if ($this->auth->isGranted('ROLE_ADMIN')) {
            $config = $menu->addChild('sidebar.config', $childOptions)->setLabelAttribute('icon', 'fa fa-gears');
            $config->addChild('sidebar.example', ['route' => 'example_index' , 'labelAttributes' => $labelAttributes]);
        }*/
    }
}
