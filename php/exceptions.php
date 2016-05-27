<?php
 class CopernicusAPIException extends Exception { }
 class CopernicusAPIInvalidToken extends CopernicusAPIException {}

 class CopernicusAPIInvalidResponse extends CopernicusAPIException
 {
     public $message;

     public function __construct($message)
     {
         $this->message = $message;
     }

     public function getErrorMessage()
     {
         return $this->message;
     }

     public function __toString()
     {
         return $this->message;
     }
 }

 class CopernicusAPIErrorResponse extends CopernicusAPIException
 {
     public $data = array();

     public function __construct($data)
     {
         $this->data = $data;
     }

     public function getErrorCode()
     {
         return intval($this->data['error']);
     }

     public function getErrorMessage()
     {
         if (isset($this->data['message']))
         {
             return $this->data['message'];
         }

         return '';
     }

     public function __toString()
     {
         echo "API Error (".intval($this->data['error'])."): ".htmlspecialchars($this->data['message']);
     }
 }
?>
