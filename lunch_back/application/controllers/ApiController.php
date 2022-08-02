<?php
namespace application\controllers;

use Exception;

class ApiController extends Controller {
    public function categoryList() {
        return $this->model->getCategoryList();
    }

    public function productInsert() {
        $json = getJson();
        print_r($json);
        return [_RESULT => $this->model->productInsert($json)];
    }
    public function productList(){
        $param = [];

        if(isset($_GET["cate3"])) {
            $cate3 = intval($_GET["cate3"]);
            if($cate3 > 0) {
                $param["cate3"] = $cate3;
            }
        } else {
            if(isset($_GET["cate1"])) {
                $param["cate1"] = $_GET["cate1"];
            }
            if(isset($_GET["cate2"])) {
                $param["cate2"] = $_GET["cate2"];
            }
        }                 
        return $this->model->productList($param);         
    }
    public function productList2(){
        return $this->model->productList2();
    }
    public function productDetail(){
        $urlPaths = getUrlPaths();
        if(!isset($urlPaths[2])){
            exit();
        }
        $param = [
            'product_id' => intval($urlPaths[2])
        ];
        return $this->model->productDetail($param);
    }
   

    public function cate1List(){
        return $this->model->cate1List();
    }
    public function cate2List(){
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 3) {
            exit();
        }
        $param = ["cate1" => $urlPaths[2]];
        return $this->model->cate2List($param);
    }
    public function cate3List(){
        $urlPaths = getUrlPaths();
        if(count($urlPaths) !== 4) {
            exit();
        }
        $param = [
            "cate1" => $urlPaths[2],
            "cate2" => $urlPaths[3],
        ];
        return $this->model->cate3List($param);
    }


}