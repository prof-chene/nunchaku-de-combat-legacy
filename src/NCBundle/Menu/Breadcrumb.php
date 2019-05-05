<?php

namespace NCBundle\Menu;

use Application\Sonata\ClassificationBundle\Entity\Collection;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use NCBundle\Entity\Technique\Exercise;
use NCBundle\Entity\Technique\Technique;
use NCBundle\Repository\Technique\ExerciseRepository;
use NCBundle\Repository\Technique\TechniqueRepository;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\ClassificationBundle\Entity\CollectionManager;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Builder
 */
class Breadcrumb extends BaseBreadcrumbMenuBlockService
{
    const ROUTING_MAPPING = [
        'breadcrumb.homepage' => [
            'homepage',
        ],
        'breadcrumb.exercises' => [
            'exercise'
        ],
        'breadcrumb.techniques' => [
            'technique'
        ],
        'breadcrumb.supplies' => [
            'supply'
        ],
        'breadcrumb.clubs' => [
            'club'
        ],
        'breadcrumb.ranks' => [
            'rank'
        ],
        'breadcrumb.competitions' => [
            'competition'
        ],
        'breadcrumb.shows' => [
            'show'
        ],
        'breadcrumb.training_courses' => [
            'training_course'
        ],
        'breadcrumb.news' => [
            'application_sonata_news',
            'sonata_news',
        ],
        'breadcrumb.medias' => [
            'application_sonata_gallery',
            'application_sonata_media',
            'sonata_media',
        ],
    ];
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var CollectionManager
     */
    private $collectionManager;
    /**
     * @var ExerciseRepository
     */
    private $exerciseRepository;
    /**
     * @var TechniqueRepository
     */
    private $techniqueRepository;

    /**
     * Breadcrumb constructor.
     *
     * @param string                $context
     * @param string                $name
     * @param EngineInterface       $templating
     * @param MenuProviderInterface $menuProvider
     * @param FactoryInterface      $factory
     * @param RequestStack          $requestStack
     * @param CollectionManager     $collectionManager
     * @param ExerciseRepository    $exerciseRepository
     * @param TechniqueRepository   $techniqueRepository
     */
    public function __construct(
        string $context,
        string $name,
        EngineInterface $templating,
        MenuProviderInterface $menuProvider,
        FactoryInterface $factory,
        RequestStack $requestStack,
        CollectionManager $collectionManager,
        ExerciseRepository $exerciseRepository,
        TechniqueRepository   $techniqueRepository
    ) {
        parent::__construct($context, $name, $templating, $menuProvider, $factory);

        $this->requestStack = $requestStack;
        $this->collectionManager = $collectionManager;
        $this->exerciseRepository = $exerciseRepository;
        $this->techniqueRepository = $techniqueRepository;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Breadcrumb for content pages';
    }

    /**
     * @inheritdoc
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        parent::configureSettings($resolver);

        $resolver->setDefaults([
            'menu_template' => '@SonataSeo/Block/breadcrumb.html.twig',
            'include_homepage_link' => false,
            'context' => false,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = $this->getRootMenu($blockContext);

        // currentUri is not supported in Knp\Menu\MenuItem, so we have to inject it
        $currentRoute = $this->requestStack->getCurrentRequest()->get('_route');
        $currentRouteAttributes = $this->requestStack->getCurrentRequest()->attributes;
        $menu->addChild(
            'breadcrumb.homepage',
            [
                'route'           => 'homepage_localized',
                'routeAbsolute'   => true,
                'extras'          => ['translation_domain' => 'navigation'],
            ]
        );

        if ($this->isCurrentItem($menu['breadcrumb.homepage'], $currentRoute)) {
            return $menu;
        }

        $childName = $this->getChildNameFromRoute($currentRoute);

        if (empty($childName)) {
            return $menu;
        }

        switch (strtolower($childName)) {
            case 'breadcrumb.exercises':

                $menu->addChild(
                    'breadcrumb.exercises',
                    [
                        'route'           => 'exercise_home',
                        'routeAbsolute'   => true,
                        'extras'          => ['translation_domain' => 'navigation'],
                    ]
                );

                if ($this->isCurrentItem($menu['breadcrumb.exercises'], $currentRoute)) {
                    return $menu;
                }

                /**
                 * @var Collection[] $collections
                 */
                $collections = $this->collectionManager->findAll();

                /**
                 * @var Exercise[] $exercises
                 */
                $exercises = $this->exerciseRepository->findAll();

                foreach ($collections as $collection) {
                    // If this collection is the current route
                    if (strtolower($currentRoute) === 'exercise_collection_view' &&
                        null !== $currentRouteAttributes->get('slug') &&
                        $slug = strtolower($collection->getSlug()) === strtolower($currentRouteAttributes->get('slug'))
                    ) {
                        $menu->addChild(
                            $collection->getName(),
                            ['current' => true]
                        );

                        return $menu;
                    }
                }

                foreach ($exercises as $exercise) {
                    // Else if this exercise is the current route
                    if (strtolower($currentRoute) === 'exercise_view' &&
                        null !== $currentRouteAttributes->get('slug') &&
                        $slug = strtolower($exercise->getSlug()) === strtolower($currentRouteAttributes->get('slug'))
                    ) {
                        $menu->addChild($exercise->getCollection()->getName(),
                            [
                                'route'           => 'exercise_collection_view',
                                'routeParameters' => ['slug' => $exercise->getCollection()->getSlug()],
                                'routeAbsolute'   => true,
                            ]
                        );
                        $menu->addChild(
                            $exercise->getTitle(),
                            ['current' => true]
                        );

                        return $menu;
                    }
                }

                break;

