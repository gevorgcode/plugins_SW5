<?php

namespace GenImages\Subscriber;

use Enlight\Event\SubscriberInterface;
use PDO;

class GenImagesSubscriber implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDirectory;
    
    /**
     * @var \Enlight_Template_Manager
     */
    private $templateManager;

   /**
     * @param $pluginDirectory
     * @param \Enlight_Template_Manager $templateManager
     */
    public function __construct(string $pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;        
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onCollectedTemplates',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onPostFront',            
        ];
    }
     /**
     * @param \Enlight_Event_EventArgs $args
     */
    public function onCollectedTemplates(\Enlight_Event_EventArgs $args)
    {
        $controller = $args->get('subject');
        $view = $controller->View();
        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');
    }
    
     
    public function onPostFront(\Enlight_Event_EventArgs $args)
    {
        $controller = $args->get('subject');
        $view = $controller->View();
        $userId = Shopware()->Session()->offsetGet('sUserId');
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $queryBuilder->select(['u.userimage'])
            ->from('s_user_attributes', 'u')
            ->where('userID = :userId')
            ->setParameter('userId', $userId);
        $builderExecute = $queryBuilder->execute();
        $imagepath = $builderExecute->fetchColumn();
        $view->assign([
            'userImageSrc' => $imagepath,           
        ]);    
    } 
}














