<?php
namespace application\controllers;

class MenuController extends Controller{
    public function menuListbyWeather(){
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 4) {
            exit();
        }
        $temp = intval($urlPaths[2]);
        $weather = $urlPaths[3];

        // 1:추위 2:더위 3:맑음 4:흐림 5:비 6:눈 7:바람 8:먼지
        $param = [];
        if($temp >= 25) {
            array_push($param, 2);
        } else if($temp <= 10) {
            array_push($param, 1);
        }
        
        switch($weather) {
            case "Thunderstorm":
            case "Drizzle":
            case "Rain":
                array_push($param, 4, 5);
                break;
            case "Snow":
                array_push($param, 4, 6);
                break;
            case "Mist":
            case "Smoke":
            case "Haze":
            case "Fog":
            case "Clouds":
                array_push($param, 4);
                break;
            case "Dust":
            case "Sand":
            case "Ash":
                array_push($param, 4, 8);
                break;
            case "Squall":
            case "Tornado":
                array_push($param, 4, 5, 7);
                break;
            case "Clear":
                array_push($param, 3);
                break;
        }
        $param = array_unique($param);
        return $this->model->menuListbyWeather($param);
    }
}