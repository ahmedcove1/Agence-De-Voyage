<?php

// src/AppBundle/Menu/Builder.php
namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * MenuBuilder en tant que service (cf. http://symfony.com/doc/master/bundles/KnpMenuBundle/menu_builder_service.html)
 *
 */
class MenuBuilder
{
    private $factory;
    private $container;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, Container $container)
    {
        $this->factory = $factory;
        $this->container = $container;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('Home', array('route' => 'frontoffice_home'))
        ->setAttributes(array(
            'class' => 'nav-link',
            'icon' => 'fa fa-list'
        ));
        // ... add more children
        $menu->addChild('Nos Circuits', array('route' => 'frontoffice_home'))
        ->setAttributes(array('class' => 'nav-link'));
        $menu->addChild('Vos likes', array('route' => 'likes'))
        ->setAttributes(array('class' => 'nav-link'));
        $menu->addChild('About Us', array('route' => 'about'))
        ->setAttributes(array('class' => 'nav-link'));




        return $menu;
    }

    public function createUserMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav  ml-auto');

        //if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) {} // Check if the visitor has any authenticated roles
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            // Get username of the current logged in user
            $username = $this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
            $label = 'ADMIN '. $username. '.';
            $menu->addChild('Espace de gestion', array('route' => 'admin_circuit_index'))
            ->setAttributes(array('class' => 'nav-link'));

            $menu->addChild('Se deconnecter', array('uri' => 'http://localhost:8000/logout'))
            ->setAttributes(array('class' => 'nav-link justify-content-end'));

            }
            else{
                $username = $this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
                $label = 'Bienvenue, '. $username. '.';
                $menu->addChild('Mon profil', array('route' => 'frontoffice_home'))
                ->setAttributes(array('class' => 'nav-link'));
                $menu->addChild('Se deconnecter', array('uri' => 'http://localhost:8000/logout', 'class'=>'custom_link'))
                ->setAttributes(array('class' => 'nav-link justify-content-end'));
            }

        }
        else
        {
            $menu->addChild('Se connecter', array('uri' => 'http://localhost:8000/login'))
                ->setAttributes(array('class' => 'nav-link'));
        }



        return $menu;
    }

    public function createAdminMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav  ml-auto');
        // ... add more children
        $menu->addChild('Circuits', array('route' => 'admin_circuit_index'))
        ->setAttributes(array('class' => 'nav-link'));
        $menu->addChild('Etapes', array('route' => 'admin_etape_index'))
        ->setAttributes(array('class' => 'nav-link'));
        $menu->addChild('Circuits Programmés', array('route' => 'admin_programmation_circuit_index'))
        ->setAttributes(array('class' => 'nav-link'));

        $menu->addChild('Liste des reservations', array('uri' => 'http://localhost:8000/reservation/'))
        ->setAttributes(array('class' => 'nav-link justify-content-end'));
        $menu->addChild('Front Office', array('route' => 'frontoffice_home'))
        ->setAttributes(array('class' => 'nav-link justify-content-end'));
        $menu->addChild('Se deconnecter', array('uri' => 'http://localhost:8000/logout'))
        ->setAttributes(array('class' => 'nav-link justify-content-end'));



        return $menu;
    }

}
