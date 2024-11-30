<?php

namespace App\Http\Classes;

class BiblePassageService
{
    public function getPassage($bibleApiId, $passageFrom, $passageTo, &$error)
    {
        $passageRange = "{$passageFrom}-{$passageTo}";

        $url = env('BIBLE_API_BASE_URL') . "bibles/{$bibleApiId}/passages/{$passageRange}";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO => base_path(env('CURLOPT_CAINFO_PATH')),
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'api-key: ' . env('BIBLE_API_KEY'),
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);

        curl_close($curl);

        if ($curlError) {
            $error = 'cURL Error: ' . $curlError;
            return null;
        }

        if ($httpCode !== 200) {
            $error = 'HTTP Error: ' . $httpCode;
            return null;
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'JSON decode error: ' . json_last_error_msg();
            return null;
        }

        if (empty($data)) {
            $error = 'Response data is empty.';
            return null;
        }

        return $data;
    }
}
