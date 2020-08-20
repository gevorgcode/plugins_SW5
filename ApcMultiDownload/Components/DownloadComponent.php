<?php

namespace ApcMultiDownload\Components;

use Shopware\Models\Shop\Shop;

class DownloadComponent
{

    public function getMultipleDownloads($articleId){

        $baseUrl = $this->baseUrl();
        if(empty($baseUrl)){
            $baseUrl = 'https://it-nerd24.de/';
        }
        //esdAttribute Data
        $sql = 'SELECT * FROM `s_articles_esd_attributes` LEFT JOIN `s_articles_esd` ON `s_articles_esd`.`id` = `s_articles_esd_attributes`.`esdID` WHERE `s_articles_esd`.`articleID` = ?';
        $esdData = Shopware()->Db()->fetchRow($sql,array($articleId));

        if($esdData['additional_download_active'] == 1){
            $k = 1;
            for($i=1; $i<=4; $i++){
                if(empty($esdData['file_'.$i])){
                    continue;
                }
                if(empty($esdData['text_'.$i])){
                    $esdData['text_'.$i] = 'Download Link '.$k;
                    $k++;
                }

                if($i>2){
                    $link = $baseUrl.'files/'.Shopware()->Config()->get('sESDKEY').'/'
                                .Shopware()->Db()->fetchOne('SELECT `name` FROM `apc_esd_files` WHERE `id` = ? ;', array($esdData['file_'.$i]));
                }else{
                    $link = $esdData['file_'.$i];
                }

                $downloadData[] = [
                    'text' => $esdData['text_'.$i],
                    'link' => $link
                ];
            }

        }else{
            $downloadData[] = [
                'text' => 'Download',
                'link' => $esdLink
            ];
        }

        return $downloadData;
    }

    public function baseUrl(){
        $shop = Shopware()->Container()->get('models')->getRepository(Shop::class)->getActiveDefault();
        if ($shop->getMain()) {
            $shop = $shop->getMain();
        }
        if ($shop->getSecure()) {
            $baseUrl = 'https://' . $shop->getHost() . $shop->getBasePath() . '/';
        } else {
            $baseUrl = 'http://' . $shop->getHost() . $shop->getBasePath() . '/';
        }
    }

}
