<?php

/**
* use  this service  - Shopware()->Container()->get('akn_cron_mail_losts.send_rgister_birthday_mail');
*/

namespace AknCronMailLosts\Services;

use AknCronMailLosts\Components\Constants;

class SendRegisterBirthdayMail {
    
    public function cron(){
        
        $sentMailCount = 0; 
        $db = Shopware()->Db();
        $registerDayLastYear = date('Y-m-d', strtotime('-1 years'));
        $dateHour = date('H');
        $dateHourLong = date('Y-m-d H:i:s');

        if ($dateHour > 15 || $dateHour < 11){
            return "command registerBirthday executed $dateHourLong // sent mail count - 0 // message - try to send emails in impermissible time";
        }       

        $users = $db->fetchAll(
            "SELECT `s_user`.`id` as userId, `s_user`.`email`
            FROM `s_user` 
            LEFT JOIN `s_user_attributes`
                    ON  (`s_user`.`id` = `s_user_attributes`.`userID`)
            WHERE
            `s_user`.`firstlogin` = :first_login
            AND `accountmode` = 0
            AND NOT `s_user`.`id` IN (SELECT `user_id` FROM `akn_lost_customer_email_history` WHERE `email_type` = 'birthday')
            AND `s_user_attributes`.`unsubscribe_birthday_mail` = 0
            AND (`s_user`.`subshopID` = 1 OR `s_user`.`subshopID` = 4 OR `s_user`.`subshopID` = 5);",
            [':first_login' => $registerDayLastYear]
        );        

        $userString = '';        

        foreach ($users as $user){            
            $this->sendMail($user['email'], $user['userId']);      
            $userString = $userString . $user['email'] . '; ';         
            $db->insert('akn_lost_customer_email_history', [
                'user_id' => $user['userId'],
                'user_email' => $user['email'],
                'voucher_name' => Constants::VOUCHER_REGISTER_BIRTHDAY,
                'email_type' => 'birthday',
                'send_date' => $dateHourLong,
            ]);       
        }    
        
        $sentMailCount = count($users); 
        $userString = str_replace(";","\r\n",$userString);
        return "Command registerBirthday executed $dateHourLong \r\n\r\nSent mail count - $sentMailCount \r\n\r\n $userString";
    }
    
    private function sendMail($email, $userId){ 

        $context['unsubscribeLink'] = "https://it-nerd24.de/guschunsubscr?tp=b&ci=$userId&token=t8pn2n20w66z6axobr0n9422rw6xbffze0zxtrpz6w3yz6rn7su0ps5vf";

        $mail = Shopware()->TemplateMail()->createMail(Constants::EMAIL_TEMPLATE_REGISTER_BIRTHDAY, $context);       
        $mail->addTo($email);

        try {
            $mail->send();
        } catch(\Exception $ex) {
            die($ex->getMessage()); 
        }    
    }
}