<?php
function menuSubstring($menuList) {
    $menuList = explode("|", $menuList);
    $menu_price = [];

    foreach($menuList as $item) {
        $item = trim($item);
        $priceEnd = substr($item, -4);
        if(preg_match('/\d+/', $item, $match)) {
            $priceStart = $match[0];
        }
        $list = [
            "name" => preg_split('/\d/', $item, 2)[0],
            "price" => $priceStart . $priceEnd
        ];
        array_push($menu_price, $list);
    }
    return $menu_price;
}

function getRandomFileNm($fileName) {
    return gen_uuid_v4() . "." . getExt($fileName);
}

function getExt($fileName) {
    return pathinfo($fileName, PATHINFO_EXTENSION);
}

function gen_uuid_v4() { 
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x'
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0x0fff) | 0x4000
        , mt_rand(0, 0x3fff) | 0x8000
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff)
        , mt_rand(0, 0xffff) 
    ); 
}
