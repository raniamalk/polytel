<?php

namespace AppBundle\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {

        $menu = $event->getMenu();

        $newSubmenu = $menu
            ->addChild('new')
            ->setLabel('Administration du site')
        ;


        /*$newSubmenu
            ->addChild('new-subitem')
            ->setLabel('Custom Admin Menu Itemu')
        ;*/

        $newSubmenu
            ->addChild('Qui sommes-nous?', ['route' => 'presentation_list'])
            ->setLabel('Qui sommes-nous?')
            ->setLabelAttribute('icon', 'file')
        ;

        $newSubmenu
            ->addChild('Mot president', ['route' => 'motpresident_list'])
            ->setLabel('Mot president')
            ->setLabelAttribute('icon', 'folder')
        ;

        $newSubmenu
            ->addChild('Informations de contact', ['route' => 'infocontact_list'])
            ->setLabel('Informations de contact')
            ->setLabelAttribute('icon', 'phone')
        ;

        $newSubmenu
            ->addChild('Slider', ['route' => 'slider_list'])
            ->setLabel('Slider')
            ->setLabelAttribute('icon', 'slideshare')
        ;

        $newSubmenu
            ->addChild('Bannière', ['route' => 'banniere_list'])
            ->setLabel('Bannière')
            ->setLabelAttribute('icon', 'slideshare')
        ;

        $newSubmenu
            ->addChild('Newsletter', ['route' => 'newsletter_list'])
            ->setLabel('Newsletter')
            ->setLabelAttribute('icon', 'at')
        ;

        $newSubmenu
            ->addChild('Telechargement', ['route' => 'telechargement_list'])
            ->setLabel('Telechargement')
            ->setLabelAttribute('icon', 'print')
        ;

        $newSubmenu
            ->addChild('Marques', ['route' => 'marque_list'])
            ->setLabel('Marques')
            ->setLabelAttribute('icon', 'delicious')
        ;

        $newSubmenu
            ->addChild('Texte de la page marque', ['route' => 'textmarque_list'])
            ->setLabel('Texte de la page marque')
            ->setLabelAttribute('icon', 'folder')
        ;

        $newSubmenu
            ->addChild('Certificat', ['route' => 'certificat_list'])
            ->setLabel('Certificat')
            ->setLabelAttribute('icon', 'certificate')
        ;

        $newSubmenu
            ->addChild('Tarifs', ['route' => 'tarif_list'])
            ->setLabel('Tarifs')
            ->setLabelAttribute('icon', 'dollar')
        ;

        $newSubmenu
            ->addChild('CGV', ['route' => 'cgv_list'])
            ->setLabel('CGV')
            ->setLabelAttribute('icon', 'book')
        ;

        $newSubmenu
            ->addChild('SAV', ['route' => 'sav_list'])
            ->setLabel('SAV')
            ->setLabelAttribute('icon', 'book')
        ;

        $newSubmenu
            ->addChild('Messages', ['route' => 'contact_list'])
            ->setLabel('Messages')
            ->setLabelAttribute('icon', 'envelope')
        ;

        $newSubmenu
            ->addChild('Catalogues', ['route' => 'catalogue_list'])
            ->setLabel('Catalogues')
            ->setLabelAttribute('icon', 'book')
        ;

        $newSubmenu
            ->addChild('Pages', ['route' => 'pages_list'])
            ->setLabel('Pages de catalogue')
            ->setLabelAttribute('icon', 'file')
        ;

        $newSubmenu
            ->addChild('Devis', ['route' => 'devis_list'])
            ->setLabel('Devis')
            ->setLabelAttribute('icon', 'envelope')
        ;

    }
}
