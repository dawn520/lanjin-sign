<?php

use NoahBuscher\Macaw\Macaw;


require __DIR__ . '/vendor/autoload.php';

if (is_file('./.env')) {
    $env = parse_ini_file('./.env', true);    //解析env文件,name = PHP_KEY
    foreach ($env as $key => $val) {
        $name = strtoupper($key);
        if (is_array($val)) {
            foreach ($val as $k => $v) {    //如果是二维数组 item = PHP_KEY_KEY
                $item = $name . '_' . strtoupper($k);
                putenv("$item=$v");
            }
        } else {
            putenv("$name=$val");
        }
    }
}
try {
    Macaw::post('/sign', 'App\Controller\IndexController@getSign');
    Macaw::post('/check', 'App\Controller\IndexController@check');
    Macaw::dispatch();
} catch (Exception $exception) {
    header("Content-type:application/json");
    echo [
        'code'  => $exception->getCode(),
        'msg'   => $exception->getMessage(),
        'file'  => $exception->getFile(),
        'line'  => $exception->getLine(),
        'trace' => $exception->getTrace()
    ];
}



