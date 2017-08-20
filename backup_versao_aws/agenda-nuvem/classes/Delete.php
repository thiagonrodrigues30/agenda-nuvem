<?php

require("vendor/autoload.php");
use Aws\S3\S3Client;

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
use Aws\DynamoDb\DynamoDbClient;

class Delete {


	private $db_connection = null;

	public $errors = array();

	public $timeIni;

	public $time;



	public function __construct()
	{
		if(isset($_GET['id']))
		{
			if ($this->connectDb())
			{
				$this->timeIni = date('d-m-Y / H:i:s');
				$time_start = $this->microtime_float();

				//Core
				$this->deleteContact();

				$time_end = $this->microtime_float();
				$time = $time_end - $time_start;
				$time = $time * 1000;

				$this->time = round($time, 4);
				$this->insertLogDynamoDB();
			}
			else
			{
				$this->errors[] = "Desculpe, Sem conexão com o banco de dados.";
			}
		}
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

	private function deleteContact()
	{
		// searching for contacts by the name or nickname
        $sql = "SELECT photo_url FROM contacts WHERE id = '". $_GET['id'] ."' ;";
        $query_select_url = $this->db_connection->query($sql);
        $row = $query_select_url->fetch_assoc();
        $url = $row['photo_url'];

		// searching for contacts by the name or nickname
        $sql = "DELETE FROM contacts WHERE id = '". $_GET['id'] ."' ;";
        $query_delete_contact = $this->db_connection->query($sql);
        
        //$this->deletePhoto();
        $this->deletePhotoS3($url);
	}

	private function deletePhotoS3($url)
	{
		//Montando nome do arquivo a ser deletado
        $posBarra = strrpos($url, '/');
        $nomeArquivo = substr($url, $posBarra);

		try {       
     
            // cria o objeto do cliente, necessita passar as credenciais da AWS
            $clientS3 = S3Client::factory(array(
                'credentials' => array(
                    'key'    => S3_ACCESS_KEY,
                    'secret' => S3_SECRET_KEY,
                )
            ));
     
            //Metodo para deletar a foto do contato
            $response = $clientS3->deleteObject(array(
			    'Bucket' => "tnr-agenda1",
			    'Key'    => $nomeArquivo
			));
            
     
        } catch(Exception $e) {
            $this->errors[] = $e->getMessage();
        }
	
	}

	private function deletePhoto()
	{
		unlink("img_cad/foto_contato_" . $_GET['id'] . ".jpg");
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
		$operation = 'EXC';
		
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