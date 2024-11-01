<?php
session_start();


if(isset($_REQUEST['order']) && isset($_REQUEST['key'])){

          $payamount=filter_var($_SESSION['payamount'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
     
     
		$var_value=filter_var($_SESSION['myghpayshopname'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."<br><br>";
        
        $myghpayamount=filter_var($_SESSION['myghpayamount'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		
   
		 $myghpayamount=filter_var($_SESSION['myghpayamount'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		
  
		$myghpayitemname=filter_var($_SESSION['myghpayshopname'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		
   
		$myghpayclientref=filter_var($_SESSION['myghpayclientref'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		  
		  
		$myghpayclientsecret=filter_var($_SESSION['myghpayclientsecret'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		
  
		 $myghpayclientid=filter_var($_SESSION['myghpayclientid'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		 
     
		 $myghpaybaseurl=filter_var($_SESSION['myghpaybaseurl'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		 
 
		 $myghpayreturnurl=filter_var($_SESSION['redirect_page_id'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		 
    
		 $myghpaysecurehash=filter_var($_SESSION['myghpayclientsecurehash'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		 
       
		 $shopname=filter_var($_SESSION['myghpayshopname'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		 
        
     
        $txnid = $myghpayclientref.'_'.date("ymds");
        $_SESSION['txnid'] = $txnid;
        

        $productinfo = $shopname. " order payment - $myghpayclientref";		
		$redirect_url =$myghpayreturnurl;// $_SESSION['myghpayreturnurl']; //. "processresponse.php";
		
		$str = $myghpayclientsecret.$myghpayclientref.$myghpayclientid;
        $hash = hash('sha512', $str);
		
		$redirect_url = $redirect_url ."?txnid=".$txnid."&orderkey=".$hash; 

    $raw_string=$myghpayamount.'&'.$productinfo.'&'.$myghpayclientref.'&'.$myghpayclientsecret.'&'.$myghpayclientid;

    $secure_hash=hash_hmac('sha256', $raw_string,$myghpaysecurehash);    

        $myghpay_args = array(
          'amount' => $myghpayamount,
          'itemname' => $productinfo,
          'clientref' => $myghpayclientref,
          'clientsecret' => $myghpayclientsecret,
          'clientid' => $myghpayclientid,
          'returnurl' => $redirect_url,
          'securehash'=>$secure_hash
          );
		  
        $myghpay_args_array = array();
        foreach($myghpay_args as $key => $value){
          $myghpay_args_array[] = "<input type='hidden' name='$key' value='$value'/>";
        }
        echo '<form action="'. esc_attr($myghpaybaseurl) .'" method="post" id="myghpay_payment_form">
            ' . implode('', $myghpay_args_array) . '
            <input type="submit" class="button-alt" id="submit_myghpay_payment_form" value="Submit" type="hidden"/>
            </form>';
} else {
    
    $url ="https://".$_SERVER['SERVER_NAME'];
    header("Location: $url");
die();
    
}

	
?>

<!DOCTYPE html>
<html>
<head>
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

input#submit_myghpay_payment_form {
    display: none !important;
}
</style>
</head>
<body>
<center style="margin-top:5%;">
     

<div class="loader"></div>
<p>Thank you for your order, redirecting...please wait.</p>
    
</center>
 

<script type="text/javascript">
    document.getElementById('myghpay_payment_form').submit();
</script>
</body>
</html>
