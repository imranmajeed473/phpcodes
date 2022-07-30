<!-- 
How to download large files in PHP using cURL

http://www.sulata.com.pk/php-help/how-to-download-large-files-in-php-using-curl/#:~:text=php%20%24url%20%3D%20'http%3A%2F%2F,)%3B%20fclose(%24fp)%3B%20%3F%3E 
-->
<?php

    $url  = 'http://www.example.com/a-large-file.zip';
    $path = $_SERVER['DOCUMENT_ROOT'] . '/downloads/a-large-file.zip';

    $fp = fopen($path, 'w');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FILE, $fp);

    $data = curl_exec($ch);

    curl_close($ch);
    fclose($fp);
?>