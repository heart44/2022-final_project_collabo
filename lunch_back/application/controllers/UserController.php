<?php
    namespace application\controllers;

use application\libs\Application;

    class UserController extends Controller{
        public function signup(){
            $json = getJson();
            // 비밀번호 암호화
            $json["pw"] = password_hash($json["pw"], PASSWORD_BCRYPT);
            $result = $this->model->signup($json);
            if($result){
                return [_RESULT => $result];
            }
            return [_RESULT => 0];
        }

        public function signin() {
            $json = getJson();
            $pw = $json['pw'];
            $dbUser = $this->model->signin($json);
            // if(!$dbUser || !password_verify($pw, $dbUser->pw)) { 비밀번호암호화하고나면이걸로
            if(!$dbUser || !password_verify($pw, $dbUser->pw)) {
                return [_RESULT => 0];
            }
            $dbUser->pw = null;
            $dbUser->regdt = null;
            $dbUser->moddt = null;
            // 메모리 차지하지 않게
            $this->flash(_LOGINUSER, $dbUser);
            return [_RESULT => $dbUser];
        }

        public function signout() {
            $this->flash(_LOGINUSER);
            return [_RESULT => 1];
        }

        public function doubleCheck() {
            $json = getJson();
            $check = $this->model->doubleCheckUser($json);
            if(!empty($check)) {
                return [_RESULT => 1];
            }
            return [_RESULT => 0];
        }

        //비번 찾기에 필요한 이메일 체크
        public function checkEmail() {
            $urlPaths = getUrlPaths();
            if(!isset($urlPaths[2])) {
                exit();
            }
            $param = [ "email" => $urlPaths[2] ];
            $rs = $this->model->checkEmail($param);

            return [ _RESULT => $rs ];
        }

        //재설정된 비번 insert
        public function updPassword() {
            $json = getJson();
            $json["pw"] = password_hash($json["pw"], PASSWORD_BCRYPT);
            $rs = $this->model->updPassword($json);

            return [ _RESULT => $rs ];
        }

        public function profile() {
            switch(getMethod()) {
                case _DELETE:
                    $urlPaths = getUrlPaths();
                    if(count($urlPaths) !== 4) {
                        exit();
                    }
                    $path = _IMG_PATH . "/profile/{$urlPaths[2]}/{$urlPaths[3]}";
                    unlink($path);
                    $param = [
                        "iuser" => $urlPaths[2],
                        "profileimg" => null
                    ];
                    $rs = $this->model->updateUser($param);
                    if($rs) {
                        $_SESSION[_LOGINUSER]->profileimg = null;
                        return [_RESULT => 1 ];
                    }
                    return [_RESULT => 0];

                case _POST:
                    $json = getJson();
                    // 이미지 폴더에 업로드
                    if($json["profileimg"] !== ''){
                        $loginUser = getLoginUser();
                        if($loginUser->profileimg){
                            $oldimg = _IMG_PATH . "/profile/{$json["iuser"]}/{$loginUser->profileimg}";
                            unlink($oldimg);
                        }
                        $image_parts  = explode(";base64", $json["profileimg"]);
                        $imge_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $imge_type_aux[1];
                        $image_base64 = base64_decode($image_parts[1]);
                        $dirPath = _IMG_PATH . "/profile/" . $json["iuser"];
                        $path = uniqid() . "." . $image_type;
                        $filePath = $dirPath . "/" . $path;
                        if(!is_dir($dirPath)) {
                            mkdir($dirPath, 0777, true);
                        }
                        $result = file_put_contents($filePath, $image_base64);
                        if($result) {
                            $json["profileimg"] = $path;
                        }
                    }
                    // 프로필 수정
                    $json["pw"] = password_hash($json["pw"], PASSWORD_BCRYPT);
                    $rs = $this->model->updateUser($json);
                    if($rs){
                        foreach($json as $key => $val){
                            $_SESSION[_LOGINUSER]->$key = $val;
                        }
                        return [_RESULT => $json];
                    }
                    return [_RESULT => 0];
                }
        }

        public function selRest() {
            $json = getJson();
            $param = explode(' ', $json['search_word']);
            return [_RESULT => $this->model->selRest($param)];
        }

        public function insDiary() {
            $json = getJson();
            if($json['path'] !== '') {
                $image_parts  = explode(";base64", $json["path"]);
                $imge_type_aux = explode("image/", $image_parts[0]);
                $image_type = $imge_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $dirPath = _IMG_PATH . "/diary/" . $json["iuser"];
                $path = uniqid() . "." . $image_type;
                $filePath = $dirPath . "/" . $path;
                if(!is_dir($dirPath)) {
                    mkdir($dirPath, 0777, true);
                }
                $result = file_put_contents($filePath, $image_base64);
                if($result) {
                    $json["path"] = $path;
                }
            }
            $rs = $this->model->insDiary($json);
            return [_RESULT => $rs];
        }

        public function updateDiary() {
            $json = getJson();
            // DB에 있는 path를 한 번 셀렉 해와서 같으면 밑에 if문 실행 안 하는 걸로 해야할 것 같은데...
            $param = [
                "iuser" => $json["iuser"],
                "idiary" => $json["idiary"]
            ];
            $dbPath = $this->model->getDiary($param);
            if($json['src'] !== $dbPath[0]->path && $json['src'] !== '') {
                $path = _IMG_PATH . "/diary/" . $json["iuser"] . "/" . $json["src"];
                unlink($path);
            }
            if($json['path'] !== '') {
                $image_parts  = explode(";base64", $json["path"]);
                $imge_type_aux = explode("image/", $image_parts[0]);
                $image_type = $imge_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $dirPath = _IMG_PATH . "/diary/" . $json["iuser"];
                $path = uniqid() . "." . $image_type;
                $filePath = $dirPath . "/" . $path;
                if(!is_dir($dirPath)) {
                    mkdir($dirPath, 0777, true);
                }
                $result = file_put_contents($filePath, $image_base64);
                if($result) {
                    $json["path"] = $path;
                }
            } else {
                $json["path"] = $json['src'];
            }
            $rs = $this->model->updateDiary($json);
            return [_RESULT => $rs];
        }

        public function getDiary() {
            $urlPaths = getUrlPaths();
            if(count($urlPaths) < 3) {
                exit();
            }
            $param = [
                "iuser" => $urlPaths[2],
            ];
            if(isset($urlPaths[3])) {
                $param["idiary"] = $urlPaths[3];
            }
            return $this->model->getDiary($param);
        }

        public function deleteDiary() {
            switch(getMethod()) {
                case _DELETE:
                    $urlPaths = getUrlPaths();
                    if(count($urlPaths) !== 5) {
                        exit();
                    }
                    $param = [
                        "idiary" => $urlPaths[2]
                    ];
                    $rs = $this->model->deleteDiary($param);
                    if($rs) {
                        $path = _IMG_PATH . "/diary/" . $urlPaths[3] . "/" . $urlPaths[4];
                        unlink($path);
                        return [_RESULT => $rs];
                    }
            }
        }
    }