<?php

require_once './include/def.php';
require_once './include/send.php';
require_once './include/class.database.php';
require_once './include/class.student.php';

//print_r($_POST);

$student = new Student($_POST);

write_log("\r\n", __LINE__);
write_log("\t提交数据：" . json_encode($_POST, JSON_UNESCAPED_UNICODE) . "\r\n");
write_log("\t匹配情况：[name: " . (isset($student->name) & 1) . "]" .
	"[phone: " . (isset($student->phone) & 1) . "]" .
	"[email: " . (isset($student->email) & 1) . "]" .
	"[faculty: " . (isset($student->faculty) & 1) . "]" .
	"[class: " . (isset($student->class) & 1) . "]" .
	"[number: " . (isset($student->number) & 1) . "]\r\n");

if (!isset($student->name) || !isset($student->phone) || !isset($student->email) ||
	!isset($student->faculty) || !isset($student->class) || !isset($student->number)) {
	write_log("[exit]\r\n\t[$student->name] 输入不合法\r\n", __LINE__);
	die(return_json(412, "input error"));
}

$db = new Database();

$result = $db->is_exist((array)$student);
if (!$result) {
	write_log("[exit]\r\n\t找不到学生 [$student->name][$student->faculty][$student->class][$student->number]\r\n", __LINE__);
	die(return_json(412, "information does not exist"));
}

$result = $db->get_record(['number' => $student->number]);
if ($result) {
	write_log("[exit]\r\n\t[$student->name][$student->number] 学号已注册\r\n", __LINE__);
	die(return_json(409, "student id is registered"));
}

$result = $db->get_record(['phone' => $student->phone]);
if ($result) {
	write_log("[exit]\r\n\t[$student->name][$student->phone] 手机号已注册\r\n", __LINE__);
	die(return_json(409, "phone is registered"));
}

$result = $db->get_record(['email' => $student->email]);
if ($result) {
	write_log("[exit]\r\n\t[$student->name][$student->email] 邮箱已注册\r\n", __LINE__);
	die(return_json(409, "email is registered"));
}

do {
	$student->mark = $student->make_mark();
	$result = $db->get_record(['mark' => $student->mark]);
} while ($result);

$result = $db->add_record((array)$student);

write_log("\r\n\t[$student->name][$student->phone][$student->email][$student->faculty]" .
	"[$student->class][$student->number] 注册成功，回执编号为 [$student->mark]\r\n", __LINE__);

$data = [
	'address' => $student->email,
	'subject' => '报名成功',
	'body' => "报名成功，您的回执编号是：$student->mark",
	'isHTML' => true
];
socket_submit($_SERVER['HTTP_HOST'], dirname($_SERVER['SCRIPT_NAME']) . '/api/send_mark.php', $_SERVER['SERVER_PORT'], $data);

$data = [
	'name' => $student->name,
	'phone' => $student->phone,
	'mark' => $student->mark,
	'change' => false
];
socket_submit($_SERVER['HTTP_HOST'], dirname($_SERVER['SCRIPT_NAME']) . '/api/post_to_wechat.php', $_SERVER['SERVER_PORT'], $data);

die(return_json(200, "success", ['mark' => $student->mark]));
