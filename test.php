<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Capture form inputs
    $cardNumber = $_POST['card_number'];
    $expMonth = $_POST['exp_month'];
    $expYear = $_POST['exp_year'];
    $cvv = $_POST['cvv'];
    $amount = $_POST['amount'];

    // Fiserv credentials and transaction details
    $storeId = 'your_store_id'; // Replace with your actual Fiserv store ID
    $sharedSecret = 'your_shared_secret'; // Replace with your actual shared secret key
    $currency = '951'; // ISO 4217 currency code for Eastern Caribbean Dollar (XCD)
    $endpoint = 'https://test.ipg-online.com/ipgapi/services'; // Test environment endpoint

    // Generate current date and time in Fiserv's required format
    $txndatetime = date('Y:m:d-H:i:s');
    $timezone = 'America/Dominica'; // Set your appropriate timezone

    // Response URLs (you can modify these as per your setup)
    $responseSuccessURL = 'http://localhost/success.php';
    $responseFailURL = 'http://localhost/failure.php';

    // Concatenate values for hashing
    $stringToHash = $amount . '|' . $currency . '|' . $responseFailURL . '|' . $responseSuccessURL . '|' . $storeId . '|' . $timezone . '|' . $txndatetime . '|sale';

    // Generate HMAC-SHA256 hash using the shared secret key
    $hash = base64_encode(hash_hmac('sha256', $stringToHash, $sharedSecret, true));

    // Construct the XML request body
    $requestXml = <<<XML
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ipg="http://ipg-online.com/ipgapi/schemas/ipgapi" xmlns:v1="http://ipg-online.com/ipgapi/schemas/v1">
       <soapenv:Header/>
       <soapenv:Body>
          <ipg:IPGApiOrderRequest>
             <v1:Transaction>
                <v1:CreditCardTxType>
                   <v1:StoreId>$storeId</v1:StoreId>
                   <v1:Type>sale</v1:Type>
                   <v1:Hash>$hash</v1:Hash>
                </v1:CreditCardTxType>
                <v1:CreditCardData>
                   <v1:CardNumber>$cardNumber</v1:CardNumber>
                   <v1:ExpMonth>$expMonth</v1:ExpMonth>
                   <v1:ExpYear>$expYear</v1:ExpYear>
                   <v1:CardCodeValue>$cvv</v1:CardCodeValue>
                </v1:CreditCardData>
                <v1:Payment>
                   <v1:ChargeTotal>$amount</v1:ChargeTotal>
                   <v1:Currency>$currency</v1:Currency>
                </v1:Payment>
             </v1:Transaction>
          </ipg:IPGApiOrderRequest>
       </soapenv:Body>
    </soapenv:Envelope>
    XML;

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: text/xml',
        'SOAPAction: ""',
        'Content-Length: ' . strlen($requestXml)
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);

    // Force TLS 1.2
    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);

    // Execute the request and capture the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Payment failed: ' . curl_error($ch);
    } else {
        // Display the raw XML response (for debugging purposes)
        echo '<pre>' . htmlspecialchars($response) . '</pre>';
    }

    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiserv Payment Form</title>
</head>
<body>

<h1>Payment Form</h1>

<form method="POST" action="">
    <!-- Card Details -->
    <label for="card_number">Card Number:</label>
    <input type="text" id="card_number" name="card_number" required><br>

    <label for="exp_month">Expiry Month (MM):</label>
    <input type="text" id="exp_month" name="exp_month" required><br>

    <label for="exp_year">Expiry Year (YY):</label>
    <input type="text" id="exp_year" name="exp_year" required><br>

    <label for="cvv">CVV:</label>
    <input type="text" id="cvv" name="cvv" required><br>

    <!-- Payment Details -->
    <label for="amount">Amount (XCD):</label>
    <input type="text" id="amount" name="amount" required><br>

    <button type="submit">Pay Now</button>
</form>

</body>
</html>
