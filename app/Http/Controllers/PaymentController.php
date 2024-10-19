<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('payment.form');
    }


    public function processPayment(Request $request)
        {
            // Validate form inputs (see previous step for validation)

            // Fiserv API endpoint
            $endpoint = 'https://test.ipg-online.com/ipgapi/services'; // Test environment endpoint

            // Retrieve form inputs
            $cardNumber = $request->input('card_number');
            $expMonth = $request->input('exp_month');
            $expYear = $request->input('exp_year');
            $cvv = $request->input('cvv');
            $amount = $request->input('amount');
            $storeId = env('FISERV_STORE_ID');;
            $sharedSecret = env('FISERV_SHARED_SECRET'); // Your shared secret key
            $currency = '951'; // Currency code for GBP

            // Additional transaction details for the hash
            $txndatetime = now()->format('Y:m:d-H:i:s'); // Transaction date and time
            $timezone = 'America/Dominica'; // Your timezone
            $responseSuccessURL = url('/payment/success'); // Your success URL
            $responseFailURL = url('/payment/failure'); // Your failure URL

             // Concatenate the required fields to generate the hash string
            $stringToHash = $amount . '|' . $currency . '|' . $responseFailURL . '|' . $responseSuccessURL . '|' . $storeId . '|' . $timezone . '|' . $txndatetime . '|sale';

            // Generate HMAC-SHA256 hash with the shared secret key
            $hash = base64_encode(hash_hmac('sha256', $stringToHash, $sharedSecret, true));

            // Build the XML request, including the hash
            $requestXml = <<<XML
            <soapenv:Envelope xmlns:soapenv="https://schemas.xmlsoap.org/soap/envelope/" xmlns:ipg="https://ipg-online.com/ipgapi/schemas/ipgapi" xmlns:v1="https://ipg-online.com/ipgapi/schemas/v1">
            <soapenv:Header/>
            <soapenv:Body>
                <ipg:IPGApiOrderRequest>
                    <v1:Transaction>
                        <v1:CreditCardTxType>
                        <v1:StoreId>$storeId</v1:StoreId>
                        <v1:Type>sale</v1:Type>
                        <v1:Hash>$hash</v1:Hash> <!-- Add the generated hash here -->
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

            // Set up cURL request with headers
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

            // Execute request
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                // Handle cURL error
                return back()->with('error', 'Payment failed: ' . curl_error($ch));
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode != 200) {
                return back()->with('error', 'Failed to process payment. Server responded with HTTP code ' . $httpCode);
            }

            // Parse the response or display it
            return view('payment.response', ['response' => htmlspecialchars($response)]);

        }



}
