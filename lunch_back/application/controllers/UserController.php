<?php
    namespace application\controllers;

    class UserController extends Controller{
        public function signup(){
            $json = getJson();
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
    }