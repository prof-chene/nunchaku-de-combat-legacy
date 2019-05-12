<?php

namespace NCBundle\Menu;

use Application\Sonata\ClassificationBundle\Entity\Collection;
use Application\Sonata\ClassificationBundle\Entity\Context;
use Knp\Menu\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use NCBundle\Entity\Technique\Rank;
use NCBundle\Entity\Technique\Style;
use NCBundle\Repository\Event\CompetitionRepository;
use NCBundle\Repository\Event\ShowRepository;
use NCBundle\Repository\Event\TrainingCourseRepository;
use NCBundle\Repository\Technique\ExerciseRepository;
use NCBundle\Repository\Technique\RankRepository;
use NCBundle\Repository\Technique\StyleRepository;
use NCBundle\Repository\Technique\SupplyRepository;
use NCBundle\Repository\Technique\TechniqueRepository;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\ClassificationBundle\Entity\CollectionManager;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Builder
 */
class Breadcrumb extends BaseBreadcrumbMenuBlockService
{
    const BUNDLE_CONFIG_DIR = __DIR__.'/../Resources/config/';
    /**
     * @var string
     */
    private $currentRoute;
    /**
     * @var array
     */
    private $currentRouteAttributes;
    /**
     * @var array
     */
    private $routingTree;
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
     * @var RankRepository
     */
    private $rankRepository;
    /**
     * @var CompetitionRepository
     */
    private $competitionRepository;
    /**
     * @var ShowRepository
     */
    private $showRepository;
    /**
     * @var TrainingCourseRepository
     */
    private $trainingCourseRepository;
    /**
     * @var object|null
     */
    private $currentEntity = null;

    /**
     * Breadcrumb constructor.
     *
     * @param string                   $context
     * @param string                   $name
     * @param EngineInterface          $templating
     * @param MenuProviderInterface    $menuProvider
     * @param FactoryInterface         $factory
     * @param RequestStack             $requestStack
     * @param string                   $routingTreeFile
     * @param CollectionManager        $collectionManager
     * @param ExerciseRepository       $exerciseRepository
     * @param TechniqueRepository      $techniqueRepository
     * @param SupplyRepository         $suplyRepository
     * @param StyleRepository          $styleRepository
     * @param RankRepository           $rankRepository
     * @param CompetitionRepository    $competitionRepository
     * @param ShowRepository           $showRepository
     * @param TrainingCourseRepository $trainingCourseRepository
     */
    public function __construct(
        string $context,
        string $name,
        EngineInterface $templating,
        MenuProviderInterface $menuProvider,
        FactoryInterface $factory,
        RequestStack $requestStack,
        string $routingTreeFile,
        CollectionManager $collectionManager,
        ExerciseRepository $exerciseRepository,
        TechniqueRepository $techniqueRepository,
        SupplyRepository $suplyRepository,
        StyleRepository $styleRepository,
        RankRepository $rankRepository,
        CompetitionRepository $competitionRepository,
        ShowRepository $showRepository,
        TrainingCourseRepository $trainingCourseRepository
    ) {
        parent::__construct($context, $name, $templating, $menuProvider, $factory);

        $this->currentRoute = $requestStack->getCurrentRequest()->get('_route');
        $this->currentRouteAttributes = $requestStack->getCurrentRequest()->attributes->all();

        $this->routingTree = Yaml::parseFile(self::BUNDLE_CONFIG_DIR.$routingTreeFile);

        $this->collectionManager = $collectionManager;
        $this->exerciseRepository = $exerciseRepository;
        $this->techniqueRepository = $techniqueRepository;
        $this->supplyRepository = $suplyRepository;
        $this->styleRepository = $styleRepository;
        $this->rankRepository = $rankRepository;
        $this->competitionRepository = $competitionRepository;
        $this->showRepository = $showRepository;
        $this->trainingCourseRepository = $trainingCourseRepository;
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

        // /!\ THIS IS AN UGLY HACK /!\
        // TODO REMOVE THIS WHEN BUMPING PHP TO >= 7.3
        if (! function_exists('array_key_last')) {
            function array_key_last($array) {
                if (!is_array($array) || empty($array)) {
                    return NULL;
                }

                return array_keys($array)[count($array)-1];
            }
        }

        $breadcrumbTree = $this->getBreadcrumbTree($this->currentRoute, $this->routingTree);

        foreach ($breadcrumbTree as $route => $breadcrumbName) {
            $translateBreadcrumbName = !empty($breadcrumbName);

            if (empty($breadcrumbName)) {
                $breadcrumbName = $this->getBreadcrumbName($route);
            }

            // Skip this breadcrumb if something mandatory is missing
            if ($this->mustSkipBreadcrumb($route, $breadcrumbName)) {
                continue;
            }

            $breadcrumbOptions = $this->getBreadcrumbOptions(
                $route,
                $route === array_key_last($breadcrumbTree),
                $translateBreadcrumbName
            );

            $menu->addChild($breadcrumbName, $breadcrumbOptions);
        }

        return $menu;
    }
    /**
     * @param string $route
     * @param array  $routingTree
     * @param array  $breadcrumbTree
     *
     * @return array
     */
    private function getBreadcrumbTree(string $route, array $routingTree, array $breadcrumbTree = [])
    {
        foreach ($routingTree as $branchName => $routeBranch) {
            $breadcrumbTree[$branchName] = isset($routeBranch['label']) ? 'breadcrumb.'.$routeBranch['label'] : null;

            if ($branchName === $route) {
                return $breadcrumbTree;
            }

            if (is_array($routeBranch) &&
                isset($routeBranch['children']) &&
                is_array($routeBranch['children']) &&
                !empty($routeBranch['children'])
            ) {
                $finalPrunedRoutingTree = $this->getBreadcrumbTree($route, $routeBranch['children'], $breadcrumbTree);
                if (!empty($finalPrunedRoutingTree)) {
                    return $finalPrunedRoutingTree;
                }
            }

            unset($breadcrumbTree[$branchName]);
        }

        return [];
    }

