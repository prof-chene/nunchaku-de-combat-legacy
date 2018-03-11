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

        // Curriculum
        $menu->addChild('menu.curriculum',
            [
                'linkAttributes' => [
                    'class'       => 'dropdown-toggle',
                    'data-toggle' => 'dropdown',
                ],
                'childrenAttributes' => [
                    'class'       => 'dropdown-menu',
                ],
            ]);
        $menu['menu.curriculum']->addChild(
            'menu.katas',
            [
                'route'           => 'exercise_collection_view',
                'routeParameters' => ['slug' => 'katas'],
            ]
        );
        $menu['menu.curriculum']->addChild('menu.combinaisons',
            [
                'route'           => 'exercise_collection_view',
                'routeParameters' => ['slug' => 'combinaisons'],
            ]);
        $menu['menu.curriculum']->addChild('menu.maniements',
            [
                'route'           => 'technique_collection_view',
                'routeParameters' => ['slug' => 'maniements'],
            ]);
        $menu['menu.curriculum']->addChild('menu.attaques',
            [
                'route'           => 'technique_collection_view',
                'routeParameters' => ['slug' => 'attaques'],
            ]);
        $menu['menu.curriculum']->addChild('menu.balayages',
            [
                'route'           => 'technique_collection_view',
                'routeParameters' => ['slug' => 'balayages'],
            ]);
        $menu['menu.curriculum']->addChild('menu.gardes',
            [
                'route'           => 'technique_collection_view',
                'routeParameters' => ['slug' => 'gardes'],
            ]);

        // Training
        $menu->addChild('menu.training',
            [
                'linkAttributes' => [
                    'class'       => 'dropdown-toggle',
                    'data-toggle' => 'dropdown',
                ],
                'childrenAttributes' => [
                    'class'       => 'dropdown-menu',
                ],
            ]);
        $menu['menu.training']->addChild('menu.supplies', ['route' => 'supply_home']);
        $menu['menu.training']->addChild('menu.exercises', ['route' => 'exercise_home']);
        $menu['menu.training']->addChild('menu.clubs');

        // Grading
        $menu->addChild(
            'menu.grading',
            [
                'route'           => 'rank_view_style',
                'routeParameters' => ['slug' => 'nunchaku-de-combat'],
            ]
        );

        // Events
        $menu->addChild('menu.events',
            [
                'linkAttributes' => [
                    'class'       => 'dropdown-toggle',
                    'data-toggle' => 'dropdown',
                ],
                'childrenAttributes' => [
                    'class'       => 'dropdown-menu',
                ],
            ]);
        $menu['menu.events']->addChild('menu.competitions');
        $menu['menu.events']->addChild('menu.shows');
        $menu['menu.events']->addChild('menu.training_courses');

        // Blog
        $menu->addChild('menu.blog', ['route' => 'application_sonata_news']);

        // FAQ
        $menu->addChild('menu.faq');

        // MediaLibrary
        $menu->addChild('menu.media_library', ['route' => 'application_sonata_gallery']);

        return $menu;
    }
}
