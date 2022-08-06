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
            $param = [ "area1" => $urlPaths[2] ];
            return $this->model->AreaCate2List($param);
        }
    
        public function AreaCate3List() {
            $urlPaths = getUrlPaths();
            if(count($urlPaths) !== 4) {
                exit();
            }        
            $param = [ 
                "area1" => $urlPaths[2], 
                "area2" => $urlPaths[3],
                "area3" => $urlPaths[3]
            ];
            return $this->model->AreaCate3List($param);
        }

        // public function AreaCate4List() {
        //     $urlPaths = getUrlPaths();
        //     if(count($urlPaths) !== 4) {
        //         exit();
        //     }        
        //     $param = [ 
        //         "area1" => $urlPaths[2],
        //         "area3" => $urlPaths[3]
        //     ];
        //     return $this->model->AreaCate4List($param);
        // }



        //밥친구
        public function selBobfList() {
            return $this->model->selBobfList();

        }

        public function insBobF() {
            $json = getJson();
            print_r($json);
            return [_RESULT => $this->model->insBobF($json)];
        }

        public function selRestList() {
            return $this->model->selRestList();
        }

    }