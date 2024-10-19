<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $cardNumber = $_POST['cardNumber'];
    $expMonth = $_POST['expMonth'];
    $expYear = $_POST['expYear'];
    $amount = $_POST['amount'];
    $currency = $_POST['currency'];
    $orderId = $_POST['orderId'];

    // Your store ID, user ID, and password for authentication
    $storeID = "YOUR_STORE_ID";
    $userID = "YOUR_USER_ID";
    $password = "YOUR_PASSWORD";
    $clientCertPath = "path/to/client-cert.p12"; // Path to your client certificate (p12 file)
    $certPassword = "YOUR_CERT_PASSWORD"; // Password for the p12 file

    // Create the XML body for the sale transaction
    $xmlBody = <<<XML
<ipgapi:IPGApiOrderRequest xmlns:v1="http://ipg-online.com/ipgapi/schemas/v1" xmlns:ipgapi="http://ipg-online.com/ipgapi/schemas/ipgapi">
    <v1:Transaction>
        <v1:CreditCardTxType>
            <v1:Type>sale</v1:Type>
        </v1:CreditCardTxType>
        <v1:CreditCardData>
            <v1:CardNumber>{$cardNumber}</v1:CardNumber>
            <v1:ExpMonth>{$expMonth}</v1:ExpMonth>
            <v1:ExpYear>{$expYear}</v1:ExpYear>
        </v1:CreditCardData>
        <v1:Payment>
            <v1:ChargeTotal>{$amount}</v1:ChargeTotal>
            <v1:Currency>{$currency}</v1:Currency>
        </v1:Payment>
        <v1:TransactionDetails>
            <v1:OrderId>{$orderId}</v1:OrderId>
        </v1:TransactionDetails>
    </v1:Transaction>
</ipgapi:IPGApiOrderRequest>
XML;

    // API URL for the test environment
    $apiUrl = "https://test.ipg-online.com/ipgapi/services";

    // Initialize cURL
    $ch = curl_init($apiUrl);

    // cURL options
    curl_setopt($ch, CURLOPT_SSLCERT, $clientCertPath); // Client certificate
    curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $certPassword); // Certificate password
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Verify the peer's SSL certificate
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // Verify the host name
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
    curl_setopt($ch, CURLOPT_POST, true); // Send a POST request
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Set the XML as the POST body
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: text/xml", // Set the content type to XML
        "Authorization: Basic " . base64_encode("WS$storeID._.$userID:$password") // Basic auth header
    ]);

    // Send the request and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        // Parse and display the response
        echo "<h2>Response:</h2>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
    }

    // Close the cURL session
    curl_close($ch);
} else {
    // Display the form
?>

<h2>Payment Form</h2>
<form action="" method="POST">
    <label for="cardNumber">Card Number:</label><br>
    <input type="text" id="cardNumber" name="cardNumber" required><br><br>

    <label for="expMonth">Expiration Month (MM):</label><br>
    <input type="text" id="expMonth" name="expMonth" required><br><br>

    <label for="expYear">Expiration Year (YY):</label><br>
    <input type="text" id="expYear" name="expYear" required><br><br>

    <label for="amount">Amount:</label><br>
    <input type="text" id="amount" name="amount" required><br><br>

    <label for="currency">Currency (e.g. 978 for EUR):</label><br>
    <input type="text" id="currency" name="currency" value="978" required><br><br>

    <label for="orderId">Order ID:</label><br>
    <input type="text" id="orderId" name="orderId" required><br><br>

    <input type="submit" value="Submit Payment">
</form>

<?php
}
?>

</body>
</html>
