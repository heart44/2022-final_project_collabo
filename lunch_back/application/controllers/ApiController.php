<?php
    namespace application\controllers;
    use Exception;

    class ApiController extends Controller {
        //지역 카테고리
        public function selArea() {
            return $this->model->selArea();
        }
        
        public function AreaCate1List() {
            return $this->model->AreaCate1List();
        }
    
        public function AreaCate2List() {
            $urlPaths = getUrlPaths();
            if(count($urlPaths) !== 3) {
                exit();
            }        
            $param = [ "cate1" => $urlPaths[2] ];
            return $this->model->AreaCate2List($param);
        }
    
        public function AreaCate3List() {
            $urlPaths = getUrlPaths();
            if(count($urlPaths) !== 4) {
                exit();
            }        
            $param = [ 
                "cate1" => $urlPaths[2], 
                "cate2" => $urlPaths[3]
            ];
            return $this->model->AreaCate3List($param);
        }




        //
        public function selRestaurant() {
            return $this->model->selRestaurant();
        }

        public function insBobF() {
            $json = getJson();
            print_r($json);
            return [_RESULT => $this->model->insBobF($json)];
        }
        
        //검색 카테고리
        public function searchCategoryList() {
            return $this->model->getSearchCategoryList();
        }
    }