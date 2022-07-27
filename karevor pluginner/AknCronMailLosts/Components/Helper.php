<?php

    namespace AknCronMailLosts\Components;

    class Helper {

        public function sendOutputEmail($message, $subject){
           
            $from = "noreply@it-nerd24.de";
            $to = "cli@it-nerd24.de";
            $headers = "From:" . $from;
            mail($to,$subject,$message, $headers);

            //clear from email ausgang
            Shopware()->Db()->query(
                "DELETE FROM `s_core_mails` WHERE `mail_from` = 'noreply@it-nerd24.de'",
            );              
        }
    }
?>