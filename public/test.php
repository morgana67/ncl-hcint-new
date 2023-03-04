<?php
function HmacSHA1Encrypt(String $encryptText,String $encryptKey ){
    $hash_hmac = hash_hmac("sha1",$encryptText,$encryptKey,true);
    $signature = base64_encode($hash_hmac);
    return $signature;
}
try {
//    $method = "POST";
//    $uri = "/assets/psc/schedule/locations";
    $uri = "/assets/facilities/psc/E2M";
    $method = "GET";
    $date = new DateTime('now', new DateTimeZone('UTC'));
    $dateFormat = $date->format('D, j M Y H:i:s O');
    $key = "{$method}\n\ntext/xml\n\nx-newcentury-date:{$dateFormat}\n{$uri}";
    $secret = "Q14zeK0turtrszgisqtsgsgsgsc7WzdnlkYZR==";
    $digestCode = HmacSHA1Encrypt($key, $secret);
    $xmlRequest = "<request version=\"1.0\">
                                    <radius>25</radius>
                                    <coordinates>
                                        <latitude>45.3018169</latitude>
                                        <longitude>-122.7751561</longitude>
                                    </coordinates>
                                    <scheduling>YES</scheduling>
                                    <activity_id>23</activity_id>
                                </request>";
    $url = "https://services-qa.questdiagnostics.com{$uri}";
    $headers = [
        "Authorization: newcentury 1Y58HJ80-4859-43ZF-CEBB-A1763FG37D93:{$digestCode}",
        "Date: {$dateFormat}",
        "x-newcentury-date: {$dateFormat}",
        "Content-Type: text/xml",
    ];
    $ch = curl_init($url);
//    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, "{$xmlRequest}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    if(empty(json_decode($response, TRUE))) {
        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response, TRUE);
        echo '<pre>';
        print_r($response['location']);
        echo '</pre>';
    } else {
        echo '<pre>';
        print_r("Failled to call.");
        echo '</pre>';
    }


    curl_close($ch);


} catch (\Exception $e) {
    echo '<pre>';
    print_r($e);
    echo '</pre>';
}
