<?php

namespace NCBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class Builder
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
                'routeAbsolute'   => true,
            ]
        );
        $menu['menu.curriculum']->addChild('menu.combinaisons',
            [
                'route'           => 'exercise_collection_view',
                'routeParameters' => ['slug' => 'combinaisons'],
                'routeAbsolute'   => true,
            ]);
        $menu['menu.curriculum']->addChild('menu.maniements',
            [
                'route'           => 'technique_collection_view',
                'routeParameters' => ['slug' => 'maniements'],
                'routeAbsolute'   => true,
            ]);
        $menu['menu.curriculum']->addChild('menu.attaques',
            [
                'route'           => 'technique_collection_view',
                'routeParameters' => ['slug' => 'attaques'],
                'routeAbsolute'   => true,
            ]);
        $menu['menu.curriculum']->addChild('menu.balayages',
            [
                'route'           => 'technique_collection_view',
                'routeParameters' => ['slug' => 'balayages'],
                'routeAbsolute'   => true,
            ]);
        $menu['menu.curriculum']->addChild('menu.gardes',
            [
                'route'           => 'technique_collection_view',
                'routeParameters' => ['slug' => 'gardes'],
                'routeAbsolute'   => true,
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
        $menu['menu.training']->addChild('menu.supplies', ['route' => 'supply_home', 'routeAbsolute' => true,]);
        $menu['menu.training']->addChild('menu.exercises', ['route' => 'exercise_home', 'routeAbsolute' => true,]);
        $menu['menu.training']->addChild('menu.clubs', ['route' => 'club_home', 'routeAbsolute' => true,]);

        // Grading
        $menu->addChild(
            'menu.grading',
            [
                'route'           => 'rank_view_style',
                'routeParameters' => ['slug' => 'nunchaku-de-combat'],
                'routeAbsolute'   => true,
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
        $menu['menu.events']->addChild('menu.competitions', ['route' => 'competition_home', 'routeAbsolute' => true,]);
        $menu['menu.events']->addChild('menu.shows', ['route' => 'show_home', 'routeAbsolute' => true,]);
        $menu['menu.events']->addChild('menu.training_courses', ['route' => 'training_course_home', 'routeAbsolute' => true,]);

        // Blog
        $menu->addChild('menu.blog', ['route' => 'application_sonata_news', 'routeAbsolute' => true,]);

        return $menu;
    }
}
