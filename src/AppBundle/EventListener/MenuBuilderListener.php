<?php
/**
 * Created by PhpStorm.
 * User: r.malk
 * Date: 03/01/2019
 * Time: 09:38
 */

namespace AppBundle\EventListener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
/*use Sylius\Bundle\ShopBundle\Event\MenuBuilderEvent as FrontendMenuBuilderEvent;*/
use Sylius\Bundle\ShopBundle\EventListener as FrontendMenuBuilderEvent;

class MenuBuilderListener
{

    /**
     * @param MenuBuilderEvent $event
     */


    public function addBackendMenuItems(MenuBuilderEvent $event){
        $menu = $event->getMenu();

        $menu->addChild('backend_main')
            ->setLabel('Test Backend Main');


    }

}