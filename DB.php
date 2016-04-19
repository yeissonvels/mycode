<?php
/**
 * @author Yeisson Vélez
 * @date 23/04/2014
 */

class WPDB {
    public  $prefix;
    private $linker;
    public $insert_id;
    protected $defaultTimeZone;

    function __construct() {
        // If you want have differents configuration for you app (localhost, prod, dev, etc)
        // You can define one file for every environment
        $conf = new Config('config_localhost.php');

        $this->prefix = $conf->getPrefix();
        $this->defaultTimeZone = $conf->getDefaultTimeZone();

        date_default_timezone_set($this->defaultTimeZone);

        $this->linker = mysqli_connect($conf->getHost(), $conf->getUser(), $conf->getPassword());

        if (!$this->linker) {
            die('Connection error: ' . mysqli_error($this->linker));
        } else {
            $bd_selected = mysqli_select_db($this->linker, $conf->getDbname());
            if (!$bd_selected) {
                die('Select DB error: ' . mysqli_error($this->linker));
            }
        }

        mysqli_set_charset($this->linker, "utf8");
    }

    /**
     * @param $query
     * @return array
     *
     * It gets all results of a query
     */
    function get_results($query) {
        $array = array();
        if($result = (mysqli_query($this->linker,$query)) or die(mysqli_error($this->linker)) . ' ' . $query){
            // Cycle through results
            while($row = mysqli_fetch_object($result)){
                array_push($array, $row);
            }
        }
        return $array;
    }

    /**
     * @param $query
     * @return null|object
     *
     */
    function get_row($query) {
        $result = (mysqli_query($this->linker, $query)) or die(mysqli_error($this->linker)) . ' ' . $query;

        return mysqli_fetch_object($result);
    }


    /**
     * @param $query
     *
     * It executes a query
     */
    function query($query) {
        mysqli_query($this->linker, $query) or die(mysqli_error($this->linker) . ' ' . $query);

        $this->insert_id = mysqli_insert_id($this->linker);
    }

    /**
     * @param $table
     * @return bool
     *
     * It saves a POST array dinamically
     */
    function save($table) {
        $obj = $_POST;

        $query = 'INSERT INTO ' . $table;
        $query .= '('.implode(', ', array_map(function ($v, $s) {return '' . $s;}, $obj, array_keys($obj))) . ')';
        $query .= 'VALUES ("' . implode('", "', array_map(function ($v, $s) {return '' . $v;}, $obj, array_keys($obj))).'")';

        $this->query($query);
    }

    /**
     * @param $table
     * @param $criteria (array key value) 
     * @return string
     *
     * searchByCriteria('users', array('id' => '> 4', 'active' => 1, 'profile' => '>2'));
     */
    function searchByCriteria($table, $criteria) {
        $query = 'SELECT * FROM ' . $table . ' WHERE ';

        $i = 0;
        foreach ($criteria as $key => $value) {
            if ($i < count($criteria)-1) {
                $query .= $key . " " . "" .$value. " AND ";
            } else {
                $query .= $key . " " . "" .$value. " ";
            }
            $i++;
        }

        return $this->get_results($query);
    }

    /**
     * @param $table
     * @param $id
     * @return null|object
     *
     * return one row
     */
    function getOneRow($table,$id) {
        $query = 'SELECT * FROM ' . $table . ' WHERE id=' . $id;

        return $this->get_row($query);
    }

    /**
     * @param $table
     * @param string $where
     * @param string $orderby
     * @return array
     *
     * Return a fully table
     */
    function getAll($table, $where = "", $orderby = "", $limit = "") {
        $query = 'SELECT * FROM ' . $table . ' ' . $where . ' ' . $orderby . ' ' . $limit;

        $data = $this->get_results($query);

        return $data;
    }
}

?>
