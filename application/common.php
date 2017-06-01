<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function status($status, $type = '')
{
    $message = [];

    if (! $type) {
        $message = [
            '0' => '待审',
            '1' => '正常',
            '-1' => '已删除'
        ];
    } elseif ($type == 'pay') {
        $message = [
            '0' => '未付款',
            '1' => '已付款',
            '-1' => '已删除'
        ];
    } elseif ($type == 'user') {
        $message = [
            '0' => '未验证',
            '1' => '正常',
            '-1' => '冻结'
        ];
    }

    switch ($status) {
        case 0:
            return "<span class='size-MINI btn btn-warning radius'>".$message[0]."</span>";
            break;
        case 1:
            return "<span class='size-MINI btn btn-success radius'>".$message[1]."</span>";
            break;
        case -1:
            return "<span class='size-MINI btn btn-danger radius'>".$message[-1]."</span>";
            break;
    }
}

function doCurl($url, $method = 'get', $data = '')
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);

    if ($method == 'post') {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }

    $outPut = curl_exec($curl);
    curl_close($curl);
    return $outPut;
}

function getCityName($city_id)
{
    $city = model('City')->get($city_id);
    return $city->name;
}

function getCategoryName($category_id)
{
    $category =  model('Category')->get($category_id);
    return $category->name;
}

//function getType($type_id)
//{
//    $types = config('featured.featured_type');
//    return $types[$type_id];
//}

function page($obj)
{
    if (! $obj) {
        return '';
    }
    $params = request()->param();
    return $obj->appends($params)->render();
}


function isMainStore($is_main)
{
    switch ($is_main) {
        case 0:
            return "<span class='label radius'>否</span>";
            break;
        case 1:
            return "<span class='label label-success radius'>是</span>";
            break;
    }
}

function getFirstStoreName($bis_id)
{
    $data = [
        'id' => $bis_id,
    ];
    $store = model('Bis')->where($data)->find();
    return $store->name;
}

function getMapImage($address)
{
    return controller('api/Map')->getImageURL($address);
}

function getIP(){
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif(!empty($_SERVER["REMOTE_ADDR"])){
        $cip = $_SERVER["REMOTE_ADDR"];
    }
    else{
        $cip = "无法获取！";
    }
    return $cip;
}

function treeSign($level)
{
    $str = '';
    if ($level != 0) {
        $str = str_repeat('&nbsp;', $level * 6);
    } else {
        return '';
    }

    if ($level > 1) {
        $str .= str_repeat('&nbsp;', 6);
    }

    return $str.'|----';
}

/**
 * 获取部门名称
 *
 * @param $sector_id 可能是一个数字，也可能是已逗号隔开的2个数字（X,X）
 * @return string
 */
function getSectorName(\app\common\model\Personnel $personnel)
{
    $name = '';
    $sectors = $personnel->sectors;

    foreach ($sectors as $key => $sector) {
        if ($key != 0) {
            $name .= "---";
        }
        $name .= $sector->name;
    }

    return $name;
}

function back($status, $msg)
{
    return json(['status' => $status, 'msg' => $msg]);
}

