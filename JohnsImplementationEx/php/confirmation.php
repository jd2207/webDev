<html>
<body>

<h1> Confirmation </h1>

<?php
// Amount passed from previous page
$amount = $_POST["money"];

// Confirmation
echo "You have agreed to give me".' $'.$amount.'. Awesome!'."<br><br><br>";
echo 'Choose a payment method below...'."<br><br><br>";

// Hardwired values
$merchantAccount = "JohnDick";
$currency = "USD";
$locale = "en_US";
?>

<!--
     Credit card API 
-->
CREDIT CARD API
<form method="POST" action="APIhandler.php">
    <input type="hidden" name="amount" value=<?php echo $amount ?> />

    Card number: <input type="text" size="20" autocomplete="off" name="number" value="4111111111111111"/></br>
    Name: <input type="text" size="20" autocomplete="off" name="holderName" value="John Smith"/></br>
    Exp month: <input type="text" size="2" maxlength="2" autocomplete="off" name="expiryMonth" value="08"/></br>
    Exp year: <input type="text" size="4" maxlength="4" autocomplete="off" name="expiryYear" value="2018"/></br>
    CVC: <input type="text" size="4" maxlength="4" autocomplete="off" name="cvc" value="737"/></br>
    Merchant ref: <input type="hidden" name="ref" value="test" /><br>

    <input type="hidden" name="merchant" value=<?php echo $merchantAccount ?> />
    <input type="hidden" name="currency" value=<?php echo $currency ?> />
    <input type="hidden" name="amount" value=<?php echo $amount ?> />
    <input type="hidden" value="generate-this-server-side" name="generationtime" />

    <input type="submit" value="Pay by credit card - direct API (PHP)"/>
</form>

<br>
<br>
<br>

<!--
     Redirect to HPP 
-->


<!-- PHP to build parameter array including signature -->
<?php
    $skinCode        = "Svfn7CG2";
    $hmacKey         = "84FF73BE5CAB37184CD80EB1A04000877885E2DCEEF42E6BE1880054296C61C9";
    $now = new DateTime('America/Los_Angeles');
    $sessionValidity = $now->modify('+1 hour');

    $params = array(
                    "merchantReference" => 'HPP method',
                    "merchantAccount"   => $merchantAccount,
                    "currencyCode"      => $currency,
                    "paymentAmount"     => $amount,
                    "sessionValidity"   => $sessionValidity->format(DateTime::ATOM),                   
                    "shopperLocale"     => $locale,
                    "skinCode"          => $skinCode
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

#    print_r ($params);
?>


USE ADYEN HPP TO COLLECT CARD DATA
<br>
<form name="adyenForm" action="https://test.adyen.com/hpp/select.shtml" method="post">
<?php
    foreach ($params as $key => $value){
        echo '         <input type="hidden" name="' .htmlspecialchars($key,   ENT_COMPAT | ENT_HTML401 ,'UTF-8').
        '" value="' .htmlspecialchars($value, ENT_COMPAT | ENT_HTML401 ,'UTF-8') . '" />' ."\n" ;
    }
?>
<input type="submit" value="Secure pay, hosted by Adyen" />
</form>

</body>
</html>



