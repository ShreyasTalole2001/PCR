<?php

include './api_data_class.php';

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
    header('Content-Type: application/json');
    // echo $response;
    $data = json_decode($response, true);
    PCR_calculations($data);
} else {
    echo 'Error occurred while fetching the URL: ' . curl_error($curl);
}

curl_close($curl);



// Function to do all PCR Calculations
function PCR_calculations($data) {
    $spotPrice = $data['records']['underlyingValue'];
    $strikePrice = 0;
    $strikePricesArray = $data['records']['strikePrices'];
    $indexOfStrikePrice = 0;

    /* find the spot price by comparing strike price also find the index of spot price */
    for ($i = 0; $i < count($strikePricesArray); $i++) {
        if ($spotPrice < $strikePricesArray[$i]) {
            $lower_strikePrice = $strikePricesArray[$i - 1];

            if ($spotPrice - $lower_strikePrice < 25) {
                $indexOfStrikePrice = $i - 1;
            } else {
                $indexOfStrikePrice = $i;
            }
            $strikePrice = $strikePricesArray[$indexOfStrikePrice];
            break;
        }
    }


    $index_ATM = 0;
    /* This searches the Strike price in Filtered Array */
    for ($i = 0; $i < count($data['filtered']['data']); $i++) {
        if ($data['filtered']['data'][$i]['strikePrice'] === $strikePrice) {
            $index_ATM = $i;
            break;
        }
    }

    
    /* This is according to the formula of Website */
    $activeStrikeIndex = $index_ATM;
    $start = $activeStrikeIndex - 9;
    $end = $activeStrikeIndex + 7;
    $PE_SumOfChangeInOpenInterest = 0;
    $CE_SumOfChangeInOpenInterest = 0;
    $pe_change_in_oi_array = array();
    $ce_change_in_oi_array = array();

    for ($i = $start; $i <= $end; $i++) {
        // Calculates the sum of change in OI of pe and ce
        $PE_SumOfChangeInOpenInterest += $data['filtered']['data'][$i]['PE']['changeinOpenInterest'];
        $CE_SumOfChangeInOpenInterest += $data['filtered']['data'][$i]['CE']['changeinOpenInterest'];

        // Stores the strike prices, i.e data used for calculations
        $pe_change_in_oi_array[$data['filtered']['data'][$i]['strikePrice']] = $data['filtered']['data'][$i]['PE']['changeinOpenInterest'];
        $ce_change_in_oi_array[$data['filtered']['data'][$i]['strikePrice']] = $data['filtered']['data'][$i]['CE']['changeinOpenInterest'];
    }

    $expiryDate = $data['filtered']['data'][$index_ATM]['expiryDate'];
    $pe_sum_of_change_in_oe = $PE_SumOfChangeInOpenInterest;
    $ce_sum_of_change_in_oe = $CE_SumOfChangeInOpenInterest;
    $activeStrike = $data['filtered']['data'][$index_ATM]['strikePrice'];
    $activeStrikePCR = $PE_SumOfChangeInOpenInterest / $CE_SumOfChangeInOpenInterest;
    $activeStrikePCR = number_format($activeStrikePCR, 2);


    date_default_timezone_set('Asia/Kolkata');
    $timestamp = time();
    $dateString = date("d-m-Y H:i:s", $timestamp);

    // Create an object of data that we want to send through api
    $ObjectOfData = new apiData($expiryDate, $activeStrikePCR, $activeStrike, $dateString, $pe_sum_of_change_in_oe, $ce_sum_of_change_in_oe, $pe_change_in_oi_array, $ce_change_in_oi_array);

    // Convert the object into json and send to client
    $myJSON = json_encode($ObjectOfData);
    echo $myJSON;
    
    appendLogDataToApiLogFile($ObjectOfData);
    

}



// APPEND DATA INTO FILE ($data is an object, convert it into string before append)
function appendLogDataToApiLogFile($data){
    $data = json_encode($data);
    $myfile = fopen("apiLog.txt", "a");
    fwrite($myfile, $data);
}





