<?php

use Shopware\Models\Article\Vote;

class Shopware_Controllers_Widgets_ProductReviewPagination extends \Enlight_Controller_Action {
    
    private $voteRepository = null;
    
    public function getRepository() {
        if($this->voteRepository == null) {
            $this->voteRepository = $this->container->get('models')->getRepository(Vote::class);
        }
        
        return $this->voteRepository;
    }
    
    public function indexAction() {
        $articleId = $this->Request()->getParam('sArticle');
        
        list($limitStart, $limitEnd, $page) = $this->handlePaginationRequest();
        
        $manager = $this->container->get('models');
        
        $builder = $manager->createQueryBuilder();
        $builder->select([
            'vote'
        ])
        ->from(Vote::class, 'vote')
        ->where('vote.active = 1')
        ->andWhere('vote.articleId = :articleId')
        ->setParameter('articleId', $articleId)
        ->orderBy('vote.datum', 'DESC');
        
        if (!empty($limitStart)) {
            $builder->setFirstResult($limitStart);
        }
        
        if (!empty($limitEnd)) {
            $builder->setMaxResults($limitEnd);
        }
        
        $votesQuery = $builder->getQuery();
        $votesQuery->setHydrationMode(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

        $paginator = $manager->createPaginator($votesQuery);

        // Returns the total count of the query
        $totalResult = $paginator->count();
       
        // Returns the votes data
        $votes = $paginator->getIterator()->getArrayCopy();

        $assigningData = [
            'sPage' => $page,
            'sPerPage' => $limitEnd,
            'sTotalNumber' => $totalResult,
            'sVotes' => $votes,
        ];
        
        $pagerData = $this->getPagerData($totalResult, $limitEnd, $page, []);

        $assigningData += $pagerData;

        $this->View()->assign($assigningData);
                
        if($this->Request()->getParam('isXHR')) {
            Shopware()->Plugins()->Controller()->ViewRenderer()->setNoRender();
            $response = $this->Response();
            $response->setHeader('Content-Type', 'application/json', true);
            $html = $this->View()->fetch('widgets/product_review_pagination/index.tpl');
            $response->setBody(json_encode([
                'html' => $html,
            ]));
        }
    }
    
    /**
     * Returns all data needed to handle the request
     *
     * @return array
     */
    public function handlePaginationRequest() {
        $page = (int) $this->Request()->getParam('sPage', 1);
        $page = $page >= 1 ? $page : 1;
        
        $config = $this->container->get('shopware.plugin.cached_config_reader')->getByPluginName('GenReviewPagination');
        $perPage = (int) $config['votes_per_setp'];
        
        // Start for Limit
        $limitStart = ($page - 1) * $perPage;
        $limitEnd = $perPage;
        
        return [$limitStart,$limitEnd,$page];
    }
    
    /**
     * Returns all data needed to display the pager
     *
     * @param int   $totalResult
     * @param int   $limitEnd
     * @param int   $page
     *
     * @return array
     */
    public function getPagerData($totalResult, $limitEnd, $page, $filter = [])
    {           
        $sViewport = $this->Request()->getControllerName();
        $sAction = $this->Request()->getActionName();
        $router = $this->Front()->Router();
        
        $numberPages = 0;
        // How many pages in this table
        if ($limitEnd !== 0) {
            $numberPages = ceil($totalResult / $limitEnd);
        }
        
        // Make Array with page-structure to render in template
        $pages = [];
        // Delete empty filters and add needed parameters to array
        $userParams = array_filter($filters);
        
        $userParams['module'] = 'widgets';
        $userParams['controller'] = 'ProductReviewPagination';
        $userParams['action'] = 'index';
        $userParams['sArticle'] = $this->Request()->getParam('sArticle');
        if ($numberPages > 1) {
            for ($i = 1; $i <= $numberPages; ++$i) {
                if ($i === $page) {
                    $pages['numbers'][$i]['markup'] = true;
                } else {
                    $pages['numbers'][$i]['markup'] = false;
                }
                $userParams['sPage'] = $i;
                $pages['numbers'][$i]['value'] = $i;
                $pages['numbers'][$i]['link'] = $router->assemble($userParams);
            }
            // Previous page
            if ($page !== 1) {
                $userParams['sPage'] = $page - 1;
                $pages['previous'] = $router->assemble($userParams);
            } else {
                $pages['previous'] = null;
            }
            // Next page
            if ($page !== $numberPages) {
                $userParams['sPage'] = $page + 1;
                $pages['next'] = $router->assemble($userParams);
            } else {
                $pages['next'] = null;
            }
        }
        
        return ['sNumberPages' => $numberPages, 'sPages' => $pages];
    }
    
}