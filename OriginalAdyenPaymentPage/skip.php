<?php

$merchantAccount = $_POST["merchantAccount"];
$amount = $_POST["paymentAmount"];
$skinCode = $_POST["skinCode"];
$currencyCode = $_POST["currencyCode"];
$merchantRef  = $_POST["merchantReference"];
$sessionValidity = $_POST["sessionValidity"];
$brandCode = $_POST["brandCode"];

// Calculate the merchant Sig for the payment
$payParams = array(  
	"currencyCode" => $currencyCode,	
	"merchantAccount" => $merchantAccount,
	"merchantReference" => $merchantRef,
	"paymentAmount" => $amount,
	"sessionValidity" => $sessionValidity,
	"brandCode" => $brandCode,
	"skinCode" => $skinCode,
  );

$hmacKey = "A9A109C4C243D41EC8CB7F8024AEE331B1401FA76C75154206C41F73ED45731B";  

// Create the signature
$escapeval = function($val) {
  return str_replace(':','\\:',str_replace('\\','\\\\',$val));
};
  
ksort($payParams, SORT_STRING);
$signData = implode(":",array_map($escapeval,array_merge(array_keys($payParams), array_values($payParams))));
$merchantSig = base64_encode(hash_hmac('sha256',$signData,pack("H*" , $hmacKey),true));
?>

<form method="post" action="https://test.adyen.com/hpp/skipDetails.shtml" id="adyenForm" name="adyenForm" target="_parent">
         <input type="hidden" name="merchantSig" value=<?php echo $merchantSig ?> />
         <input type="hidden" name="sessionValidity" value=<?php echo $sessionValidity ?> />
         <input type="hidden" name="merchantAccount" value=<?php echo $merchantAccount ?> />
         <input type="hidden" name="paymentAmount" value=<?php echo $amount ?> />
         <input type="hidden" name="currencyCode" value=<?php echo $currencyCode ?> />
         <input type="hidden" name="skinCode" value=<?php echo $skinCode ?> />
         <input type="hidden" name="merchantReference" value=<?php echo $merchantRef ?> />
         <input type="hidden" name="brandCode" value=<?php echo $brandCode ?> />
         <input type="submit" size="20" maxlength="20" value=<?php echo 'Proceed_to_'.$brandCode ?> />
</form>


<?php
/*
// Create urlcodestring and add the signature
foreach($payParams as $field => $value)
  $urlEncodedStr .= $field."=".urlencode($value)."&";
$urlEncodedStr .= "merchantSig=" . urlencode($merchantSig);

// Create the curl command for the payment
$ch = curl_init(); 

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "https://test.adyen.com/hpp/skipDetails.shtml");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $urlEncodedStr);

// Execute the curl command and capture the output
curl_exec($ch);
curl_close($ch);
*/
?>



