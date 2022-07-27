<?php

/**
* use  this service  - Shopware()->Container()->get('akn_cron_mail_losts.send_lost_mail');
*/

namespace AknCronMailLosts\Services;

use AknCronMailLosts\Components\Constants;

class SendLostMail {
        
    public function cron(){
        //write logic and send mail

        $sentMailCount = 0; 
        $db = Shopware()->Db();

        $lastOrderdateMin = date('Y-m-d', strtotime('-31 day'));      
        $lastOrderdateMax = date('Y-m-d', strtotime('-30 day'));     

        $dateHour = date('H');
        $dateHourLong = date('Y-m-d H:i:s');
        
        if ($dateHour > 15 || $dateHour < 11){
            return "command lost executed $dateHourLong // sent mail count - 0 // message - try to send emails in impermissible time";
        }       

        $usersdb = $db->fetchAll(
            "SELECT                 
                `s_order`.`id` as orderId, `s_user`.`id` as userId, `s_user`.`email`
            FROM `s_order` 
            LEFT JOIN `s_user` 
                ON (`s_order`.`userID` = `s_user`.`id`)
            LEFT JOIN `s_user_attributes`
                ON  (`s_user`.`id` = `s_user_attributes`.`userID`)
            WHERE `s_order`.`ordertime` > :ordertimemin
            AND `s_order`.`ordertime` < :ordertimemax
            AND `s_order`.`userID` NOT IN (SELECT `s_order`.`userID` FROM `s_order` WHERE `s_order`.`ordertime` > :ordertimemax)
            AND `s_user`.`accountmode` = 0
            AND NOT `s_user`.`id` IN (SELECT `user_id` FROM `akn_lost_customer_email_history` WHERE `email_type` = 'lost')
            AND `s_user_attributes`.`unsubscribe_lost_mail` = 0
            AND (`s_user`.`subshopID` = 1 OR `s_user`.`subshopID` = 4 OR `s_user`.`subshopID` = 5)
            LIMIT 99;",
            [':ordertimemin' => $lastOrderdateMin, ':ordertimemax' => $lastOrderdateMax]
        );      

        //remove dublicates
        $users = [];        
        foreach ($usersdb as $item){
            $index = $item['userId'];
            $users["$index"] = $item;            
        }       
       
        $userString = '';        

        foreach ($users as $user){            
            $this->sendMail($user['email'], $user['userId']);      
            $userString = $userString . $user['email'] . '; ';         
            $db->insert('akn_lost_customer_email_history', [
                'user_id' => $user['userId'],
                'user_email' => $user['email'],
                'voucher_name' => Constants::VOUCHER_LOST,
                'email_type' => 'lost',
                'last_order_id' => $user['orderId'],
                'send_date' => $dateHourLong,
            ]);       
        }    
        
        $sentMailCount = count($users); 
        $userString = str_replace(";","\r\n",$userString);
        return "Command lost executed $dateHourLong \r\n\r\nSent mail count - $sentMailCount \r\n\r\n $userString";
    }
    
    private function sendMail($email, $userId){         

        $context['unsubscribeLink'] = "https://it-nerd24.de/guschunsubscr?tp=l&ci=$userId&token=t8pn2n20w66z6axobr0n9422rw6xbffze0zxtrpz6w3yz6rn7su0ps5vf";

        $mail = Shopware()->TemplateMail()->createMail(Constants::EMAIL_TEMPLATE_LOST, $context);       
        $mail->addTo($email);

        try {
            $mail->send();
        } catch(\Exception $ex) {
            die($ex->getMessage()); 
        }    
    }    
}