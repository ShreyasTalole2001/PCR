<?php


// $url = 'https://www.nseindia.com/api/option-chain-indices?symbol=NIFTY';

// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// $response = curl_exec($curl);

// if ($response !== false) {
//     echo $response;
// } else {
//     echo 'Error occurred while fetching the URL: ' . curl_error($curl);
// }

// curl_close($curl);

// -------------------------------------------------------------

$url = 'https://www.nseindia.com/api/option-chain-indices?symbol=NIFTY';

$cookies = array(
    'nsit' => 'n7KgYUOPQkH0kYSu9eICpsZV',
    'nseappid' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJhcGkubnNlIiwiYXVkIjoiYXBpLm5zZSIsImlhdCI6MTY5MDQzMjkwMCwiZXhwIjoxNjkwNDQwMTAwfQ.55JYtk1yRTJmksCQpDsmVg-FKLe0JzsbQOdPf6OtxFY',
    // Add more cookies if needed
);

$cookieString = '';
foreach ($cookies as $name => $value) {
    $cookieString .= $name . '=' . $value . '; ';
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Set the cookies as a single string
curl_setopt($curl, CURLOPT_COOKIE, $cookieString);

$response = curl_exec($curl);

if ($response !== false) {
    echo $response;
} else {
    echo 'Error occurred while fetching the URL: ' . curl_error($curl);
}

curl_close($curl);



?>