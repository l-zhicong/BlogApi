<?php
/**
 * author 梁智聪
 * Date: 2021/5/6
 * Time: 10:03
 * comment:文件说明
 */

return [


    //默认上传配置
    'upload' => [
        'size' => 900000,
        //上传文件后缀类型
        'ext' => 'jpg,jpeg,png,gif,pem,mp3,wma,wav,amr,mp4',
    ],

    //图片上传的
    'local' =>[
        'size' => 900000,
        'ext' => 'jpg,png'
    ],

    //限制配置
    'sys_imguploads' =>[
        //次数
      'frequency'=>22222,
        //限制后解除时间 秒
        'time'=>60*60*24,
    ],
];