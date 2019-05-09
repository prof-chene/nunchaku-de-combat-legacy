<?php

namespace NCBundle\Menu;

use Application\Sonata\ClassificationBundle\Entity\Collection;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use NCBundle\Entity\Technique\Exercise;
use NCBundle\Entity\Technique\Rank;
use NCBundle\Entity\Technique\Style;
use NCBundle\Entity\Technique\Supply;
use NCBundle\Entity\Technique\Technique;
use NCBundle\Repository\Technique\ExerciseRepository;
use NCBundle\Repository\Technique\StyleRepository;
use NCBundle\Repository\Technique\SupplyRepository;
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
     * @var SupplyRepository
     */
    private $supplyRepository;
    /**
     * @var StyleRepository
     */
    private $styleRepository;

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
     * @param SupplyRepository      $suplyRepository
     * @param StyleRepository       $styleRepository
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
        TechniqueRepository $techniqueRepository,
        SupplyRepository $suplyRepository,
        StyleRepository $styleRepository
    ) {
        parent::__construct($context, $name, $templating, $menuProvider, $factory);

        $this->requestStack = $requestStack;
        $this->collectionManager = $collectionManager;
        $this->exerciseRepository = $exerciseRepository;
        $this->techniqueRepository = $techniqueRepository;
        $this->supplyRepository = $suplyRepository;
        $this->styleRepository = $styleRepository;
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
                'route'           => 'homepage',
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
                        strtolower($collection->getSlug()) === strtolower($currentRouteAttributes->get('slug'))
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
                        strtolower($exercise->getSlug()) === strtolower($currentRouteAttributes->get('slug'))
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
                        strtolower($collection->getSlug()) === strtolower($currentRouteAttributes->get('slug'))
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
                        strtolower($technique->getSlug()) === strtolower($currentRouteAttributes->get('slug'))
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

            case 'breadcrumb.supplies':

                $menu->addChild(
                    'breadcrumb.supplies',
                    [
                        'route'           => 'supply_home',
                        'routeAbsolute'   => true,
                        'extras'          => ['translation_domain' => 'navigation'],
                    ]
                );

                if ($this->isCurrentItem($menu['breadcrumb.supplies'], $currentRoute)) {
                    return $menu;
                }

                /**
                 * @var Collection[] $collections
                 */
                $collections = $this->collectionManager->findAll();

                /**
                 * @var Supply[] $supplies
                 */
                $supplies = $this->supplyRepository->findAll();

                foreach ($collections as $collection) {
                    // If this collection is the current route
                    if (strtolower($currentRoute) === 'supply_collection_view' &&
                        null !== $currentRouteAttributes->get('slug') &&
                        strtolower($collection->getSlug()) === strtolower($currentRouteAttributes->get('slug'))
                    ) {
                        $menu->addChild(
                            $collection->getName(),
                            ['current' => true]
                        );

                        return $menu;
                    }
                }

                foreach ($supplies as $supply) {
                    // Else if this supply is the current route
                    if (strtolower($currentRoute) === 'supply_view' &&
                        null !== $currentRouteAttributes->get('slug') &&
                        strtolower($supply->getSlug()) === strtolower($currentRouteAttributes->get('slug'))
                    ) {
                        $menu->addChild($supply->getCollection()->getName(),
                            [
                                'route'           => 'supply_collection_view',
                                'routeParameters' => ['slug' => $supply->getCollection()->getSlug()],
                                'routeAbsolute'   => true,
                            ]
                        );
                        $menu->addChild(
                            $supply->getTitle(),
                            ['current' => true]
                        );

                        return $menu;
                    }
                }

                break;

            case 'breadcrumb.clubs':

                $menu->addChild(
                    'breadcrumb.clubs',
                    [
                        'current' => true,
                        'extras'  => ['translation_domain' => 'navigation'],
                    ]
                );

                return $menu;

                break;

            case 'breadcrumb.ranks':

                $menu->addChild(
                    'breadcrumb.ranks',
                    [
                        'route'           => 'rank_home',
                        'routeAbsolute'   => true,
                        'extras'          => ['translation_domain' => 'navigation'],
                    ]
                );

                if ($this->isCurrentItem($menu['breadcrumb.ranks'], $currentRoute)) {
                    return $menu;
                }

                /**
                 * @var Style[] $styles
                 */
                $styles = $this->styleRepository->findAll();

                foreach ($styles as $style) {
                    // If this style is the current route
                    if (strtolower($currentRoute) === 'rank_view_style' &&
                        null !== $currentRouteAttributes->get('slug') &&
                        strtolower($style->getSlug()) === strtolower($currentRouteAttributes->get('slug'))
                    ) {
                        $menu->addChild(
                            $style->getTitle(),
                            ['current' => true]
                        );

                        return $menu;
                    }

                    // If one of this style's ranks is the current route
                    if (strtolower($currentRoute) === 'rank_view' &&
                        null !== $currentRouteAttributes->get('styleSlug') &&
                        strtolower($style->getSlug()) === strtolower($currentRouteAttributes->get('styleSlug'))
                    ) {
                        $menu->addChild($style->getTitle(),
                            [
                                'route'           => 'rank_view_style',
                                'routeParameters' => ['slug' => $style->getSlug()],
                                'routeAbsolute'   => true,
                            ]
                        );

                        /**
                         * @var Rank $rank
                         */
                        foreach ($style->getRanks() as $rank) {
                            if (null !== $currentRouteAttributes->get('rankSlug') &&
                                $rank->getSlug() === $currentRouteAttributes->get('rankSlug')
                            ) {
                                $menu->addChild(
                                    $rank->getTitle(),
                                    ['current' => true]
                                );

                                return $menu;
                            }
                        }
                    }
                }
        }

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
