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

        //검색 리스트 저장
        public function searchList() {
            $json = getJson();
            $search_word = "";
            switch($search_word) {
                case strpos($search_word, "국수"): case "짬뽕": case strpos($search_word, "면"): case strpos($search_word, "우동"):
                case "파스타": case "스파게티": case "라멘": case strpos($search_word, "짜장"): case strpos($search_word, "자장"):
                    $maincate = 1;
                    break;
                case "삼겹살": case "갈비": case "스테이크": case strpos($search_word, "고기"): case "돈까스": 
                case "탕수육": case "깐풍기":
                    $maincate = 2;
                    break;
                case strpos($search_word, "밥"): case "백반": case "짜글이":
                    $maincate = 3;
                    break;
                case strpos($search_word, "탕"): case strpos($search_word, "찌개"): case strpos($search_word, "찜"):
                    $maincate = 4;
                    break;
                case strpos($search_word, "샐러드"):
                    $maincate = 5;
                    break;
                case strpos($search_word, "튀김"): case strpos($search_word, "전"): case strpos($search_word, "빵"):
                case strpos($search_word, "도넛"): case "떡볶이":
                    $maincate = 6;
                    break;
                default:
                    $maincate = 7;
                    break;
                
            }

            foreach($json as $item) {
                // $cateId = $this->model->insSearchRest($item);
                $param = menuSubstring($item["menu"]);
                echo $param;
                $cate2 = [ "maincate" => $maincate ];
                echo $cate2;
                // $this->model->insMenuCate2($cate2);
            }
            // $this->model->getMenuCD($json);
            return $json;
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