    /**
     * @param string $route
     * @param string $breadcrumbName
     *
     * @return bool
     */
    private function mustSkipBreadcrumb(string $route, string $breadcrumbName = '')
    {
        if (empty($breadcrumbName)) {
            $breadcrumbName = $this->getBreadcrumbName($route);
        }
        if (empty($breadcrumbName)) {
            return true;
        }

        switch (strtolower($route)) {
            case 'exercise_collection_view':
            case 'technique_collection_view':
            case 'supply_collection_view':
            case 'exercise_view':
            case 'technique_view':
            case 'supply_view':
            case 'rank_view':
            case 'competition_view':
            case 'show_view':
            case 'training_course_view':
                if (empty($this->guessRouteParameters($route))) {
                    return true;
                }
                break;
        }

        return false;
    }

    /**
     * @param string $route
     *
     * @return string
     */
    private function getBreadcrumbName(string $route)
    {
        switch (strtolower($route)) {
            case 'exercise_collection_view':
            case 'technique_collection_view':
            case 'supply_collection_view':
                if ($this->findCurrentEntity() instanceof Collection) {
                    return $this->findCurrentEntity()->getName();
                }
                if (method_exists($this->findCurrentEntity(), 'getCollection') &&
                    $this->findCurrentEntity()->getCollection() instanceof Collection
                ) {
                    return $this->findCurrentEntity()->getCollection()->getName();
                }
                break;

            case 'rank_view_style':
                if ($this->findCurrentEntity() instanceof Style) {
                    return $this->findCurrentEntity()->getTitle();
                }
                if ($this->findCurrentEntity() instanceof Rank) {
                    return $this->findCurrentEntity()->getStyle()->getTitle();
                }
                break;

            case 'exercise_view':
            case 'technique_view':
            case 'supply_view':
            case 'rank_view':
            case 'competition_view':
            case 'show_view':
            case 'training_course_view':
                if (method_exists($this->findCurrentEntity(), 'getTitle')) {
                    return $this->findCurrentEntity()->getTitle();
                }
                break;
        }

        return '';
    }

    /**
     * @param string $route
     * @param bool   $current
     * @param bool   $translate
     *
     * @return array
     */
    private function getBreadcrumbOptions(string $route, bool $current = false, bool $translate = false)
    {
        if ($current) {
            $options = [
                'current' => true,
            ];
        } else {
            $options = [
                'route'         => $route,
                'routeAbsolute' => true,
            ];

            $routeParameters = $this->guessRouteParameters($route);
            if (!empty($routeParameters)) {
                $options['routeParameters'] = $routeParameters;
            }
        }

        if ($translate) {
            $options['extras'] = ['translation_domain' => 'navigation'];
        }

        return $options;
    }

