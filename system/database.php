<?php

class Database {
    public $db;

    public function __construct(){
        if(!isset($this->db)){

            try {
                $conn = new PDO("mysql:host=".config::HOST.";dbname=".config::DBNAME, config::USER, config::PASSWORD);

                
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $this->db = $conn;
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
		}
	}
    
	function __distruct()
    {
        mysql_close($this->link);
    }

    public function getRows($table,$conditions = array()){
		$sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$table;
        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
        
        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by']; 
        }
        
        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit']; 
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit']; 
        }
		
		if(array_key_exists("stringQuery",$conditions)){
			$sql = $conditions['stringQuery'];
		}
        $query = $this->db->prepare($sql);
        $query->execute();
        
        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $query->rowCount();
                    break;
                case 'single':
                    $data = $query->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        }else{
            if($query->rowCount() > 0){
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }else {
                $data = [];
            }
        }
		
		return ($data!='')? $data : false;
		
		die();
    }

    public function insert($table, $data){
        if(!empty($data) && is_array($data)) {
            $columns = '';
            $values  = '';
            $i = 0;

            $columnString = implode(',', array_keys($data));
            $valueString = ":".implode(',:', array_keys($data));
            $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
            $query = $this->db->prepare($sql);
            foreach($data as $key=>$val) {
                $val = htmlspecialchars(strip_tags($val));
                $query->bindValue(':'.$key, $val);
            }
            $insert = $query->execute();
            if($insert) {
                $data['id'] = $this->db->lastInsertId();
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function update($table,$data,$conditions){
        if(!empty($data) && is_array($data) || $conditions['stringQuery']){
            $colvalSet = '';
            $whereSql = '';
            $i = 0;
			
			if(array_key_exists("stringQuery",$conditions)){
				$sql = $conditions['stringQuery'];
			}else{
				foreach($data as $key=>$val){
					$pre = ($i > 0)?', ':'';
					$val = htmlspecialchars(strip_tags($val));
					$colvalSet .= $pre.$key."='".$val."'";
					$i++;
				}
				if(!empty($conditions)&& is_array($conditions)){
					$whereSql .= ' WHERE ';
					$i = 0;
					foreach($conditions as $key => $value){
						$pre = ($i > 0)?' AND ':'';
						$whereSql .= $pre.$key." = '".$value."'";
						$i++;
					}
				}
                $sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
                error_log($sql);
			}
            $query = $this->db->prepare($sql);
            $update = $query->execute();
            return $update?$update:false;
        }else{
            return false;
        }
    }
}