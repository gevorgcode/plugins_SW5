<?php

namespace ApcLicenseStatus;

use Shopware\Components\Plugin;
use Doctrine\ORM\Tools\SchemaTool;
use ApcLicenseStatus\Models\LicenseStatusModel;
use Shopware\Models\Mail\Mail;
use ApcLicenseStatus\Components\Constants;

/**
 * Class ApcLicenseStatus
 * @package ApcLicenseStatus
 */
class ApcLicenseStatus extends Plugin
{
    /**
     * @param Plugin\Context\InstallContext $context
     */
    public function install(Plugin\Context\InstallContext $context)
    {
        $em = $this->container->get('models');
        $tool = new SchemaTool($em);
        $classes = [$em->getClassMetadata(LicenseStatusModel::class)];
        $tool->createSchema($classes);
        $this->createEmailTemplate();
        $this->createEmailTemplateInvoice();
        $this->createEmailTemplateLicense();
    }

    /**
     * @param Plugin\Context\ActivateContext $context
     */
    public function activate(Plugin\Context\ActivateContext $context)
    {
        $context->scheduleClearCache($context::CACHE_LIST_ALL);
    }

    /**
     * @param Plugin\Context\UninstallContext $context
     */
    public function uninstall(Plugin\Context\UninstallContext $context)
    {

        $em = $this->container->get('models');
        $tool = new SchemaTool($em);
        $classes = [$em->getClassMetadata(LicenseStatusModel::class)];
        $tool->dropSchema($classes);   
        $this->deleteEmailTemplate();
        $this->deleteEmailTemplateInvoice();
        $this->deleteEmailTemplateLicense();
       
        $context->scheduleClearCache($context::CACHE_LIST_ALL);
    }   
    
    //for sending validation email
    private function createEmailTemplate() {
        $mail = new Mail();
       
        $fromMail = '{config name=mail}';
        $fromName = '{config name=shopName}';
        
        $subject ='Email validation from {config name=shopName}';
        $content ='{include file="string:{config name=emailheaderplain}"}
						Hello, 
                        Please confirm your email by clicking on the link below: 
                         <a href="{$returnUrl}">Verify email</a>
						{include file="string:{config name=emailfooterplain}"}';
        $contentHtml = '<div style="font-family:arial; font-size:12px; width: 680px; margin: 0 auto;">
 
            <!--       header-->
                <div class="img-logo">
                    <img src="https://it-nerd24.de/media/image/dd/cc/68/logo_breitxxhdpi_logo8QX72mzcUvxKc.png" alt="" style="display: block; padding: 20px; width: 170px; margin: 0 auto;">
                </div>
                <br/><br/>
                <div style="padding:10px; text-align:center; font-size:  17px;background:#203E45;">
                    <span style="color: white; width: 275px; text-align: left; font-size: 14px; font-weight: 500; line-height: 19px; padding-left: 25px; letter-spacing: 1px; float: left;">
                        Unser 24h Support
                    </span>
                    <span style="color: white; font-size: 14px; font-weight: 500; width: 195px; text-align: left; letter-spacing: 1px; line-height: 20px;">
                        <img src="https://it-nerd24.de/media/image/41/2c/f3/email-icon.png" alt=""  style="display: inline-block; width: 20px;vertical-align: middle; position: relative; bottom: 2px; padding-right: 5px;">
                        <a href="mailto:hallo@it-nerd24.de" rel="nofollow" style="color: #97C933; font-size: 14px; text-decoration: none;" >hallo@it-nerd24.de</a>
                    </span>
                    <span style="color: white; font-size: 14px; font-weight: 500; width: 195px; text-align: left; letter-spacing: 1px;">
                        <img src="https://it-nerd24.de/media/image/67/bf/ef/telephon-white.png" alt=""  style="display: inline-block; width: 20px;vertical-align: middle;">
                        <a href="tel:0800 000 81 24" rel="nofollow" style="color: #97C933; font-size: 14px; text-decoration: none;">0800 / 000 812 4</a>
                    </span>
                </div>

                <!--    content-->

                <div style="display: flex;">                   
                    <div style="width: 385px;display: inline-block;margin: 0 auto;margin-top: 50px;margin-bottom: 25px;">
                        <p>
                            Hello, <br>
                            Please confirm your email by clicking on the link below: 
                       </p>
                       <br><br>
                       <a style="color: #203e45; text-decoration: none; font-size: 14px; font-weight: 600; background: #97C933; padding: 9px 65px; border-radius: 20px;" href="{$returnUrl}">Verify email</a>
                       <br><br><br>
                    </div>
                </div>
                <!--    footer-->
                <div style="display: block;">
                    <div style="display: inline-block;  border-top: 1px solid #203E45; padding: 25px 40px; width: 600px;">
                        <div style="width: 295px; color: #203E45; line-height: 17px; display: inline-block;">
                            <p style="letter-spacing: 0.3px; font-size: 13px; " >Für Rückfragen stehen wir Ihnen jederzeit gerne zur Verfügung - <a href="mailto:hallo@it-nerd24.de" rel="nofollow" style="color: #203E45; font-weight: 600;" >hallo@it-nerd24.de</a></p>
                            <p style="letter-spacing: 0.3px; font-size: 13px; margin-top: 13px;"> Mit freundlichen Grüßen</p>
                        </div>        
                        <div style="width: 220px; display: inline-block; text-align: right;">
                            <img src="https://it-nerd24.de/media/image/73/70/6f/247.png" alt=""  style=" height: 50px;">
                        </div>        
                    </div>
                    <div style="height: 42px; background: #203E45; color: white; font-size: 14px; letter-spacing: 0.5px; width: 680px; text-align: center;">
                        <span style="line-height: 40px; padding-left: 25px;">Telefonische Unterstützung und Beratung unter: <a href="tel:0800 000 81 24" rel="nofollow" style="color: #97C933; font-size: 14px; text-decoration: none;">0800 0008124</a> | Mo-Fr, 08:00 - 18:00 Uhr</span>
                    </div>
                    <div style="height: auto; background: #203E45; color: white; font-size: 9px; letter-spacing: 0.5px; margin-top: 7px;">
                        <p style="text-align: center; padding-top: 12px; margin: 0;">© 2017 - {$smarty.now|date_format:"%Y"} by IT-NERD24 GmbH, Hafenweg 22, 48167 Münster, Deutschland</p>
                        <p style="text-align: center; margin: 4px">DE316383937 , Geschäftsführer : Emran Saljihi </p>
                        <p style="text-align: center; margin: 4px; padding-bottom: 8px">Diese E-Mail wurde automatisch erstellt. Bitte senden Sie Anfragen an <a href="mailto:hallo@it-nerd24.de" rel="nofollow" style="color: white; font-weight: 600; text-decoration: none;" >hallo@it-nerd24.de</a></p>
                    </div>
                </div> 


             </div>';


        $mail->setFromName($fromName);
        $mail->setName(Constants::EMAIL_TEMPLATE_VALID);
        $mail->setSubject($subject);
        $mail->setContent($content);
        $mail->setContentHtml($contentHtml);
        $mail->setIsHtml(true);
        $mail->setFromMail($fromMail);
        
        Shopware()->Models()->persist($mail);
        Shopware()->Models()->flush();
    }
    
