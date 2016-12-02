<?php

namespace NCBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class Builder
 * @package NCBundle\Menu
 */
class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'nav navbar-nav',
            ),
        ));

        $menu->addChild('menu.official_curriculum', array('route' => 'homepage'))
             ->setExtra('translation_domain', 'navigation');
        $menu->addChild('menu.training', array('route' => 'homepage'))
             ->setExtra('translation_domain', 'navigation');
        $menu->addChild('menu.events', array('route' => 'homepage'))
             ->setExtra('translation_domain', 'navigation');
        $menu->addChild('menu.blog', array('route' => 'homepage'))
             ->setExtra('translation_domain', 'navigation');
        $menu->addChild('menu.faq', array('route' => 'homepage'))
             ->setExtra('translation_domain', 'navigation');
        $menu->addChild('menu.media_library', array('route' => 'homepage'))
             ->setExtra('translation_domain', 'navigation');

        return $menu;
    }
}
