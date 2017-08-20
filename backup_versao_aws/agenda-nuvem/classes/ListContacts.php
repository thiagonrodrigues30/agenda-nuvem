<?php

require ("vendor/autoload.php");

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
use Aws\DynamoDb\DynamoDbClient;

class ListContacts {

	public $contactsList = null;

	public $numContacts = null;

	private $db_connection = null;

	public $errors = array();

	public $timeIni;

	public $time;



	public function __construct()
	{
		$this->timeIni = date('d-m-Y / H:i:s');
		$time_start = $this->microtime_float();

		
		if ($this->connectDb())
		{
			$this->listContacts();
		}
		else
		{
			$this->errors[] = "Desculpe, Sem conexão com o banco de dados.";
		}
		
		$time_end = $this->microtime_float();
		$time = $time_end - $time_start;
		$time = $time * 1000;

		$this->time = round($time, 4);
		$this->insertLogDynamoDB();
	}

	private function microtime_float()
	{
    	list($usec, $sec) = explode(" ", microtime());
    	return ((float)$usec + (float)$sec);
	}

	private function connectDb()
	{
		// create a database connection
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }

        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno)
        {
        	return true;
        }
        else
        {
        	return false;
        }
	}

	private function listContacts()
	{
		// saving all contacts
        $sql = "SELECT * FROM contacts;";
        $query_list_contacts = $this->db_connection->query($sql);
        $this->contactsList = $query_list_contacts->fetch_all(MYSQLI_ASSOC);
        $this->numContacts = $query_list_contacts->num_rows;
	}


	private function insertLogDynamoDB()
	{
		$clientDynamoDB = DynamoDbClient::factory(array(
            'credentials' => array(
                'key'    => S3_ACCESS_KEY,
                'secret' => S3_SECRET_KEY,
            ),
            'region' => 'us-west-2'
        ));

        $m = new Marshaler();

		$tableName = 'tnr_agenda_log';
		$time = $this->timeIni;
		$t_exec = $this->time;
		$operation = 'LIST';
		
		try {

			$result = $clientDynamoDB->putItem(array(
			    'TableName' => $tableName,
			    'Item' => $m->marshalItem(array(
			        'time'      => $time,
			        'operation'    => $operation,
			        't_exec'   => $t_exec
			    )),
			    'ReturnConsumedCapacity' => 'TOTAL'
			));

		} catch (DynamoDbException $e) {
		    $this->errors[] = $e->getMessage();
		}

	}


}


?>