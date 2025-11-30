<?php
if(isset($_GET['url'])) {
    $url = $_GET['url'];
    if(isFind($url, 'elements.envato.com')) {
        if(!file_exists('licenses')) {
            mkdir('licenses');
        }

        $id = getFileID($url);
        $cookie = 'cookies.txt';
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $csrf = getBetween($result, '"backendCsrfToken":"', '"');
        $csrf2 = getBetween($result, '"csrfToken":"', '"');

        $request = "https://elements.envato.com/elements-api/items/$id/download_and_license.json";
        $ch = curl_init($request);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        $payload = json_encode(array("licenseType" => 'project', 'projectName' => 'api', 'searchCorrelationId' => '6a55bdeb-e5dd-4f8e-8bfb-17c3f40b2db7'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', "X-Csrf-Token:$csrf", "X-Csrf-Token-2:$csrf2"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result);
        $download = $data->data->attributes->downloadUrl;
        $license = "https://elements.envato.com".$data->data->attributes->textDownloadUrl;
        $name = "$id.txt";
        downloadFile($license, $cookie, $name);
        rename($name, "licenses/$name");
        $license = "http://".$_SERVER['HTTP_HOST']."/licenses/$name";
        echo json_encode(array('status' => true, 'result' => array('download' => $download, 'license' => $license)));
    }
    else echo json_encode(array('status' => false, 'result' => array('error' => 'invalid envato url')));
}
else echo json_encode(array('status' => false, 'result' => array('error' => 'parameters error')));

function getFileID($url) {
    $lid = $url;
    if(isFind($url, '-')) {
        $lid = explode('-', $url);
        $lid = $lid[(sizeof($lid) - 1)];
    }
    return $lid;
}
function isFind($string, $find) {
    $pos = stripos($string, $find);
    if($pos === false) {
        return false;
    }
    return true;
}
function getBetween($string, $start, $end) {
    $r = explode($start, $string);
    if(isset($r[1])) {
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}
function downloadFile($url, $cookie, $name) {
    $fp = fopen($name, 'w+');
    $ch = curl_init(str_replace(" ", "%20", $url));
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
    curl_setopt($ch, CURLOPT_TIMEOUT, 50);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
