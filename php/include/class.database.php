<?php

class Database {

	private $DB_TYPE = 'mysql';
	private $DB_HOST = 'localhost';
	private $DB_NAME = 'reg_db';	/*MySQL database name, we use 'reg_db' here.*/
	private $DB_USR = '';			/*Your MySQL username*/
	private $DB_PWD = '';			/*Your MySQL password*/
	private $DB_OPT = [PDO::ATTR_PERSISTENT => true];
	private $con;

	public function __construct() {
		$this->connect();
	}

	public function add_record(array $data, $return_data = true) {
		$key = join(', ', array_keys($data));
		$val = join(', ', array_map([$this->con, 'quote'], $data));

		$result = $this->con->query("INSERT INTO regd ($key) VALUES ($val)");
		if ($return_data) {
			return $result->fetch();
		} else {
			return $result;
		}
	}

	public function get_record(array $who, array $what = ['*'], $return_data = true) {
		$where = $this->key_val($who, ' AND ');
		$key = join(', ', $what);

		$result = $this->con->query("SELECT $key FROM regd WHERE $where");
		if ($return_data) {
			return $result->fetch();
		} else {
			return $result;
		}
	}

	public function mod_record(array $who, array $data, $return_data = true) {
		$where = $this->key_val($who, ' AND ');
		$sql = $this->key_val($data, ', ');

		$result = $this->con->query("UPDATE regd SET $sql WHERE $where");
		if ($return_data) {
			return $result->fetch();
		} else {
			return $result;
		}
	}

	public function is_exist(array $student, $return_data = true) {
		$result = $this->con->query("SELECT * FROM info, stu_id" .
			" WHERE info.name='$student[name]' AND info.faculty='$student[faculty]'" .
			" AND info.discipline='$student[class]' AND stu_id.name='$student[name]'" .
			" AND stu_id.number='$student[number]'");

		if ($return_data) {
			return $result->fetch();
		} else {
			return $result;
		}
	}

	public function get_count() {
		return $this->con->query("SELECT COUNT(*) FROM regd")->fetch()[0];
	}

	private function connect() {
		try {
			$DSN_REG = "{$this->DB_TYPE}:host={$this->DB_HOST};dbname={$this->DB_NAME}";
			$this->con = new PDO($DSN_REG, $this->DB_USR, $this->DB_PWD, $this->DB_OPT);
		} catch (PDOException $e) {
			die("Error: " . $e->getMessage());
		}

		$this->con->query("CREATE TABLE IF NOT EXISTS regd ("
			. "ID int NOT NULL AUTO_INCREMENT, "
			. "PRIMARY KEY(ID), "
			. "name varchar(20), "
			. "phone varchar(20), "
			. "email varchar(100), "
			. "faculty varchar(20), "
			. "class varchar(20), "
			. "number varchar(20), "
			. "mark varchar(20)"
			. ")"
		);
	}

	private function key_val(array $arr, $join) {
		return array_reduce(array_keys($arr),
			function ($carry, $key) use ($arr, $join) {
				return ($carry ? "$carry$join" : '') . "$key=" . $this->con->quote($arr[$key]);
			});
	}


}
