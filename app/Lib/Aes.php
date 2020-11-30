<?php

namespace App\Lib;

class Aes
{

    private $key;

    private $iv;

    public function __construct($key, $iv)
    {
        $this->key = $key;
        $this->iv  = $iv;
    }

    public function encrypt($parameter = "")
    {
        $key        = $this->key;
        $iv         = $this->iv;
        $return_str = '';
        if (!empty($parameter)) {
            //將參數經過 URL ENCODED QUERY STRING
            $return_str = http_build_query($parameter);
        }
        return trim(bin2hex(openssl_encrypt($this->addPadding($return_str), 'aes-256-cbc', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv)));
    }

    public function decrypt($parameter = "")
    {
        $key = $this->key;
        $iv  = $this->iv;
        return $this->stripPadding(openssl_decrypt(hex2bin($parameter), 'AES-256-CBC',
            $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv));
    }


    private function addPadding($string, $blocksize = 32)
    {
        $len    = strlen($string);
        $pad    = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    private function stripPadding($string)
    {
        $slast  = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }

}
