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

        //검색 키워드로 크롤링 해오기
        public function menuCrawling() {
            header("Content-Type:text/html;charset=utf-8");
            putenv("LANG=ko_KR.UTF-8");
            setlocale(LC_ALL, 'ko_KR.utf8');

            $json = getJson();
            $search_word = $json["search_word"];
            // $search_word = '라면';
            // $command = escapeshellcmd('C:\Users\Administrator\AppData\Local\Programs\Python\Python310\python.exe C:\Apache24\Lunch_Back2\lunch_back\application\controllers\rest.py ');
            $output = shell_exec('C:\Users\Administrator\AppData\Local\Programs\Python\Python310\python.exe C:\Apache24\final_project_collabo\lunch_back\application\controllers\rest.py ' . $search_word);

            echo $output;

            return $output;
        }
    }