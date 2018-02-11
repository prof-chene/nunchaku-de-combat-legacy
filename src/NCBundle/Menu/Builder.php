<?php

namespace NCBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class Builder
 *
 * @package NCBundle\Menu
 */
class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param FactoryInterface $factory
     * @param array $options
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem(
            'root',
            ['childrenAttributes' => ['class' => 'nav navbar-nav']]
        );

        $menu->addChild('menu.official_curriculum', ['route' => 'homepage'])
             ->setExtra('translation_domain', 'navigation');
        $menu->addChild('menu.training', ['route' => 'homepage'])
             ->setExtra('translation_domain', 'navigation');
        $menu->addChild('menu.events', ['route' => 'homepage'])
             ->setExtra('translation_domain', 'navigation');
        $menu->addChild('menu.blog', ['route' => 'application_sonata_news'])
             ->setExtra('translation_domain', 'navigation');
        $menu->addChild('menu.faq', ['route' => 'homepage'])
             ->setExtra('translation_domain', 'navigation');
        $menu->addChild('menu.media_library', ['route' => 'application_sonata_gallery'])
             ->setExtra('translation_domain', 'navigation');

        return $menu;
    }
}
