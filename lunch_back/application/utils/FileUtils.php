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

function getMaincate($search_word) {
    switch ($search_word) {
        case "짬뽕": case "파스타": case "스파게티": case "라멘": case "국수": case "우동": 
            $maincate = 1;
            break;
        case "삼겹살": case "갈비": case "스테이크": case "돈까스":
        case "탕수육": case "깐풍기":
            $maincate = 2;
            break;
        case "백반": case "짜글이":
            $maincate = 3;
            break;
        case "샐러드":
            $maincate = 5;
            break; 
        case "떡볶이":
            $maincate = 6;
            break;
        default:
            $maincate = 7;
            break;
    }

    if(strpos($search_word, "면") || strpos($search_word, "국수") || strpos($search_word, "우동") || strpos($search_word, "짜장") || strpos($search_word, "자장")) {
        $maincate = 1;
    } else if(strpos($search_word, "고기")) {
        $maincate = 2;
    } else if(strpos($search_word, "밥")) {
        $maincate = 3;
    } else if(strpos($search_word, "탕") || strpos($search_word, "찌개") || strpos($search_word, "찜")) {
        $maincate = 4;
    } else if(strpos($search_word, "샐러드")) {
        $maincate = 5;
    } else if(strpos($search_word, "튀김") || strpos($search_word, "전") || strpos($search_word, "빵") || strpos($search_word, "도넛")) {
        $maincate = 6;
    }

    return $maincate;
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
