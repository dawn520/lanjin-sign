<?php
/**
 * 将字符串参数变为数组
 * @param $query
 * @return array
 */
function convertUrlQuery($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}

/**
 * 将参数变为字符串
 * @param $array_query
 * @return string
 */
function getUrlQuery($array_query)
{
    $tmp = array();
    foreach ($array_query as $k => $param) {
        $tmp[] = $k . '=' . $param;
    }
    $params = implode('&', $tmp);
    return $params;
}
