<?php


namespace App\Controller;


use App\Lib\Aes;

class IndexController
{

    public function getSign()
    {
        $merKey    = getenv('HASH_KEY');
        $merIv     = getenv('HASH_IV');
        $aes       = new Aes($merKey, $merIv);
        $tradeInfo = file_get_contents("php://input");
        $tradeInfo = json_decode($tradeInfo, true);
        //交易資料經 AES 加密後取得 TradeInfo
        $tradeInfo = $aes->encrypt($tradeInfo);
        $str       = 'HashKey=' . $merKey . '&' . $tradeInfo . '&HashIV=' . $merIv;
        $str       = strtoupper(hash("sha256", $str));
        header("Content-type:application/json");
        echo json_encode(['code' => 200, 'msg' => 'success', 'data' => ['trade_info' => $tradeInfo, 'trade_sha' => $str]]);
        return;
    }

    public function check()
    {
        $merKey    = getenv('HASH_KEY');
        $merIv     = getenv('HASH_IV');
        $aes       = new Aes($merKey, $merIv);
        $data      = file_get_contents("php://input");
        $data      = json_decode($data, true);
        $tradeInfo = $data['trade_info'];
//        $tradeSha  = $data['trade_sha'];
        $tradeArrS   = $aes->decrypt($tradeInfo);
        $tradeArr = json_decode($tradeArrS,true);
//        $tradeInfo1 = $aes->encrypt(json_encode($tradeArr));
//        $str        = 'HashKey=' . $merKey . '&' . $tradeInfo . '&HashIV=' . $merIv;
//        $str        = strtoupper(hash("sha256", $str));
        header("Content-type:application/json");
        echo json_encode(['code' => 200, 'msg' => 'success', 'data' => ['trade_info' => $tradeArr]]);
        return;
    }

}
