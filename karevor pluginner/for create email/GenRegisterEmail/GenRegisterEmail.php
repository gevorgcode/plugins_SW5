<?php

namespace GenRegisterEmail;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Models\Mail\Mail;
use GenRegisterEmail\Components\Constants;

class GenRegisterEmail extends Plugin
{
    public function install(InstallContext $context)
    {
        $this->createEmailTemplate();
        $this->createAttribute();
        
        return parent::install($context);
    }

    public function uninstall(UninstallContext $context)
    {
        $this->deleteAttribute();
        $this->deleteEmailTemplate();
        
        return parent::uninstall($context);
    }
    
    private function deleteEmailTemplate(){
        $mailRepo = Shopware()->Models()->getRepository(Mail::class);
        
        $mail = $mailRepo->findOneByName(Constants::EMAIL_TEMPLATE);
        
        if(empty($mail)) {
            return;
        }
        
        Shopware()->Models()->remove($mail);
        
        /*Shopware()->Models()->persist($mail);*/
        Shopware()->Models()->flush();
    }
    
    private function deleteAttribute() {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->delete('s_user_attributes', 'tur');
    }
    
    private function createAttribute() {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->update('s_user_attributes', 'tur', 'string');    
    }
    
    private function createEmailTemplate() {
        $mail = new Mail();
       
        $fromMail = '{config name=mail}';
        $fromName = '{config name=shopName}';
        
        $subject ='Registration Confirm for order {$orderNumber}';
        $content ='{include file="string:{config name=emailheaderplain}"}

						Dear {$salutation|salutation} {$userlastname},

						thank you for your registration with our Shop.
						You will gain access via the email address {$userlastname} and the password you have chosen.
						You can change your password at any time.

						{include file="string:{config name=emailfooterplain}"}';
        $contentHtml = '<div style="font-family:arial; font-size:12px;">
					    {include file="string:{config name=emailheaderhtml}"}
					    <br/><br/>
					    <p>
					        Dear {$salutation|salutation} {$username} {$userlastname},<br/>
					        <br/>
					        thank you for your registration with our Shop.<br/>
					        You will gain access via the email address <strong>{$usermail}</strong> and the password you have chosen.<br/>
					        You can change your password anytime.
					    </p>
					    <a href="{$link}">Activate Your Account</a>
					    {include file="string:{config name=emailfooterhtml}"}
					</div>';


        $mail->setFromName($fromName);
        $mail->setName(Constants::EMAIL_TEMPLATE);
        $mail->setSubject($subject);
        $mail->setContent($content);
        $mail->setContentHtml($contentHtml);
        $mail->setIsHtml(true);
        $mail->setFromMail($fromMail);

//        $mail->fromArray([]);
        
        Shopware()->Models()->persist($mail);
        Shopware()->Models()->flush();
    }
}


?>
