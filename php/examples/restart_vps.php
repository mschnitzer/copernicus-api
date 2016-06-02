<?php
 require_once('../CopernicusVPSAPI.class.php');

 $vps = new CopernicusVPSAPI(VPS_SERVER_TOKEN);

 try
 {
     print_r($vps->restart());
 }
 catch(CopernicusAPIInvalidResponse $e)
 {
 	 echo $e;
 }

 echo "\n";
?>
