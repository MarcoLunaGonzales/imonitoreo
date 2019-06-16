<?php

$url = "http://localhost:8099/testcurl/test.php";

$file = "kia.jpg";
$mime = mime_content_type($file);
$info = pathinfo($file);
$name = $info['basename'];
$output = new CURLFile($file, $mime, $name);

$data = array(
    "file" => $output,
    "data" => '{"title":"Test"}'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);

echo $result;

if (curl_errno($ch)) {
   $result = curl_error($ch);
   echo $result;
}
curl_close ($ch);

?>
