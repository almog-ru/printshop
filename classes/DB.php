<?php
class DB{
    private static $_instance = null;
    private $_pdo,
        $_query,
        $_error = false,
        $_results,
        $_count = 0;

    private  function __construct(){
        try{
        $this->_pdo = new PDO('mysql:host=' . config::get('mysql/host') . ';dbname=' . config::get('mysql/db'), config::get('mysql/username'), config::get('mysql/password'));
        }catch (PDOException $e){
            die($e->getMessage());

        }
    }

    public static function getInstance(){ //singelton pattern
        if(!isset(self::$_instance)){  //self cause of static
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query ($sql,$params = array()){
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            $i = 1;
           if(count($params)){
               foreach ($params as $param){
                   $this->_query->bindValue($i , $param);
                   $i++;
               }

           }
           if($this->_query->execute()){
               $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
               $this->_count = $this->_query->rowCount();
           }else{
               $this->_error = true;
           }

        }
        return $this;
    }

    public function action($action,$table,$where=array()){ //can be private
        if(count($where)=== 3){
            $operators = array('=','>','<','>=','<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator,$operators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if(!$this->query($sql,array($value))->error()){
                    return $this;
                }
            }
        }
        return false;

    }

    public function get ($table, $where){
        return $this->action('SE LECT *', $table,$where );

    }

    public function delete($table,$where){
        return $this->action('DELETE', $table,$where );
    }

    public function insert($table,$fields = array()){

            $keys = array_keys($fields);
            $values = '';
            $i = 1;

            foreach ($fields as $field) {
                $values .='?';
                if ($i<count($fields)){
                    $values.= ', ';

                }
                $i ++;
            }
            $sql = "INSERT INTO {$table} (`" . implode('`,`',$keys). "`) VALUES ({$values})";
            #echo $sql;
            if(!$this->query($sql,$fields)->error()){
                return true;
            }

        return false;
    }
    public function update ($table, $id,$fields){ //at the moment by id
        $set = '';
        $i = 1;

        foreach ($fields as $name=>$value){
            $set.="{$name} = ?";
            if($i < count($fields)){
                $set.=', ';
            }
            $i++;
        }


        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if (!$this->query($sql,$fields)->error()){
            return true;
        }
        return false;


    }

    public function error(){
        return $this->_error;
    }
    public function count(){
        return $this->_count;
    }
    public function results(){
        return $this->_results;
    }
    public function first (){
        return $this->results()[0];
    }
}