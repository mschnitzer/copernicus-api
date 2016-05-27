<?php
 require_once(dirname(__FILE__).'/settings.php');
 require_once(dirname(__FILE__).'/exceptions.php');

 class CopernicusVPSAPI
 {
     private $token = '';

     /**
      * Initializes the class to control one VPS server
      *
      * @param          $token          The API token
      */
     public function __construct($token)
     {
         $this->token = $token;
     }

     /**
      * Starts the VPS server
      */
     public function start()
     {
         $response = $this->deserialize($this->performRequest('/start'));
         $this->checkResult($response);

         return $response;
     }

     private function performRequest($path)
     {
         $curl = curl_init();

         curl_setopt($curl, CURLOPT_URL, API_URL.'/vps'.$path);
         curl_setopt($curl, CURLOPT_POST, 1);
         curl_setopt($curl, CURLOPT_POSTFIELDS, 'token='.$this->token);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

         $response = curl_exec($curl);

         curl_close($curl);

         return $response;
     }

     private function deserialize($response)
     {
         $data = json_decode($response, true);

         if (json_last_error() != JSON_ERROR_NONE)
         {
             throw new CopernicusAPIInvalidResponse('Response not serialized as JSON.');
         }

         if (!isset($data['error']))
         {
             throw new CopernicusAPIInvalidResponse('Response doesn\'t contain an "error" element.');
         }

         return $data;
     }

     private function checkResult($data)
     {
         if ($data['error'] == 1)
         {
             throw new CopernicusAPIInvalidToken();
         }
         else if ($data['error'] > 1)
         {
             throw new CopernicusAPIErrorResponse();
         }
     }
 }
?>
