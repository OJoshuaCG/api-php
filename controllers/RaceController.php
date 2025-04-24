<?php
require_once DIR . '/models/Race.php';
require_once DIR . '/utils/Response.php';

class RaceController {
    public function getYears(){
        $race_obj = new Race();
        $years = $race_obj->getRaceYears();
        echo json_encode($years);
    }
}