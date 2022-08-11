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

            if($json["img"] !== '') {
                $img_parts = explode(";base64,", $json["img"]);
                $img_type_aux = explode("image/", $img_parts[0]);
                $img_type = $img_type_aux[1];
                $img_base64 = base64_decode($img_parts[1]);
                $dirPath = _IMG_PATH . "/bobf/";
                $path = uniqid() . "." . $img_type;
                $filePath = $dirPath . "/" . $path;
                if(!is_dir($dirPath)) {
                    mkdir($dirPath, 0777, true);
                }
                $result = file_put_contents($filePath, $img_base64);

                if($result) {
                    $json["img"] = $path;
                }
            }


            return [_RESULT => $this->model->insBobF($json)];
        }

        public function selBobfDetail() {
            $json = getJson();
            // $rs = $this->model->selBobfDetail($json);
            // return ["result" => $rs];
            return $this->model->selBobfDetail($json);
        }

        public function delBobfDetail() {
            $json = getJson();

            try {
                $json = getJson();
                $this->model->beginTransaction();
                $result = $this->model->delBobfDetail($json);
                if($result === 1) {
                    //이미지 삭제
                    if($json["img_path"] !== ''){
                        unlink(_IMG_PATH . "/" . "bobf" . "/" .  $json["img_path"]);    
                    }
                    $this->model->commit();
                }
                else {
                    $this->model->rollback();    
                }
            } catch(Exception $e) {
                print "에러발생<br>";
                print $e . "<br>";
                $this->model->rollback();
            }

            return [_RESULT => $result];
        }

        public function updateBobfDetail() {
            $json = getJson();

            return [_RESULT => $this->model->updateBobfDetail($json)];
        }



        public function selRestList() {
            return $this->model->selRestList();
        }

        // public function uploadBobfImg() {
        //     // $urlPaths = getUrlPaths();
        //     // if(!isset($urlPaths[2]) || !isset($urlPaths[3])) {
        //     //     exit();
        //     // }
        //     // $ibobfImg = intval($urlPaths[2]);
        //     // $type = intval($urlPaths[3]);
        //     $json = getJson();
        //     $img_parts = explode(";base64,", $json["image"]);
        //     $img_type_aux = explode("image/", $img_parts[0]);
        //     $img_type = $img_type_aux[1];
        //     $img_base64 = base64_decode($img_parts[1]);
        //     $dirPath = _IMG_PATH . "/" . $ibobfImg . "/" . $type;
        //     $path = uniqid() . "." . $img_type;
        //     $filePath = $dirPath . "/" . $path;
        //     if(!is_dir($dirPath)) {
        //         mkdir($dirPath, 0777, true);
        //     }
        //     $result = file_put_contents($filePath, $img_base64);

            

        // }

    }