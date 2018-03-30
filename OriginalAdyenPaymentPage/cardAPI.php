<h3>You want to pay $<?php echo $_POST["amount"]?> via credit card (direct API)</h3>

<div>
<br><br>
<form method="POST" action="handler.php">
    Card number: <input type="text" size="20" autocomplete="off" name="number" /></br>
    Name: <input type="text" size="20" autocomplete="off" name="holderName" /></br>
    Exp month: <input type="text" size="2" maxlength="2" autocomplete="off" name="expiryMonth" /></br>
    Exp year: <input type="text" size="4" maxlength="4" autocomplete="off" name="expiryYear" /></br>
    CVC: <input type="text" size="4" maxlength="4" autocomplete="off" name="cvc" /></br>

    <input type="hidden" name="ref" value="test" />
    <input type="hidden" name="amount" value=<?php echo $_POST["amount"]?> />
    <input type="hidden" value="generate-this-server-side" name="generationtime" />
    <input type="submit" value="Pay via Direct API" />
</form>
</div>

<br><br><br>