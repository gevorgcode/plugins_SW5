<?php
namespace AknCronMailLosts;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Doctrine\ORM\Tools\SchemaTool;
use AknCronMailLosts\Models\LostCustomerEmailHistory;
use Shopware\Models\Mail\Mail;
use AknCronMailLosts\Components\Constants;

//@to do sender mail change to noreply@it-nerd24.de

class AknCronMailLosts extends Plugin
{
	public function install(InstallContext $context){

		//create model
		$em = $this->container->get('models');
		$tool = new SchemaTool($em);
		$classes = [$em->getClassMetadata(LostCustomerEmailHistory::class)];
		$tool->createSchema($classes);

		//create attributyes
		$service = $this->container->get('shopware_attribute.crud_service');
        $service->update('s_user_attributes', 'unsubscribe_lost_mail', 'boolean');
        $service->update('s_user_attributes', 'unsubscribe_birthday_mail', 'boolean');

		//create templates
		$this->createLostEmailTemplate();
		$this->createBirthdaytEmailTemplate();

		//add vouchers
		$this->createVouchers();

		$context->scheduleClearCache(UninstallContext::CACHE_LIST_ALL);
	}

	public function uninstall(UninstallContext $context){
 
		//remove model
		$em = $this->container->get('models');
		$tool = new SchemaTool($em);
		$classes = [$em->getClassMetadata(LostCustomerEmailHistory::class)];
		$tool->dropSchema($classes);		

		//remove email templates
		$this->deleteLostEmailTemplate();
		$this->deleteBirthdaytEmailTemplate();
	}

