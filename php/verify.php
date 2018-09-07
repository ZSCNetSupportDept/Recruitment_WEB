<?php

require_once('./include/def.php');
require_once './include/class.student.php';
require_once './include/class.database.php';

$student = new Student($_POST);

write_log("\r\n", __LINE__);
write_log("\t提交数据：" . json_encode($_POST, JSON_UNESCAPED_UNICODE) . "\r\n");
write_log("\t匹配情况：[name: " . (isset($student->name) & 1) . "]"
	. "[mark: " . (isset($student->mark) & 1) . "]\r\n");

if (!isset($student->name) || !isset($student->mark)) {
	write_log("[exit]\r\n\t[$student->name] 输入不合法\r\n", __LINE__);
	die(return_json(412, "input error"));
}

$db = new Database();

$result = $db->get_record((array)$student);
if (!$result) {
	write_log("[exit]\r\n\t[$student->name][$student->mark] 回执不存在\r\n", __LINE__);
	die(return_json(412, "mark does not exist"));
}

die(return_json(200, "success", $result));
