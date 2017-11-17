<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
	<title>send email</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		input[type=text] {
			width: 100%;
		}

		textarea {
			width: 100%;
			height: 70vh;
		}
	</style>
</head>
<body>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
	<input type="text" name="subject" id="subject" placeholder="subject">
	<br>
	<textarea name="body" id="body" placeholder="body"></textarea>
	<br>
	<input type='submit'>
</form>

<?php
print_r($_POST);
echo '<br>';
if (!isset($_POST['body']) || !$_POST['body']) {
	return;
}

require_once './include/def.php';
require_once './include/smtp.php';

header("Content-type:text/html;charset=utf-8");
header('Cache-Control: no-cache');  // 告知浏览器不进行缓存
header('X-Accel-Buffering: no');    // 关闭加速缓冲
date_default_timezone_set('Asia/Shanghai');

ignore_user_abort();
set_time_limit(0);
ob_end_flush();
ob_implicit_flush(1);

$subject = $_POST['subject'];
$body = $_POST['body'];

$db = new Database();

$result = $db->get_record([0], ['email'], false);

$email = [];
$flag = 0;
$address = 1;
write_log("\r\n\t[$subject][$body]\r\n", __LINE__, ['send.log']);
while ($address) {
	if (sizeof($email) < 5 && ($address = $result->fetch(PDO::FETCH_NUM))) {
		echo '->' . $address[0] . '<br>';
		if (!$email) {
			write_log("\t", 0, ['send.log']);
		}
		write_log("[$address[0]]", 0, ['send.log']);
		$email[] = $address[0];
		continue;
	}
	if (!$email) {
		break;
	}

	if ($flag) {
		sleep(3 * 60);
	}

	$ret = send_message($email, $subject, $body);
	if ($ret === '发送成功') {
		write_log("\r\n\t发送成功\r\n", 0, ['send.log']);
		echo date("[Y-m-d H:i:s]") . ' 发送成功';
	} else {
		write_log("\r\n\t发送失败\r\n\t$ret", 0, ['send.log']);
		echo date("[Y-m-d H:i:s]") . " 发送失败<br><pre>$ret</pre><br>";
	}
	echo '<br>等待三分钟发送下一封邮件<br><br>';
	$email = [];
	$flag = 1;
}

write_log("\r\n\t[$subject][$body] 发送完成\r\n", 0, ['send.log']);
die('发送完成');
?>

</body>
</html>
