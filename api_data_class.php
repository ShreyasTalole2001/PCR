<?php

// This class is use to store all data after calculation to send via API
class apiData {
    public $pcr, $expiryDate, $strike, $pe_sum_of_change_in_oi, $ce_sum_of_change_in_oi, $timeStamp;
    public $pe_change_in_oi_array, $ce_change_in_oi_array;
    
    // Constructor method
    public function __construct($expiryDate, $pcr, $strike, $timeStamp, $pe_sum_of_change_in_oi, $ce_sum_of_change_in_oi, $pe_change_in_oi_array, $ce_change_in_oi_array) {
        $this->expiryDate = $expiryDate;
        $this->pcr = $pcr;
        $this->strike = $strike;
        $this->timeStamp = $timeStamp;
        $this->pe_sum_of_change_in_oi = $pe_sum_of_change_in_oi;
        $this->ce_sum_of_change_in_oi = $ce_sum_of_change_in_oi;
        $this->pe_change_in_oi_array = $pe_change_in_oi_array;
        $this->ce_change_in_oi_array = $ce_change_in_oi_array;
    }

}

?>