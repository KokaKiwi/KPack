<?php
	KPack::register_module("kp_mysql", "MySQL support for KPack", "1.0");
	
	class KP_MySql {
		var $connection = null;
		
		function __construct($host, $user, $password, $database) {
			$this->connection = mysql_connect($host, $user, $password);
			mysql_select_db($database, $this->connection);
		}
		
		function query($query) {
			$result = mysql_query($query, $this->connection);
			return $result;
		}
		
		function select($table, $columns, $where = null, $order = null, $limit = null, $sql = null) {
			$query = "select " . $columns . " from " . $table;
			
			if($where != null) {
				$query .= ' where ' . $where;
			}
			if($order != null) {
				$query .= ' order by ' . $order;
			}
			if($limit != null) {
				$query .= ' limit ' . $limit;
			}
			if($sql != null) {
				$query .= ' ' . $sql;
			}
			
			return $this->query($query);
		}
		
		function insert($table, $datas, $sql = null) {
			$query = "insert into " . $table;
			$columns = array();
			foreach($datas as $key => $val) {
				$columns[] = $key;
			}
			$query .= "(" . implode(',', $columns) . ") values (" . implode(',', $datas) . ")";
			if($sql != null) $query .= " " . $sql;
			return $this->query($query);
		}
		
		function update($table, $datas, $where = null, $sql = null) {
			$query = "update " . $table . " set ";
			$sets = array();
			foreach($datas as $key => $val) {
				$sets[] = $key . " = " . $val;
			}
			$query .= implode(', ', $sets);
			if($where != null) {
				$query .= " where " . $where;
			}
			if($sql != null) {
				$query .= ' ' . $sql;
			}
			return $this->query($query);
		}
		
		function fetch_array($result, $toArray = false) {
			$retour = array();
			
			if(mysql_num_rows($query) > 1 || $toArray) {
				while($point = mysql_fetch_array($query)) {
					$tmp = array();
					foreach($point as $key => $val) {
						$tmp[$key] = $val;
					}
					$retour[] = $tmp;
				}
			}else{
				while($point = mysql_fetch_array($query)) {
					$tmp = array();
					foreach($point as $key => $val) {
						$tmp[$key] = $val;
					}
					$retour = $tmp;
				}
			}
			
			return $retour;
		}
	}
?>