    /**
     * @param string $route
     *
     * @return array
     */
    private function guessRouteParameters(string $route)
    {
        switch (strtolower($route)) {
            case 'exercise_collection_view':
            case 'technique_collection_view':
            case 'supply_collection_view':
                if ($this->findCurrentEntity() instanceof Collection) {
                    return ['slug' => $this->findCurrentEntity()->getSlug()];
                }
                if (method_exists($this->findCurrentEntity(), 'getCollection') &&
                    $this->findCurrentEntity()->getCollection() instanceof Collection
                ) {
                    return ['slug' => $this->findCurrentEntity()->getCollection()->getSlug()];
                }
                break;

            case 'rank_view_style':
                if ($this->findCurrentEntity() instanceof Style) {
                    return ['slug' => $this->findCurrentEntity()->getSlug()];
                }
                if ($this->findCurrentEntity() instanceof Rank) {
                    return ['slug' => $this->findCurrentEntity()->getStyle()->getSlug()];
                }
                break;

            case 'exercise_view':
            case 'technique_view':
            case 'supply_view':
            case 'rank_view':
            case 'competition_view':
            case 'show_view':
            case 'training_course_view':
                return ['slug' => $this->findCurrentEntity()->getSlug()];
                break;
        }

        return [];
    }

    /**
     * Find entity for current route, if there is one
     *
     * @return object|null
     */
    private function findCurrentEntity()
    {
        if (null !== $this->currentEntity) {
            return $this->currentEntity;
        }

        switch (strtolower($this->currentRoute)) {
            case 'exercise_collection_view':
                $this->currentEntity = $this->collectionManager->findOneBy([
                    'slug'    => $this->currentRouteAttributes['slug'],
                    'context' => Context::EXERCISE_CONTEXT,
                ]);
                break;

            case 'technique_collection_view':
                $this->currentEntity = $this->collectionManager->findOneBy([
                    'slug'    => $this->currentRouteAttributes['slug'],
                    'context' => Context::TECHNIQUE_CONTEXT,
                ]);
                break;

            case 'supply_collection_view':
                $this->currentEntity = $this->collectionManager->findOneBy([
                    'slug'    => $this->currentRouteAttributes['slug'],
                    'context' => Context::SUPPLY_CONTEXT,
                ]);
                break;

            case 'exercise_view':
                $this->currentEntity = $this->exerciseRepository->findOneBy([
                    'slug' => $this->currentRouteAttributes['slug']
                ]);
                break;

            case 'technique_view':
                $this->currentEntity = $this->techniqueRepository->findOneBy([
                    'slug' => $this->currentRouteAttributes['slug']
                ]);
                break;

            case 'supply_view':
                $this->currentEntity = $this->supplyRepository->findOneBy([
                    'slug' => $this->currentRouteAttributes['slug']
                ]);
                break;

            case 'rank_view_style':
                $this->currentEntity = $this->styleRepository->findOneBy([
                    'slug' => $this->currentRouteAttributes['slug']
                ]);
                break;

            case 'rank_view':
                $this->currentEntity = $this->rankRepository->findOneBy([
                    'slug' => $slug = $this->currentRouteAttributes['rankSlug']
                ]);
                break;

            case 'competition_view':
                $this->currentEntity = $this->competitionRepository->findOneBy([
                    'slug' => $slug = $this->currentRouteAttributes['slug']
                ]);
                break;

            case 'competition_sign_up':
                $this->currentEntity = $this->competitionRepository->findOneBy([
                    'slug' => $slug = $this->currentRouteAttributes['slug']
                ]);
                break;

            case 'show_view':
                $this->currentEntity = $this->showRepository->findOneBy([
                    'slug' => $slug = $this->currentRouteAttributes['slug']
                ]);
                break;

            case 'show_sign_up':
                $this->currentEntity = $this->showRepository->findOneBy([
                    'slug' => $slug = $this->currentRouteAttributes['slug']
                ]);
                break;

            case 'training_course_view':
                $this->currentEntity = $this->trainingCourseRepository->findOneBy([
                    'slug' => $slug = $this->currentRouteAttributes['slug']
                ]);
                break;

            case 'training_course_sign_up':
                $this->currentEntity = $this->trainingCourseRepository->findOneBy([
                    'slug' => $slug = $this->currentRouteAttributes['slug']
                ]);
                break;
        }

        return $this->currentEntity;
    }
}