    private function deleteEmailTemplate(){
        $mailRepo = Shopware()->Models()->getRepository(Mail::class);
        
        $mail = $mailRepo->findOneByName(Constants::EMAIL_TEMPLATE_VALID);
        
        if(empty($mail)) {
            return;
        }
        
        Shopware()->Models()->remove($mail);        
        Shopware()->Models()->flush();
    }
    
    //////for sending invoice
    private function createEmailTemplateInvoice() {
        $mail = new Mail();
       
        $fromMail = '{config name=mail}';
        $fromName = '{config name=shopName}';
        
        $subject ='Invoice for order {$ordernumber}';
        $content ='{include file="string:{config name=emailheaderplain}"}
                    Dear {$sUser.salutation|salutation} {$sUser.lastname},
                    thank you for your order at {config name=shopName}. In the attachments of this email you will find your order documents in PDF format.
                    {include file="string:{config name=emailfooterplain}"}';
        
        $contentHtml = '<div style="font-family:arial; font-size:12px; width: 680px; margin: 0 auto;">
 
            <!--       header-->
            
            <div class="img-logo">
                <img src="https://it-nerd24.de/media/image/dd/cc/68/logo_breitxxhdpi_logo8QX72mzcUvxKc.png" alt="" style="display: block; padding: 20px; width: 170px; margin: 0 auto;">
            </div>
            <br/><br/>
            <div style="padding:10px; text-align:center; font-size:  17px;background:#203E45;">
                <span style="color: white; width: 275px; text-align: left; font-size: 14px; font-weight: 500; line-height: 19px; padding-left: 25px; letter-spacing: 1px; float: left;">
                    Unser 24h Support
                </span>
                <span style="color: white; font-size: 14px; font-weight: 500; width: 195px; text-align: left; letter-spacing: 1px; line-height: 20px;">
                    <img src="https://it-nerd24.de/media/image/41/2c/f3/email-icon.png" alt=""  style="display: inline-block; width: 20px;vertical-align: middle; position: relative; bottom: 2px; padding-right: 5px;">
                    <a href="mailto:hallo@it-nerd24.de" rel="nofollow" style="color: #97C933; font-size: 14px; text-decoration: none;" >hallo@it-nerd24.de</a>
                </span>
                <span style="color: white; font-size: 14px; font-weight: 500; width: 195px; text-align: left; letter-spacing: 1px;">
                    <img src="https://it-nerd24.de/media/image/67/bf/ef/telephon-white.png" alt=""  style="display: inline-block; width: 20px;vertical-align: middle;">
                    <a href="tel:0800 000 81 24" rel="nofollow" style="color: #97C933; font-size: 14px; text-decoration: none;">0800 / 000 812 4</a>
                </span>
            </div>

            <!--    content-->

            <div style="margin: 60px 190px 80px 160px; text-align: left; font-size: 13px; color: #203E45; line-height: 17px;">
                   <span style=" font-size: 22px; font-weight: 600;">Hallo {$sUser.salutation|salutation} {$sUser.lastname},</span>
                   <br/>
                   <br>
                   <span>anbei erhalten Sie die Rechnung mit Zahlungsdetails zu Ihrer Bestellung mit der Nummer {$ordernumber}.</span>
                    <br/>
                    <br>
                    <br>
                    <br>
                   <div style="border-radius: 20px; width: fit-content; background: #97C933; padding: 9px 55px;">
                       <a href="{$invoiceDownloadLink}" style="cursor: pointer; text-decoration: none; color: #203E45; font-size: 14px; font-weight: 600;">Download invoice</a>
                   </div>
                   <br/>
                </div>
                
           <!--    footer-->
           
            <div style="display: block;">
                <div style="display: inline-block;  border-top: 1px solid #203E45; padding: 25px 40px; width: 600px;">
                    <div style="width: 295px; color: #203E45; line-height: 17px; display: inline-block;">
                        <p style="letter-spacing: 0.3px; font-size: 13px; " >Für Rückfragen stehen wir Ihnen jederzeit gerne zur Verfügung - <a href="mailto:hallo@it-nerd24.de" rel="nofollow" style="color: #203E45; font-weight: 600;" >hallo@it-nerd24.de</a></p>
                        <p style="letter-spacing: 0.3px; font-size: 13px; margin-top: 13px;"> Mit freundlichen Grüßen</p>
                    </div>        
                    <div style="width: 220px; display: inline-block; text-align: right;">
                        <img src="https://it-nerd24.de/media/image/73/70/6f/247.png" alt=""  style=" height: 50px;">
                    </div>        
                </div>
                <div style="height: 42px; background: #203E45; color: white; font-size: 14px; letter-spacing: 0.5px; width: 680px; text-align: center;">
                    <span style="line-height: 40px; padding-left: 25px;">Telefonische Unterstützung und Beratung unter: <a href="tel:0800 000 81 24" rel="nofollow" style="color: #97C933; font-size: 14px; text-decoration: none;">0800 0008124</a> | Mo-Fr, 08:00 - 18:00 Uhr</span>
                </div>
                <div style="height: auto; background: #203E45; color: white; font-size: 9px; letter-spacing: 0.5px; margin-top: 7px;">
                    <p style="text-align: center; padding-top: 12px; margin: 0;">© 2017 - {$smarty.now|date_format:"%Y"} by IT-NERD24 GmbH , Hafenweg 22, 48167 Münster, Deutschland</p>
                    <p style="text-align: center; margin: 4px">DE316383937 , Geschäftsführer : Emran Saljihi </p>
                    <p style="text-align: center; margin: 4px; padding-bottom: 8px">Diese E-Mail wurde automatisch erstellt. Bitte senden Sie Anfragen an <a href="mailto:hallo@it-nerd24.de" rel="nofollow" style="color: white; font-weight: 600; text-decoration: none;" >hallo@it-nerd24.de</a></p>
                </div>
            </div> 

         </div>';


        $mail->setFromName($fromName);
        $mail->setName(Constants::EMAIL_TEMPLATE_SEND_INVOICE);
        $mail->setSubject($subject);
        $mail->setContent($content);
        $mail->setContentHtml($contentHtml);
        $mail->setIsHtml(true);
        $mail->setFromMail($fromMail);
        
        Shopware()->Models()->persist($mail);
        Shopware()->Models()->flush();
    }
    
