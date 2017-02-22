<html>
<body>

<div>
<?php

$ccNumber = $_POST["number"];
$ccName = $_POST["holderName"];
$ccExpM = $_POST["expiryMonth"];
$ccExpY = $_POST["expiryYear"]; 
$ccCVC = $_POST["cvc"]; 
$amount = $_POST["amount"]; 
$reference = $_POST["ref"]; 

// Hardwire payment currency and merchant
$currencyCode = 'USD';
$merchant = 'AdyenTest';

// Authentication and end-point needed to process the payment
$url = "https://pal-test.adyen.com/pal/adapter/httppost";
$username = "ws_091016@Company.AdyenTechSupport";
$password = "E)d*AJ4M>3e[8D?IAPvpW=%}?";

// Payment info (card plus payment amount etc)
$data = array(
    'action' => 'Payment.authorise',
    'paymentRequest.card.number' => $ccNumber,
    'paymentRequest.card.expiryMonth' => $ccExpM,
    'paymentRequest.card.expiryYear' => $ccExpY,
    'paymentRequest.card.cvc' => $ccCVC,
    'paymentRequest.card.holderName' => $ccName,
    'paymentRequest.amount.currency' => $currencyCode,
    'paymentRequest.amount.value' => $amount,
    'paymentRequest.merchantAccount' => $merchant,
    'paymentRequest.reference' => $reference,
);

// Create the curl command
$ch = curl_init($url); 

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);

// Execute the curl command and capture the output
$output = curl_exec($ch);
curl_close($ch);

// debug output
parse_str($output, $parsedoutput);

if ($parsedoutput['paymentResult_resultCode'] == 'Authorised') 
  { echo "Hey, you're payment went through! Thank-you soooo much. Please come again.";
  }
else
  { echo "Oops - there was some kind of problem. Bummer :-(";	
  }

/*
echo "<pre>";
print_r($parsedoutput);
echo "</pre>";
*/

?>
</div>
<br>
<a href="index.html"> Back to home</a> 

</body>
</html>

