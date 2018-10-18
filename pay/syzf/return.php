<?php
require_once '../inc.php';


$data = $payDao->getReqdata($_GET);

header('location:/chaka?oid=' . $data['sdorderno']);