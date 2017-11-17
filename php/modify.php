<?php

require_once './include/def.php';
require_once './include/send.php';
require_once './include/class.database.php';
require_once './include/class.student.php';

$student = new Student($_POST);

//print_r($_POST);

write_log("\r\n", __LINE__);
write_log("\t提交数据：" . json_encode($_POST, JSON_UNESCAPED_UNICODE) . "\r\n");
write_log("\t匹配情况：[_name: " . (isset($student->old_name) & 1) . "]"
	. "[mark: " . (isset($student->mark) & 1) . "]"
	. "[name: " . (isset($student->name) & 1) . "]"
	. "[phone: " . (isset($student->phone) & 1) . "]"
	. "[email: " . (isset($student->email) & 1) . "]"
	. "[faculty: " . (isset($student->faculty) & 1) . "]"
	. "[class: " . (isset($student->class) & 1) . "]"
	. "[number: " . (isset($student->number) & 1) . "]\r\n");


if (!isset($student->old_name) || !isset($student->mark) ||
	!isset($student->name) || !isset($student->phone) ||
	!isset($student->email) || !isset($student->faculty) ||
	!isset($student->class) || !isset($student->number)) {
	write_log("[exit]\r\n\t[$student->name] 输入不合法\r\n", __LINE__);
	die(return_json(412, "input error"));
}

$db = new Database();

$result = $db->get_record(['name' => $student->old_name, 'mark' => $student->mark]);
if (!$result) {
	write_log("[exit]\r\n\t[_name: $student->old_name] 与 [mark: $student->mark] 不匹配" . "\r\n", __LINE__);
	die(return_json(412, "input error"));
}

$result = $db->is_exist((array)$student);
if (!$result) {
	write_log("[exit]\r\n\t找不到学生 [$student->name][$student->faculty][$student->class]\r\n", __LINE__);
	die(return_json(412, "information does not exist"));
}

$result = $db->get_record(['number' => $student->number]);
if ($result && $result['mark'] != $student->mark) {
	write_log("[exit]\r\n\t[$student->old_name][$student->number] 学号已注册\r\n", __LINE__);
	die(return_json(409, "student id is registered"));
}

$result = $db->get_record(['phone' => $student->phone]);
if ($result && $result['mark'] != $student->mark) {
	write_log("[exit]\r\n\t[$student->old_name][$student->phone] 手机号已注册\r\n", __LINE__);
	die(return_json(409, "phone is registered"));
}

$result = $db->get_record(['email' => $student->email]);
if ($result && $result['mark'] != $student->mark) {
	write_log("[exit]\r\n\t[$student->old_name][$student->email] 邮箱已注册\r\n", __LINE__);
	die(return_json(409, "email is registered"));
}

$who = [
	'mark' => $student->mark,
	'name' => $student->old_name,
];
$db->mod_record($who, array_diff((array)$student, $who));

write_log("[$student->old_name][$student->mark] -> [$student->name][$student->phone]" .
	"[$student->email][$student->faculty][$student->class][$student->number] 修改信息成功\r\n", __LINE__);

$data = [
	'name' => $student->name,
	'phone' => $student->phone,
	'mark' => $student->mark,
	'change' => true
];
socket_submit($_SERVER['HTTP_HOST'], dirname($_SERVER['SCRIPT_NAME']) . '/api/post_to_wechat.php', $_SERVER['SERVER_PORT'], $data);

die(return_json(200, "success"));
