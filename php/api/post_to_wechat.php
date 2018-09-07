<?php

require_once dirname(dirname(__FILE__)) . '/include/def.php';

ignore_user_abort();
set_time_limit(0);

$data = array(
    'name' => $_POST['name'],
    'phone' => $_POST['phone'],
    'mark' => $_POST['mark']
);


$options = array(
    'http' => array(
	'method' => 'POST',
	'content' => http_build_query($data),
    ),
);

write_log("\r\n\t向微信后端提交数据：" . json_encode($_POST, JSON_UNESCAPED_UNICODE) . "\r\n", __LINE__);
if ($_POST['change'] == false) {
	write_log("\r\n\t向微信后端添加数据，返回信息：", __LINE__);
	$result = file_get_contents("https://wwzx.htroy.com/jsonpost.php", false, stream_context_create($options));
} else {
	write_log("\r\n\t修改微信后端数据，返回信息：", __LINE__);
	$result = file_get_contents("https://wwzx.htroy.com/jsonmodify.php", false, stream_context_create($options));
}
write_log(json_encode(json_decode($result), JSON_UNESCAPED_UNICODE) . "\r\n", 0);
