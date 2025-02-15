<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MpesaController extends Controller
{
    public function generateAccessToken()
    {
        $consumerKey = "GL9oeO6oBdig4s9BqWuRQ0S2zANG2G9cAIUxAP1njUxuUNY0";
        $consumerSecret = "4AIMQleIDSrCjuZiXJZHAahV5s41N0VgdI2D3a9QGDe6ALMn5IAvecxwM4Lun4KA";

        $credentials = base64_encode($consumerKey . ":" . $consumerSecret);

        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic $credentials",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Store the response
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Only for development

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            return response()->json(json_decode($response));
        } else {
            return response()->json(['error' => 'Failed to generate access token'], 500);
        }
    }

}


