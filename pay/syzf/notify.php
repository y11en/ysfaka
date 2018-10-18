<?php
require_once '../inc.php';

$data = $payDao->getReqdata($_POST);
$payconf = $payDao->checkAcp('syzf');
$sign = $data['sign'];
unset($data['sign']);

$payarr = [
    'zfbqr' => '支付宝扫码',
    'wxqr' => '微信扫码',
];

// 加密验签
$apikey = $payconf['userkey'];// 您的token
$signStr = md5Sign(createLinkstring(argSort($data)), $apikey);

if ($signStr == $sign) {
    // 验证通过，这里是您的逻辑代码
    $res = $payDao->updateOrder($data['sdorderno'],$payarr[$data['paytype']],$data['orderid']);
    if(!$res)exit('success');
    exit('success');
} else{
    exit('error');
}
