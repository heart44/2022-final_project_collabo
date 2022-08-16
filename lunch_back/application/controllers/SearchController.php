<?php
    namespace application\controllers;
    use Exception;

    class SearchController extends Controller {
        //검색 로그 저장
        public function searchLog() {
            $json = getJson();
            $rs = $this->model->insSearchLog($json);
            
            return $rs;
        }

        //검색 로그 가져오기
        public function getMostSearchLog() {
            $rs = $this->model->getMostSearchLog();
            return [ "rs" => $rs->search_word ];
        }

        //검색 리스트 저장
        public function searchList() {  //완전 하드코딩....슬프다.....
            $json = getJson();
            $search_word = end($json);                  //검색한 메뉴

            array_pop($json);                           //마지막 메뉴 이름 삭제
            foreach($json as $item) {                   //음식점 반복문
                $irest = $this->model->insSearchRest($item);   //레스토랑 insert (pk)
                $paramIrest = [ "irest" => $irest ]; 
                $irest222 = $this->model->selMenuList($paramIrest);
                $paramMCD = [ "search_word" => $search_word ];
                $imcd = $this->model->getMenuCD($paramMCD);     //메뉴 코드 있는지 확인
                if(!$imcd) {   //없으면
                    $imcd11 = $this->model->insMenuCD($paramMCD);   //일단 insert
                    $imcd = $imcd11; //새로운 키로 바꿈
                    $params = [ "imcd" => $imcd, "irest" => $irest ];
                } else { //있으면 셀렉해온 키 넣음
                    $params = [ "imcd" => $imcd, "irest" => $irest ];
                }
                if(empty($irest222)) {
                    if($item["menu"]) { //메뉴가 있으면 아래 코드 실행
                        $menuList = menuSubstring($item["menu"]);   //메뉴 자르는 함수
                        if(count($menuList)<=20) {
                            foreach($menuList as $list) {   //자른 메뉴 반복해서 DB에 넣음
                                $params["name"] = $list["name"];
                                $params["price"] = "";
                                $rs = $this->model->insSearchMenu($params);
                            }
                        } else {
                            $param["name"] = "";
                            $param["price"] = "";
                            $rs = $this->model->insSearchMenu($params);
                        }
                    } else { //없으면 걍 null값 넣음^^
                        $param["name"] = "";
                        $param["price"] = "";
                        $rs = $this->model->insSearchMenu($params);
                    }
                }
            }

            return ["rs" => $rs];
        }

        public function restList() {
            $urlPaths = getUrlPaths();
            if(!isset($urlPaths[2]) || !isset($urlPaths[3]) || !isset($urlPaths[4])) {
                exit();
            }
            $param = [ 
                "search_word" => $urlPaths[2], 
                "lon_x" => $urlPaths[3], 
                "lat_y" => $urlPaths[4], 
                "iuser" => $urlPaths[5]
            ];
            // echo $param;
            $rs = $this->model->getRestList($param);
            // echo $rs;
            return ["rs" => $rs];
        }

        public function menuList() {
            $rs = $this->model->getMenuList();
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