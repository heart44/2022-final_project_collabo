<?php
    namespace application\controllers;
    use Exception;

    class SearchController extends Controller {
        //검색 카테고리
        public function searchCategoryList() {
            return $this->model->getSearchCategoryList();
        }

        //검색 로그 저장
        public function searchLog() {
            $json = getJson();
            $rs = $this->model->insSearchLog($json);
            
            return $rs;
        }

        //검색 키워드로 크롤링 해오기 (혹시 모르니까 나중에 지울게요,,,,,,,,)
        // public function menuCrawling() {
        //     // header("Content-Type:text/html;charset=utf-8");
        //     // putenv("LANG=ko_KR.UTF-8");
        //     // setlocale(LC_ALL, 'ko_KR.utf8');
            
        //     $json = getJson();
        //     $search_word = $json["search_word"];
        //     $url = "https://map.naver.com/v5/api/search?caller=pcweb&query=". $search_word ."&type=all&searchCoord=128.591585;35.8666565&page=1&displayCount=20&isPlaceRecommendationReplace=true&lang=ko";
        //     // $search_word = '라면';
        //     // $command = escapeshellcmd('C:\Users\Administrator\AppData\Local\Programs\Python\Python310\python.exe C:\Apache24\Lunch_Back2\lunch_back\application\controllers\rest.py ');
        //     // $output = shell_exec('C:\Users\Administrator\AppData\Local\Programs\Python\Python310\python.exe C:\Apache24\final_project_collabo\lunch_back\application\controllers\rest.py ' . $search_word);
        //     // $output = getFromUrl($url);

        //     $curl = curl_init();
        //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($curl, CURLOPT_URL, $url);
        //     $rs = curl_exec($curl);
        //     curl_close($curl);

        //     $data = file_get_contents($url); 

        //     // $output = json_decode($rs);
        //     echo $data["result"]["place"]["list"];
        //     echo $data;
            
        //     return $rs;
        // }
    }