<?php
require_once './include/def.php';
require_once './include/class.database.php';

$db = new Database();

die($db->get_count());