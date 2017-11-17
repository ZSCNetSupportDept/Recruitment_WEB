<?php

header("Content-type:application/json;charset=utf-8");
date_default_timezone_set('Asia/Shanghai');

// date("[Y-m-d H:i:s]");
// 64000000 = 64M = 1000B * 1000 * 64 = 1KB * 1000 * 64 = 1MB * 64
const max_file_size = 8000000; // 8M

function write_log($content, $line = 0, array $path_list = ["log1.log", "log2.log"]) {
	$path_list = array_map(function ($name) {
				return dirname(dirname(__FILE__)) . "/logs/$name";
			}, $path_list);

	for ($i = 0; $i < sizeof($path_list); $i++) {
		error_log('', 3, $path_list[$i]);
		if (filesize($path_list[$i]) < max_file_size) {
			$cur = $i;
		}
	}

	if ($i == sizeof($path_list)) {
		$cur = 0;
	}

	$log = $path_list[$cur];

	if ($line != 0) {
		error_log(date("[Y-m-d H:i:s]") . "[$_SERVER[SCRIPT_NAME]:$line] ", 3, $log);
	}
	error_log($content, 3, $log);

	if (sizeof($path_list) > 1 && filesize($path_list[$cur]) >= max_file_size) {
		$next = ($cur + 1) % sizeof($path_list);
		fclose(fopen($path_list[$next], "w"));
	}
}

function return_json($status, $msg, $data = null) {
	$ret = [
		"status" => $status,
		"msg" => $msg,
	];

	if (isset($data)) {
		$ret['data'] = $data;
	}

	return json_encode($ret, JSON_UNESCAPED_UNICODE);
}
