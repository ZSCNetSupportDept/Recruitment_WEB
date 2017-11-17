<?php

require_once dirname(dirname(__FILE__)) . '/include/def.php';
require_once dirname(dirname(__FILE__)) . '/include/smtp.php';

ignore_user_abort();
set_time_limit(0);

for ($i = 1; $i <= 10; $i++) {
	write_log("第 $i 次发送：[$_POST[address]][$_POST[subject]][$_POST[body]]\r\n", __LINE__);
	if (!isset($_POST['address']) || !isset($_POST['body'])) {
		write_log("[exit]\r\n\t没有设置改件人或内容\r\n", __LINE__);
		return;
	}
	$ret = send_message($_POST['address'], $_POST['subject'], $_POST['body'], $_POST['isHTML']);
	if ($ret === '发送成功') {
		write_log("\r\n\t发送成功\r\n", __LINE__);
		return;
	}
	write_log("\r\n\t发送失败 $ret\r\n", __LINE__);
	if (strpos($ret, 'https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting') === false) {
		write_log("\r\n\t结束发送");
		exit();
	}
	sleep(3 * 60);
}