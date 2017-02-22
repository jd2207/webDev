<html>
<body>

<h1> Confirmation </h1>

<?php
// Amount passed from previous page
$amount = $_POST["money"];

// Hardwired values
$merchantAccount = "AdyenTest";
$currency = "USD";
$locale = "en_US";

// Calculate dates
$sessionValidity = date("Y-m-d",strtotime("+2 days"));
$shipBeforeDate = date("Y-m-d",strtotime("+3 days"));

echo "You have agreed to give me".' $'.$amount.'. Awesome!'."<br>";
echo 'Now, if you would be so kind, please pay by providing your card info below:';
?>


<!--
     The crappy way of doing it 
  -->
<div>
<br><br>
<form method="POST" action="handler.php">
    Card number: <input type="text" size="20" autocomplete="off" name="number" /></br>
    Name: <input type="text" size="20" autocomplete="off" name="holderName" /></br>
    Exp month: <input type="text" size="2" maxlength="2" autocomplete="off" name="expiryMonth" /></br>
    Exp year: <input type="text" size="4" maxlength="4" autocomplete="off" name="expiryYear" /></br>
    CVC: <input type="text" size="4" maxlength="4" autocomplete="off" name="cvc" /></br>

    <input type="hidden" name="ref" value="insecure method" />
    <input type="hidden" name="amount" value=<?php echo $amount ?> />
    <input type="hidden" value="generate-this-server-side" name="generationtime" />
    <input type="submit" value="Submit insecure pay" />
</form>
</div>

<br><br><br>

<!--
     Make a button for directing to Adyen HPP 
-->

<h3> OR ... click on the button below for cooler (and more secure) Adyen hosted page:</h3>
<?php
    $skinCode        = "jW3AYKkb";
    $hmacKey         = "598FC5C08314295B55B5F90E3850180139D986E9F77E76D713EA54BCF2452290";
    
    $params = array(
                    "merchantReference" => 'HPP method',
                    "merchantAccount"   => $merchantAccount,
                    "currencyCode"      => $currency,
                    "paymentAmount"     => $amount,
                    "sessionValidity"   => $sessionValidity,
                    "shipBeforeDate"    => $shipBeforeDate,
                    "shopperLocale"     => $locale,
                    "skinCode"          => $skinCode,
    );

// The character escape function
    $escapeval = function($val) {
        return str_replace(':','\\:',str_replace('\\','\\\\',$val));
    };
    
    // Sort the array by key using SORT_STRING order
    ksort($params, SORT_STRING);
    
    // Generate the signing data string
    $signData = implode(":",array_map($escapeval,array_merge(array_keys($params), array_values($params))));
    
    // base64-encode the binary result of the HMAC computation
    $merchantSig = base64_encode(hash_hmac('sha256',$signData,pack("H*" , $hmacKey),true));
    $params["merchantSig"] = $merchantSig;
?>

<form name="adyenForm" action="https://test.adyen.com/hpp/select.shtml" method="post">
<?php
    foreach ($params as $key => $value){
        echo '        <input type="hidden" name="' .htmlspecialchars($key,   ENT_COMPAT | ENT_HTML401 ,'UTF-8').
        '" value="' .htmlspecialchars($value, ENT_COMPAT | ENT_HTML401 ,'UTF-8') . '" />' ."\n" ;
    }
    ?>
<input type="submit" value="Secure pay, hosted by Adyen" />
</form>




<!--
     Example of directory lookup
-->

<?php
$skinCode = "zycc21v2";
$hmacKey = "A9A109C4C243D41EC8CB7F8024AEE331B1401FA76C75154206C41F73ED45731B";  
$currencyCode = "EUR";
$merchantAccount = "AdyenTest";
$merchantReference = "Dirlookup";
$params = array(  
	"currencyCode" => $currencyCode,	
	"merchantAccount" => $merchantAccount,
	"merchantReference" => $merchantReference,
	"paymentAmount" => $amount,
	"sessionValidity" => $sessionValidity,
	"shipBeforeDate" => $shipBeforeDate,
	"skinCode" => $skinCode, 
  );

// Sort the array by key using SORT_STRING order
ksort($params, SORT_STRING);
 
// Generate the signing data string
$signData = implode(":",array_map($escapeval,array_merge(array_keys($params), array_values($params))));

foreach($params as $field => $value)
  $urlEncodedStr .= $field."=".urlencode($value)."&";
    
// base64-encode the binary result of the HMAC computation
$merchantSig1 = base64_encode(hash_hmac('sha256',$signData,pack("H*" , $hmacKey),true));
   
// Add the signature
$urlEncodedStr .= "merchantSig=" . urlencode($merchantSig1);

// Create the curl command for directory lookup
$ch = curl_init(); 

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "https://test.adyen.com/hpp/directory.shtml");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $urlEncodedStr);

// Execute the curl command and capture the output
$output = curl_exec($ch);
curl_close($ch);

$paymentMethods = json_decode($output,true)["paymentMethods"];
?>

<br>
<br>
<h3> ** If you are in the UK, you need to use the options below:</h3>
<form method="post" action="skip.php"> 
  <?php
    $pre = '<input type="radio" name="brandCode" value=';
    foreach($paymentMethods as $method)
      echo $pre . $method["brandCode"].'>' . $method["name"] . '<br>';
  ?>
  <input type="hidden" name="sessionValidity" value=<?php echo $sessionValidity ?> />
  <input type="hidden" name="merchantAccount" value=<?php echo $merchantAccount ?> />
  <input type="hidden" name="paymentAmount" value=<?php echo $amount ?> />
  <input type="hidden" name="currencyCode" value=<?php echo $currencyCode ?> />
  <input type="hidden" name="skinCode" value=<?php echo $skinCode ?> />
  <input type="hidden" name="merchantReference" value=<?php echo $merchantReference ?> />
  <input type="submit" value="Make the payment" />
</form>

</body>
</html>