	private function createLostEmailTemplate(){
		$mail = new Mail();
       
        $fromMail = 'noreply@it-nerd24.de';
        $fromName = '{config name=shopName}';
        
        $subject ='Wir vermissen dich jetzt schon.';
        $content ='';
        
        $contentHtml = '<div style="font-family: arial; font-size: 12px; width: 680px; margin: 0 auto;"><!-- header-->
		<div class="img-logo"><img style="display: block; padding: 20px; width: 170px; margin: 0 auto;" src="https://it-nerd24.de/media/vector/9e/e1/81/it-nerd24_10years.svg" alt="" /></div>
	
		<div style="padding: 8px; background: #203E45;"></div>
		<!-- content-->
		<div style="display: flex; width: 590px; margin-bottom: 40px;">
		<div style="width: 280px; display: inline-block; float: left; align-items: center; justify-content: center; height: 200px; margin-top: 30px; margin-left: 30px;">
			<img style="height:207px; width: 295px;" src="https://it-nerd24.de/media/vector/33/19/e0/Gruppe_425.svg" alt="" /></div>
		<div style="width: 250px; display: inline-block; color: #203e45; margin-left: 50px; margin-top: 15px;">
			<p style="font-size: 14px; margin: 15px 0"><span style="font: normal normal bold 22px/26px arial;">Klopf klopf - bist du noch da?</span></p>
	
			<p style="font: normal normal normal 13px/17px arial; margin: 0;">Vor einem Monat hast du bei uns etwas gekauft und wir würden uns freuen dich wieder zu sehen.</p>
			<p style="font: normal normal normal 13px/17px arial;">Als kleinen Anreiz schenken wir dir <b>5€ Rabatt</b> auf deine nächste Bestellung.</p>
			<br>
			<div style="text-align: center; height: 34px; background: #97c933; align-items: center; display: flex; border-radius: 20px; margin-top: 15px;"><a class="cl5" style="cursor: pointer; text-decoration: none; color: #203e45; font-size: 14px; border-radius: 20px; padding: 7px 30px; font-weight: 600; margin: 0 auto; display: inline-block;" href="https://it-nerd24.de/" target="_blank">it-nerd24</a></div>
		</div>
		</div>
	
		<div style="width: 500px; margin: 0 auto;">
		<p style="font: normal normal bold 24px/26px arial; color: #203e45;">So kommst du an den Rabatt:</p>    
		<p style="font: normal normal normal 13px/17px Arial; color: #203e45;">Wir schenken dir <b>5€ auf deinen gesamten Einkauf.</b> <br>Nutze dazu einfach deinen individuellen <b>5€-Code</b> im Warenkorb.</p>    
		</div>
	
		<div style="width: 680px; margin: 0 auto; height: 65px; background: #97C933; text-align: center; margin-top: 40px; margin-bottom: 40px;">
			<span style="font-size: 22px; font-weight: bold; color: #203e45; display: inline-block; line-height: 65px;">Dein 5€-Code</span>
			<span style="background: white; padding: 8px 20px; border-radius: 10px; border: 1px solid #203e45; color: #203e45; margin-left: 10px; line-height: 13px; font-size: 13px; font-weight: bold; margin-right: 10px; display: inline-block; position: relative; bottom: 3px;">' . Constants::VOUCHER_LOST . '</span>
			<img src="https://it-nerd24.de/media/vector/8b/d1/2c/Gruppe_397.svg" alt="">
		</div>
	
		<div style="width: 500px; margin: 0 auto; margin-bottom: 40px;">
		<p style="font: normal normal bold 24px/26px arial; color: #203e45;">Fragen &amp; Antworten</p>
		<p style="font: normal normal normal 14px/17px Arial; color: #203e45;">Vielleicht k&ouml;nnen wir Ihnen auch noch schneller helfen. Besuchen Sie einfach unser it-nerd24 Wiki. Hier beantworten wir die am h&auml;ufigst gestellten Fragen. Vielleicht ist Ihre ja auch dabei!</p>
		<div style="text-align: center; margin-top: 40px;"><a class="cl5" style="cursor: pointer; text-decoration: none; color: #203e45; font-size: 14px; border-radius: 20px; background: #97C933; padding: 9px 90px; font-weight: 600;" href="https://it-nerd24.zendesk.com/hc/de" target="_blank">Fragen &amp; Antworten</a></div>
		<br>

		<br><br><br>
		
		<p style="font: normal normal normal 14px/17px Arial; color: #203e45;">Kein Interesse an unseren E-Mails? <a class="cl5" style="font-weight: 600; color: #97c933;" href="{$unsubscribeLink}" target="_blank">Abmelden</a></p>
		</div>
		</div>
		<!-- footer-->
		<div style="display: block;">
		<div style="height: 42px; background: #203E45; color: white; font-size: 14px; letter-spacing: 0.5px; width: 680px; text-align: center;"><span style="line-height: 40px; padding-left: 25px;">Telefonische Unterst&uuml;tzung und Beratung unter: <a style="color: #97c933; font-size: 14px; text-decoration: none;" href="tel:0800 000 81 24" rel="nofollow">0800 0008124</a> | Mo-Fr, 09:00 - 17:00 Uhr</span></div>
		<div style="height: auto; background: #203E45; color: white; font-size: 9px; letter-spacing: 0.5px; margin-top: 7px;">
		<p style="text-align: center; padding-top: 12px; margin: 0;">&copy; 2017 - 2022 by IT-NERD24 GmbH, Hafenweg 22, 48155 M&uuml;nster, Deutschland</p>
		<p style="text-align: center; margin: 4px;">DE316383937 , Gesch&auml;ftsf&uuml;hrer : Emran Saljihi</p>
		<p style="text-align: center; margin: 4px; padding-bottom: 8px;">Diese E-Mail wurde automatisch erstellt.</p>
		</div>
		</div>
		</div>';


        $mail->setFromName($fromName);
        $mail->setName(Constants::EMAIL_TEMPLATE_LOST);
        $mail->setSubject($subject);
        $mail->setContent($content);
        $mail->setContentHtml($contentHtml);
        $mail->setIsHtml(true);
        $mail->setFromMail($fromMail);
        
        Shopware()->Models()->persist($mail);
        Shopware()->Models()->flush();
	}

	private function deleteLostEmailTemplate(){
        $mailRepo = Shopware()->Models()->getRepository(Mail::class);
        
        $mail = $mailRepo->findOneByName(Constants::EMAIL_TEMPLATE_LOST);
        
        if(empty($mail)) {
            return;
        }
        
        Shopware()->Models()->remove($mail);        
        Shopware()->Models()->flush();
    }

