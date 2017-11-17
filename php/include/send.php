<?php

require_once dirname(__FILE__) . '/def.php';

function socket_submit($host, $path, $port, $data, $timeout = 30) {

	$fp = fsockopen($host, $port, $errno, $errstr, $timeout);
	write_log("\r\n\t打开 socket [hostname: $host][path: $path][port: $port][timeout: $timeout]\r\n", __LINE__);
	if (!$fp) {
		write_log("[exit]\r\n\t打开 socket 失败 [$errno: $errstr]\r\n", __LINE__);
		return;
	}

	stream_set_blocking($fp, 0);

	$data = http_build_query($data);

	$out = "POST " . $path . " HTTP/1.1\r\n";
	$out .= "host:" . $host . "\r\n";
	$out .= "content-length:" . strlen($data) . "\r\n";
	$out .= "content-type:application/x-www-form-urlencoded\r\n";
	$out .= "Connection:close\r\n\r\n";
	$out .= $data;

	fwrite($fp, $out);
	write_log("\t提交数据：" . json_encode($data, JSON_UNESCAPED_UNICODE) . "\r\n");

	usleep(20000);
	fclose($fp);
}
