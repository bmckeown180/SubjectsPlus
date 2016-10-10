<?php

$book_cover_from_open_library = function ($isbn) {

    $url = "https://openlibrary.org/api/books?bibkeys=ISBN:" . $isbn . "&format=json";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, htmlspecialchars_decode($url));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $raw = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($raw,true);
    $result = "";

    if (!empty($response)) {
        foreach ($response as $data) {
            if (array_key_exists('thumbnail_url', $data)) {
                $result = $data['thumbnail_url'];
            }
        }
    }

    if (empty($result)){
        $prefix = explode('subjects', dirname(__FILE__));
        $url = $prefix[0]."assets/images/blank-cover.png";
        $result = $url;
    }

    echo $result;
};

$book_cover_from_open_library(htmlspecialchars($_GET['isbn']));