	private function createBirthdaytEmailTemplate(){
		$mail = new Mail();
       
        $fromMail = 'noreply@it-nerd24.de';
        $fromName = '{config name=shopName}';
        
        $subject ='Es ist Zeit zu feiern.';
        $content ='';
        
        $contentHtml = '<div style="font-family: arial; font-size: 12px; width: 680px; margin: 0 auto;"><!-- header-->
		<div class="img-logo"><img style="display: block; padding: 20px; width: 170px; margin: 0 auto;" src="https://it-nerd24.de/media/vector/9e/e1/81/it-nerd24_10years.svg" alt="" /></div>
	
		<div style="padding: 8px; background: #203E45;"></div>
		<!-- content-->
		<div style="display: flex; width: 590px; margin-bottom: 40px; margin-top: 20px">
		<div style="width: 280px; display: inline-block; float: left; align-items: center; justify-content: center; height: 200px; margin-top: 30px; margin-left: 30px;">
			<img style="height:207px; width: 295px;" src="https://it-nerd24.de/media/vector/87/35/b1/Gruppe_424.svg" alt="" /></div>
		<div style="width: 250px; display: inline-block; color: #203e45; margin-left: 50px; margin-top: 15px;">
			<p style="font-size: 14px; margin: 15px 0px;"><span style="font: normal normal bold 22px/26px arial;">Es gibt was zu feiern!</span></p>
	
			<p style="font: normal normal normal 13px/17px arial; margin: 0;">Vor genau <b>einem Jahr</b> hast du dich bei uns registriert. Und das wollen wir mit dir feiern.</p>
			<p style="font: normal normal normal 13px/17px arial;">Für deine Treue wollen wir dir etwas schenken und freuen uns auf dich bei</p>
			<br>
			<div style="text-align: center; height: 34px; background: #97c933; align-items: center; display: flex; border-radius: 20px; margin-top: 20px;"><a class="cl5" style="cursor: pointer; text-decoration: none; color: #203e45; font-size: 14px; border-radius: 20px; padding: 7px 30px; font-weight: 600; margin: 0 auto; display: inline-block;" href="https://it-nerd24.de/" target="_blank">it-nerd24</a></div>
		</div>
		</div>
	
		<div style="width: 500px; margin: 0 auto; margin-top: 40px; margin-bottom: 40px;">
		<p style="font: normal normal bold 24px/26px arial; color: #203e45;">Unser Geschenk an dich nach einem Jahr:</p>    
		<p style="font: normal normal normal 13px/17px Arial; color: #203e45;">Zu deinem Jahrestag bei uns schenken wir dir <b>10% auf deinen gesamten Einkauf.</b> Nutze dazu einfach deinen individuellen <b>Geschenk-Code</b> im Warenkorb.</p>    
		</div>
	
		<div style="width: 680px; margin: 0 auto; height: 65px; background: #97C933; text-align: center;">
			<span style="font-size: 22px; font-weight: bold; color: #203e45; display: inline-block; line-height: 65px;">Geschenk-Code</span>
			<span style="background: white; padding: 8px 20px; border-radius: 10px; border: 1px solid #203e45; color: #203e45; margin-left: 10px; line-height: 13px; font-size: 13px; font-weight: bold; margin-right: 10px; display: inline-block; position: relative; bottom: 3px;">' . Constants::VOUCHER_REGISTER_BIRTHDAY . '</span>
			<img src="https://it-nerd24.de/media/vector/8b/d1/2c/Gruppe_397.svg" alt="">
		</div>
	
		<div style="width: 500px; margin: 0 auto; margin-bottom: 40px; margin-top: 40px;">
		<p style="font: normal normal bold 24px/26px arial; color: #203e45;">Fragen &amp; Antworten</p>
		<p style="font: normal normal normal 14px/17px Arial; color: #203e45;">Vielleicht k&ouml;nnen wir Ihnen auch noch schneller helfen. Besuchen Sie einfach unser it-nerd24 Wiki. Hier beantworten wir die am h&auml;ufigst gestellten Fragen. Vielleicht ist Ihre ja auch dabei!</p>
		<div style="text-align: center; margin-top: 40px;"><a class="cl5" style="cursor: pointer; text-decoration: none; color: #203e45; font-size: 14px; border-radius: 20px; background: #97C933; padding: 9px 90px; font-weight: 600;" href="https://it-nerd24.zendesk.com/hc/de" target="_blank">Fragen &amp; Antworten</a></div>
		<br>

		<br><br><br>
		
		<p style="font: normal normal normal 14px/17px Arial; color: #203e45;">Möchten Sie keine E-Mails von uns erhalten? <a class="cl5" style="font-weight: 600; color: #97c933;" href="{$unsubscribeLink}" target="_blank">Abmelden</a></p>
		</div>
		</div>
		<!-- footer-->
		<div style="display: block;">
		<div style="height: 42px; background: #203E45; color: white; font-size: 14px; letter-spacing: 0.5px; width: 680px; text-align: center;"><span style="line-height: 40px; padding-left: 25px;">Telefonische Unterst&uuml;tzung und Beratung unter: <a style="color: #97c933; font-size: 14px; text-decoration: none;" href="tel:0800 000 81 24" rel="nofollow">0800 0008124</a> | Mo-Fr, 09:00 - 17:00 Uhr</span></div>
		<div style="height: auto; background: #203E45; color: white; font-size: 9px; letter-spacing: 0.5px; margin-top: 7px;">
		<p style="text-align: center; padding-top: 12px; margin: 0;">&copy; 2017 - 2022 by IT-NERD24 GmbH, Hafenweg 22, 48155 M&uuml;nster, Deutschland</p>
		<p style="text-align: center; margin: 4px;">DE316383937 , Gesch&auml;ftsf&uuml;hrer : Emran Saljihi</p>
		<p style="text-align: center; margin: 4px; padding-bottom: 8px;">Diese E-Mail wurde automatisch erstellt.</p>
		</div>
		</div>
		</div>';


        $mail->setFromName($fromName);
        $mail->setName(Constants::EMAIL_TEMPLATE_REGISTER_BIRTHDAY);
        $mail->setSubject($subject);
        $mail->setContent($content);
        $mail->setContentHtml($contentHtml);
        $mail->setIsHtml(true);
        $mail->setFromMail($fromMail);
        
        Shopware()->Models()->persist($mail);
        Shopware()->Models()->flush();
	}