            case 'breadcrumb.techniques':

                $menu->addChild(
                    'breadcrumb.techniques',
                    [
                        'route'           => 'technique_home',
                        'routeAbsolute'   => true,
                        'extras'          => ['translation_domain' => 'navigation'],
                    ]
                );

                if ($this->isCurrentItem($menu['breadcrumb.techniques'], $currentRoute)) {
                    return $menu;
                }

                /**
                 * @var Collection[] $collections
                 */
                $collections = $this->collectionManager->findAll();

                /**
                 * @var Technique[] $techniques
                 */
                $techniques = $this->techniqueRepository->findAll();

                foreach ($collections as $collection) {
                    // If this collection is the current route
                    if (strtolower($currentRoute) === 'technique_collection_view' &&
                        null !== $currentRouteAttributes->get('slug') &&
                        $slug = strtolower($collection->getSlug()) === strtolower($currentRouteAttributes->get('slug'))
                    ) {
                        $menu->addChild(
                            $collection->getName(),
                            ['current' => true]
                        );

                        return $menu;
                    }
                }

                foreach ($techniques as $technique) {
                    // Else if this technique is the current route
                    if (strtolower($currentRoute) === 'technique_view' &&
                        null !== $currentRouteAttributes->get('slug') &&
                        $slug = strtolower($technique->getSlug()) === strtolower($currentRouteAttributes->get('slug'))
                    ) {
                        $menu->addChild($technique->getCollection()->getName(),
                            [
                                'route'           => 'technique_collection_view',
                                'routeParameters' => ['slug' => $technique->getCollection()->getSlug()],
                                'routeAbsolute'   => true,
                            ]
                        );
                        $menu->addChild(
                            $technique->getTitle(),
                            ['current' => true]
                        );

                        return $menu;
                    }
                }

                break;
        }
//        $menu->addChild('menu.combinaisons',
//            [
//                'route'           => 'exercise_collection_view',
//                'routeParameters' => ['slug' => 'combinaisons'],
//                'routeAbsolute'   => true,
//            ]);
//        $menu['menu.curriculum']->addChild('menu.maniements',
//            [
//                'route'           => 'technique_collection_view',
//                'routeParameters' => ['slug' => 'maniements'],
//                'routeAbsolute'   => true,
//            ]);
//        $menu['menu.curriculum']->addChild('menu.attaques',
//            [
//                'route'           => 'technique_collection_view',
//                'routeParameters' => ['slug' => 'attaques'],
//                'routeAbsolute'   => true,
//            ]);
//        $menu['menu.curriculum']->addChild('menu.balayages',
//            [
//                'route'           => 'technique_collection_view',
//                'routeParameters' => ['slug' => 'balayages'],
//                'routeAbsolute'   => true,
//            ]);
//        $menu['menu.curriculum']->addChild('menu.gardes',
//            [
//                'route'           => 'technique_collection_view',
//                'routeParameters' => ['slug' => 'gardes'],
//                'routeAbsolute'   => true,
//            ]);
//
//        // Training
//        $menu->addChild('menu.training',
//            [
//                'linkAttributes' => [
//                    'class'       => 'dropdown-toggle',
//                    'data-toggle' => 'dropdown',
//                ],
//                'childrenAttributes' => [
//                    'class'       => 'dropdown-menu',
//                ],
//            ]);
//        $menu['menu.training']->addChild('menu.supplies', ['route' => 'supply_home', 'routeAbsolute' => true,]);
//        $menu['menu.training']->addChild('menu.exercises', ['route' => 'exercise_home', 'routeAbsolute' => true,]);
//        $menu['menu.training']->addChild('menu.clubs', ['route' => 'club_home', 'routeAbsolute' => true,]);
//
//        // Grading
//        $menu->addChild(
//            'menu.grading',
//            [
//                'route'           => 'rank_view_style',
//                'routeParameters' => ['slug' => 'nunchaku-de-combat'],
//                'routeAbsolute'   => true,
//            ]
//        );
//
//        // Events
//        $menu->addChild('menu.events',
//            [
//                'linkAttributes' => [
//                    'class'       => 'dropdown-toggle',
//                    'data-toggle' => 'dropdown',
//                ],
//                'childrenAttributes' => [
//                    'class'       => 'dropdown-menu',
//                ],
//            ]);
//        $menu['menu.events']->addChild('menu.competitions', ['route' => 'competition_home', 'routeAbsolute' => true,]);
//        $menu['menu.events']->addChild('menu.shows', ['route' => 'show_home', 'routeAbsolute' => true,]);
//        $menu['menu.events']->addChild('menu.training_courses', ['route' => 'training_course_home', 'routeAbsolute' => true,]);
//
//        // Blog
//        $menu->addChild('menu.blog', ['route' => 'application_sonata_news', 'routeAbsolute' => true,]);

        return $menu;
    }

    /**
     * @param ItemInterface $item
     * @param string        $currentRoute
     *
     * @return bool
     */
    private function isCurrentItem(ItemInterface $item, string $currentRoute)
    {
        if (isset($item->getExtras()['routes'][0]['route']) &&
            strtolower($currentRoute) === strtolower($item->getExtras()['routes'][0]['route'])
        ) {
            $item->setUri(null);
            $item->setCurrent(true);

            return true;
        }

        return false;
    }

    /**
     * @param string $route
     *
     * @return string|null
     */
    private function getChildNameFromRoute($route)
    {
        foreach (self::ROUTING_MAPPING as $childName => $routeStarts) {
            foreach ($routeStarts as $routeStart) {
                if (strpos(strtolower($route), $routeStart) === 0) {
                    return $childName;
                }
            }
        }

        return null;
    }
}