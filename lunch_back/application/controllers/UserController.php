<?php
    namespace application\controllers;

    class UserController extends Controller{
        public function signup(){
            $json = getJson();
            // 비밀번호 암호화
            // $json["pw"] = password_hash($json["pw"], PASSWORD_BCRYPT);
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
            if(!$dbUser || $pw !== $dbUser->pw) {
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
    }