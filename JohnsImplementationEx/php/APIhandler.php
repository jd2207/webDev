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
$currencyCode = $_POST["currency"];


// Authentication and end-point needed to process the payment
$url = "https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise";
$username = "ws_586199@Company.AdyenTechSupport";
$password = "Q*-h6a?8Ut!qU<Q(F2y1br{MM";

// Payment info (card plus payment amount etc)
$request = array(
  "merchantAccount" => "JohnDick",   
  "amount" => array(
    "currency" => $currencyCode,
    "value" => $amount
  ),
  "reference" => $reference,
  "card" => array(
    "expiryMonth" => $ccExpM,
    "expiryYear" => $ccExpY,
    "holderName" => $ccName,
    "number" => $ccNumber,
    "cvc" => $ccCVC
  )
);


// Create the curl command
$ch = curl_init($url); 

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-type: application/json")); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST,count(json_encode($request)));
curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($request));
curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
 
// For Debug
curl_setopt($ch, CURLOPT_VERBOSE, true);

// Execute the curl command and capture the output
$output_json = curl_exec($ch);
curl_close($ch);

//Debug
echo '<pre> Request'; print_r($request); echo '</pre>';
echo 'Response ',$output_json,'<br>';


// Result
$res = json_decode($output_json)->{'resultCode'}; // 12345
if ($res == 'Authorised') { echo "Hey, you're payment went through! Thank-you soooo much. Please come again.";
}
else { 
  echo "Oops - there was some kind of problem. Bummer :-(";	
}

?>
</div>
<br>
<a href="/webp.html"> Back to home</a> 

</body>
</html>

