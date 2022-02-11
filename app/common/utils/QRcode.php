<?php

namespace app\common\utils;

class QRcode extends \dh2y\qrcode\QRcode
{
    public function setCacheDir(string $cache_dir)
    {
        $this->cache_dir = root_path() . 'public/' . $cache_dir;
        if (!file_exists($this->cache_dir)) {
            mkdir($this->cache_dir, 0775, true);
        }
        return $this;
    }

}
