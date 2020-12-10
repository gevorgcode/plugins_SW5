<?php

use Shopware\Models\Media\Media;
use Shopware\Models\Media\Album;
use Symfony\Component\HttpFoundation\FileBag;

class Shopware_Controllers_Widgets_Image extends \Enlight_Controller_Action{
    
    private $filebag = null;
    
    public function fileAction(){        
        $Ref = $_SERVER['HTTP_REFERER'];
        header("Location: $Ref");         
        $name = 'media';
        //try to get the transferred file
        $file = $_FILES[$name];        
        if(!empty($file['error'])) {
            return;
        }        
        if ($file['size'] < 1 && $file['error'] === 1 || empty($_FILES)) {
            return;
        }
        $fileInfo = pathinfo($file['name']);        
        $fileExtension = strtolower($fileInfo['extension']);        
        $file['name'] = $fileInfo['filename'] . "." . $fileExtension;        
        $_FILES[$name]['name'] = $file['name'];
        $fileBag = $this->getFileBag();
        /** @var $file UploadedFile */
        $file = $fileBag->get($name);
        if ($file === null) {
            throw new \Exception('unknown issue');
        }
        $fileInfo = pathinfo($file->getClientOriginalName());
        $extension = $fileInfo['extension'];
        if (in_array(strtolower($extension), self::$fileUploadBlacklist)) {
            unlink($file->getPathname());
            unlink($file);
			throw new \Exception('blacklist exception');
        }
        $manager = $this->container->get('models');        
        //create a new model and set the properties
        $media = new Media();
        $albumId = -87; 
        $album = $manager->find(Album::class, $albumId);        
        $media->setAlbum($album);
        $media->setDescription('');
        $media->setCreated(date('y-m-d'));
        $media->setUserId(15);        
        //set the upload file into the model. The model saves the file to the directory
        $media->setFile($file);
		$manager->persist($media);
		$manager->flush();
		$media->createAlbumThumbnails($media->getAlbum());
		$manager->persist($media);
		$manager->flush();        
        $path = $media->getPath();
        $userId = Shopware()->Session()->offsetGet('sUserId');        
        if ($path){
            $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
            $queryBuilder->update("s_user_attributes")            
                ->set('userimage', ':userimage')            
                ->where('userID = :userId')            
                ->setParameter('userimage', $path)
                ->setParameter('userId', $userId)
                ->execute();
        }
        return $media->getPath();        
    }    
    private function getFileBag() {
        if($this->filebag == null) {
            $this->filebag = new FileBag($_FILES);
        }
        return $this->filebag;
    }
	private static $fileUploadBlacklist = [
        'php','php3','php4','php5','phtml',
        'cgi','pl','sh','com','bat','','py',
        'rb','exe','txt','gif'
    ];
}
