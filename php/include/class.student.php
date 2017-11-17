<?php

class Student {

	const REGEX_NAME = '/^[\x{4E00}-\x{9FA5}]{2,10}$/u';
	const REGEX_PHONE = '/^1[34578]\d{9}$/';
	const REGEX_EMAIL = '/^[-\w.%+]+@([-\w%+]+\.)+[a-z]+$/i';
	const REGEX_FACULTY = '/^(电子信息|机电工程|计算机|材料与食品|人文社会科学|管理|经贸|外国语|艺术设计)学院$/';
	const REGEX_CLASS = '/^(应用化学|食品质量与安全|环境工程|生物制药|材料科学与工程|通信工程|电子科学与技术|光电信息科学与工程|电子信息工程|工商管理|物流管理|财务管理|人力资源管理|机械设计制造及其自动化|自动化|电气工程及其自动化|软件工程|计算机科学与技术|数字媒体技术|网络工程|电子商务|金融学|国际经济与贸易|会展经济与管理|法学|旅游管理|新闻学|行政管理|翻译|英语|商务英语|日语|工业设计|产品设计|环境设计|视觉传达设计)(（电子科技大学2\+2联合培养）)?$/';
	const REGEX_NUMBER = '/^(2017\d{9})?$/';
	const REGEX_MARK = '/^\d{10}$/';

	/*
		public $old_name;
		public $name;
		public $phone;
		public $email;
		public $faculty;
		public $class;
		public $number;
		public $mark;
	*/
	public function __construct($data) {
		isset($data['_name']) && preg_match($this::REGEX_NAME, $data['_name']) && $this->old_name = $data['_name'];
		isset($data['name']) && preg_match($this::REGEX_NAME, $data['name']) && $this->name = $data['name'];
		isset($data['phone']) && preg_match($this::REGEX_PHONE, $data['phone']) && $this->phone = $data['phone'];
		isset($data['email']) && preg_match($this::REGEX_EMAIL, $data['email']) && $this->email = $data['email'];
		isset($data['faculty']) && preg_match($this::REGEX_FACULTY, $data['faculty']) && $this->faculty = $data['faculty'];
		isset($data['class']) && preg_match($this::REGEX_CLASS, $data['class']) && $this->class = $data['class'];
		isset($data['number']) && preg_match($this::REGEX_NUMBER, $data['number']) && $this->number = $data['number'];
		isset($data['mark']) && preg_match($this::REGEX_MARK, $data['mark']) && $this->mark = $data['mark'];
	}

	public function make_mark() {
		$mark = "";
		for ($i = 0; $i < 10; $i++) {
			$mark = $mark . rand(0, 9);
		}
		return $mark;
	}
}