    private function deleteEmailTemplateInvoice(){
        $mailRepo = Shopware()->Models()->getRepository(Mail::class);
        
        $mail = $mailRepo->findOneByName(Constants::EMAIL_TEMPLATE_SEND_INVOICE);
        
        if(empty($mail)) {
            return;
        }
        
        Shopware()->Models()->remove($mail);        
        Shopware()->Models()->flush();
    }
    
    //////for sending license
    private function createEmailTemplateLicense() {
        $mail = new Mail();
       
        $fromMail = '{config name=mail}';
        $fromName = '{config name=shopName}';
        
        $subject ='✉️Ihre Lizenz für Ihre Bestellung bei {config name=shopName}';
        $content ='{include file="string:{config name=emailheaderplain}"}
                    Dear {$sUser.salutation|salutation} {$sUser.lastname},
                    thank you for your order at {config name=shopName}. In the attachments of this email you will find your order documents in PDF format.
                    {include file="string:{config name=emailfooterplain}"}';
        
        $contentHtml = '<div style="font-family:arial; font-size:12px; width: 680px; margin: 0 auto;">
 
            <!--       header-->
                <div class="img-logo">
                    <img src="https://it-nerd24.de/media/image/dd/cc/68/logo_breitxxhdpi_logo8QX72mzcUvxKc.png" alt="" style="display: block; padding: 20px; width: 170px; margin: 0 auto;">
                </div>
                <br/><br/>
                <div style="padding:10px; text-align:center; font-size:  17px;background:#203E45;">
                    <span style="color: white; width: 275px; text-align: left; font-size: 14px; font-weight: 500; line-height: 19px; padding-left: 25px; letter-spacing: 1px; float: left;">
                        Unser 24h Support
                    </span>
                    <span style="color: white; font-size: 14px; font-weight: 500; width: 195px; text-align: left; letter-spacing: 1px; line-height: 20px;">
                        <img src="https://it-nerd24.de/media/image/41/2c/f3/email-icon.png" alt=""  style="display: inline-block; width: 20px;vertical-align: middle; position: relative; bottom: 2px; padding-right: 5px;">
                        <a href="mailto:hallo@it-nerd24.de" rel="nofollow" style="color: #97C933; font-size: 14px; text-decoration: none;" >hallo@it-nerd24.de</a>
                    </span>
                    <span style="color: white; font-size: 14px; font-weight: 500; width: 195px; text-align: left; letter-spacing: 1px;">
                        <img src="https://it-nerd24.de/media/image/67/bf/ef/telephon-white.png" alt=""  style="display: inline-block; width: 20px;vertical-align: middle;">
                        <a href="tel:0800 000 81 24" rel="nofollow" style="color: #97C933; font-size: 14px; text-decoration: none;">0800 / 000 812 4</a>
                    </span>
                </div>

                <!--    content-->

                <div style="display: flex; margin-top: 60px;">
                    <div style="width: 295px; display: inline-block; align-items: center; float: left; margin-top: 25px;">
                        <img src="https://it-nerd24.de/media/image/d0/a6/92/lizenz_nerd.png" alt="danke"  style="height: 150px;">
                    </div>
                    <div style="width: 385px; margin-bottom: 10px; display: inline-block;">
                        <p class="cl1" style=" font-size: 22px; color: #203E45; letter-spacing: 0.5px; line-height: 17px; margin-bottom: 22px;">Hallo {$user.salutation|salutation} {$user.lastname},</p>    
                            <h2 style="color: #203E45;">{$articleName}</h2>
                            <p class="cl2" style="font-size: 13px; color: #203E45; letter-spacing: 0.5px; line-height: 17px; margin: 13px 0;">Und schon erhalten Sie ihre Lizenznummer:</p>
                            {foreach $esdDetails as $esdDetail}
                                <p class="cl3" style="font-size: 13px;color: #203E45;letter-spacing: 0.5px;line-height: 17px;margin: 25px 0;font-weight: 600;border: 1px solid;padding: 8px 20px;max-width: fit-content;border-radius: 10px;">{$esdDetail.esdSerial}</p>
                            {/foreach}
                            <p class="cl4" style=" font-size: 13px; color: #203E45; letter-spacing: 0.5px; line-height: 17px; margin: 13px 0;">Hier geht es zum Software-Download</p>
                            {foreach $links as $link}
                                    <br><br><a class="cl5" href="{$link.link}" target="_blank" style="cursor: pointer; text-decoration: none; color: #203E45; font-size: 14px; border-radius: 20px; background: #97C933; padding: 9px 20px; font-weight: 600;">{$link.text}</a><br/><br><br>
                            {/foreach}                        
                    </div>
                </div>
                 <div style="width: 605px;">
                    <p style=" font-size: 13px; color: #203E45; letter-spacing: 0.5px; line-height: 17px; margin: 13px 0;"> Bitte behandeln Sie diese Produktschlüssel als sensible Daten. Geben Sie diese keinesfalls weiter und machen Sie diese keinen unbefugten Personen oder Organisationen zugänglich. Auch Personen und Organisationen, die Lizenzüberprüfungen im Auftrag des Herstellers oder Dritter durchführen, sind unbefugt. </p>
                    <br>
                    <p style=" font-size: 13px; color: #203E45; margin: 0; letter-spacing: 0.5px; line-height: 17px; font-weight: 600;">Bitte bewahren Sie diese Produktschlüssel sorgfältig auf und achten Sie darauf, dass eine unbefugte Nutzung keinesfalls erfolgen kann.</p>
                    <br>
                    <p style=" font-size: 13px; color: #203E45; margin: 0; letter-spacing: 0.5px; line-height: 17px;">Bei Sperrungen durch Herausgabe der Produktschlüssel an unbefugte Dritte erfolgt kein Ersatz durch it-nerd24.</p>
                    <br>
                    <p style="font-size: 13px; color: #203E45; margin: 0; letter-spacing: 0.5px; line-height: 17px; margin-bottom: 40px;">Bei Problemen Antworten Sie einfach auf diese eMail oder schreiben Sie eine eMail an <a href="mailto:problem@it-nerd24.de" rel="nofollow" style="color: #203E45; font-size: 14px; text-decoration: underline;" >problem@it-nerd24.de</a></p>
                </div> 

                <!--    footer-->
                <div style="display: block;">
                    <div style="display: inline-block;  border-top: 1px solid #203E45; padding: 25px 40px; width: 600px;">
                        <div style="width: 295px; color: #203E45; line-height: 17px; display: inline-block;">
                            <p style="letter-spacing: 0.3px; font-size: 13px; " >Für Rückfragen stehen wir Ihnen jederzeit gerne zur Verfügung - <a href="mailto:hallo@it-nerd24.de" rel="nofollow" style="color: #203E45; font-weight: 600;" >hallo@it-nerd24.de</a></p>
                            <p style="letter-spacing: 0.3px; font-size: 13px; margin-top: 13px;"> Mit freundlichen Grüßen</p>
                        </div>        
                        <div style="width: 220px; display: inline-block; text-align: right;">
                            <img src="https://it-nerd24.de/media/image/73/70/6f/247.png" alt=""  style=" height: 50px;">
                        </div>        
                    </div>
                    <div style="height: 42px; background: #203E45; color: white; font-size: 14px; letter-spacing: 0.5px; width: 680px; text-align: center;">
                        <span style="line-height: 40px; padding-left: 25px;">Telefonische Unterstützung und Beratung unter: <a href="tel:0800 000 81 24" rel="nofollow" style="color: #97C933; font-size: 14px; text-decoration: none;">0800 0008124</a> | Mo-Fr, 08:00 - 18:00 Uhr</span>
                    </div>
                    <div style="height: auto; background: #203E45; color: white; font-size: 9px; letter-spacing: 0.5px; margin-top: 7px;">
                        <p style="text-align: center; padding-top: 12px; margin: 0;">© 2017 - {$smarty.now|date_format:"%Y"} by IT-NERD24 GmbH, Hafenweg 22, 48167 Münster, Deutschland</p>
                        <p style="text-align: center; margin: 4px">DE316383937 , Geschäftsführer : Emran Saljihi </p>
                        <p style="text-align: center; margin: 4px; padding-bottom: 8px">Diese E-Mail wurde automatisch erstellt. Bitte senden Sie Anfragen an <a href="mailto:hallo@it-nerd24.de" rel="nofollow" style="color: white; font-weight: 600; text-decoration: none;" >hallo@it-nerd24.de</a></p>
                    </div>
                </div> 


             </div>';


        $mail->setFromName($fromName);
        $mail->setName(Constants::EMAIL_TEMPLATE_SEND_LICENSE);
        $mail->setSubject($subject);
        $mail->setContent($content);
        $mail->setContentHtml($contentHtml);
        $mail->setIsHtml(true);
        $mail->setFromMail($fromMail);
        
        Shopware()->Models()->persist($mail);
        Shopware()->Models()->flush();
    }
    
    private function deleteEmailTemplateLicense(){
        $mailRepo = Shopware()->Models()->getRepository(Mail::class);
        
        $mail = $mailRepo->findOneByName(Constants::EMAIL_TEMPLATE_SEND_LICENSE);
        
        if(empty($mail)) {
            return;
        }
        
        Shopware()->Models()->remove($mail);        
        Shopware()->Models()->flush();
    }
}










