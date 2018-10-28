<?php
require_once '../inc.php';


$orderid = $payDao->req->get('orderid');

//查询订单是否存在
$order = $payDao->checkOrder($orderid);
$payconf = $payDao->checkAcp('syzf');
$data['customerid'] = $payconf['userid']; //您的商户id
$data['ordername'] = $order['oname'];
$data['sdorderno'] = $order['orderid'];
$data['total_fee'] = number_format($order['cmoney'], 2, '.', '');
$data['paytype'] =  $payDao->req->get('paycode');
$data['notifyurl'] = $payDao->urlbase . $_SERVER['HTTP_HOST'] . '/pay/syzf/notify.php';
$data['returnurl'] = $payDao->urlbase . $_SERVER['HTTP_HOST'] . '/pay/syzf/return.php';
$data['remark'] = '';
$data['version'] = '1.0';
$data['cardnum'] = 'json';
$apikey = $payconf['userkey'];// 您的token
$signStr = md5Sign(createLinkstring(argSort($data)), $apikey);
$data['sign'] = $signStr;
$http = new \YS\app\libs\Http('https://shayupay.com/apisubmit', $data);
$http->toUrl();
$res = json_decode($http->getResContent(), true);
if ($res['status'] == 'success') {
    header('location:' . $res['data']['payurl']);
} else {
    exit($res['msg']);
}