	private function deleteBirthdaytEmailTemplate(){
        $mailRepo = Shopware()->Models()->getRepository(Mail::class);
        
        $mail = $mailRepo->findOneByName(Constants::EMAIL_TEMPLATE_REGISTER_BIRTHDAY);
        
        if(empty($mail)) {
            return;
        }
        
        Shopware()->Models()->remove($mail);        
        Shopware()->Models()->flush();
    }

	private function createVouchers(){

		$db = Shopware()->Db();

		$voucherLost = $db->fetchOne(
            'SELECT `description`
            FROM s_emarketing_vouchers             
            WHERE `description` = :voucher_name',
            ['voucher_name' => Constants::VOUCHER_LOST]
        ); 
		
		if (!$voucherLost){
			$db->query(
				"INSERT INTO `s_emarketing_vouchers`
				SET 
				`description` = :descript,
				`vouchercode` = :vouchercode,
				`numberofunits` = 100000000,
				`value` = 5,
				`minimumcharge` = 5, 
				`shippingfree` = 0, 
				`bindtosupplier` = NULL, 
				`valid_from` = NULL,
				`valid_to` = NULL,
				`ordercode` = :ordercode,
				`modus` = 0,
				`percental` = 0,
				`numorder` = 1,
				`customergroup` = NULL,
				`restrictarticles` = '',
				`strict` = 0,
				`subshopID` = NULL,
				`taxconfig` = 'auto',
				`customer_stream_ids` = NULL
				;",
				[
					':descript' => Constants::VOUCHER_LOST,
					':vouchercode' => Constants::VOUCHER_LOST,
					':ordercode' => Constants::VOUCHER_LOST,
				]
			);			
		}

		$voucherBirthdaytEmail = $db->fetchOne(
            'SELECT `description`
            FROM s_emarketing_vouchers             
            WHERE `description` = :voucher_name',
            ['voucher_name' => Constants::VOUCHER_REGISTER_BIRTHDAY]
        ); 

		if (!$voucherBirthdaytEmail){
			$db->query(
				"INSERT INTO `s_emarketing_vouchers`
				SET 
				`description` = :descript,
				`vouchercode` = :vouchercode,
				`numberofunits` = 100000000,
				`value` = 10,
				`minimumcharge` = 0, 
				`shippingfree` = 0, 
				`bindtosupplier` = NULL, 
				`valid_from` = NULL,
				`valid_to` = NULL,
				`ordercode` = :ordercode,
				`modus` = 0,
				`percental` = 1,
				`numorder` = 1,
				`customergroup` = NULL,
				`restrictarticles` = '',
				`strict` = 0,
				`subshopID` = NULL,
				`taxconfig` = 'auto',
				`customer_stream_ids` = NULL
				;",
				[
					':descript' => Constants::VOUCHER_REGISTER_BIRTHDAY,
					':vouchercode' => Constants::VOUCHER_REGISTER_BIRTHDAY,
					':ordercode' => Constants::VOUCHER_REGISTER_BIRTHDAY,
				]
			);
		}

	}
}