<html>
<body>
<div>
<?php

# Pass in the encodedString and setup the JSON
$enc = $_POST["encodedString"];
$data = array("encodedString" => $enc);
$data_string = json_encode($data);

$url = "http://localhost:8080";

// Create the curl command
$ch = curl_init(); 

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// Execute the curl command and capture the output
$output = curl_exec($ch);
curl_close($ch);

print $output
#$json = json_decode($output);
#echo "<pre>";
#print json_encode($json, JSON_PRETTY_PRINT);
#echo"</pre>";
?>

</div>
<br>
<a href="logDecoder.html"> Back to query page</a> 

</body>
</html>