<?php

namespace ApcCsv\Components;

use ApcCsv\Components\Constants;

class GetNovalnetTrDetails{
    
    public function getNovalnetTransactionDetail($tid){
        // Need to enter your payment access key value here
        $payment_access_key         = Constants::PAYMENT_ACCESS_KEY;     
        
        $tid = (int)$tid;

        // Now, have to encode the $payment_access_key value with the base64 encode
        $encoded_data 				= base64_encode($payment_access_key);

        // Action Endpoint 
        $endpoint                   = 'https://payport.novalnet.de/v2/transaction/details';

        // Build the Headers array
        $headers = [

            // The Content-Type should be "application/json"
            'Content-Type:application/json',

            // The charset should be "utf-8"
            'Charset:utf-8', 

            // Optional
            'Accept:application/json', 

            // The formed authenticate value (case-sensitive)
            'X-NN-Access-Key:' . $encoded_data, 
        ];

        $data = [];

        // Build Merchant Data
        $data['transaction'] = [

            // The TID for which you need to get the details
            'tid' => $tid, 
        ];

        // Custom Data
        $data['custom'] = [

            // Merchant's selected language
            'lang'      => 'EN',
        ];

        // Convert the array to JSON string
        $json_data = json_encode($data);

        // Handle Response
       return $response = $this->send_request($json_data, $endpoint, $headers);
       
    }
     public function send_request($data, $url, $headers) {

            // Initiate cURL
            $curl = curl_init();

            // Set the url
            curl_setopt($curl, CURLOPT_URL, $url);

            // Set the result output to be a string
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            // Set the POST value to true (mandatory)
            curl_setopt($curl, CURLOPT_POST, true);

            // Set the post fields
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            // Set the headers
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            // Execute cURL
            $result = curl_exec($curl);

            // Handle cURL error
            if (curl_errno($curl)) {
                echo 'Request Error:' . curl_error($curl);
                return $result;
            }

            // Close cURL
            curl_close($curl);  

            // Decode the JSON string
            $result = json_decode($result, true);

            return $result;
        }
}