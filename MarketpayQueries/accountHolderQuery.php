<html>
<body>
<div>
<?php

# Pass in the accountHoler and setup the JSON
$ah = $_POST["accountHolder"];
$data = array("accountHolderCode" => $ah);
$data_string = json_encode($data);

// Authentication and end-point needed to process the payment
$url = "https://cal-live.adyen.com/cal/services/Account/v1/getAccountHolder";
$username = "ws_100468@MarketPlace.GoFundMe";
$password = "%H9s62gJsZYvEkU6D(+(?\cW/";

// Create the curl command
$ch = curl_init($url); 

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// Execute the curl command and capture the output
$output = curl_exec($ch);
curl_close($ch);

$json = json_decode($output);
echo "<pre>";
print json_encode($json, JSON_PRETTY_PRINT);
echo"</pre>";
?>

</div>
<br>
<a href="accountHolderForm.html"> Back to query page</a> 

</body>
</html>