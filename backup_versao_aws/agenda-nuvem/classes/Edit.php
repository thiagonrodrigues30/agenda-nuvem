<?php

require("vendor/autoload.php");
use Aws\S3\S3Client;

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
use Aws\DynamoDb\DynamoDbClient;

class Edit {

	public $contactsList = null;

	private $db_connection = null;

	public $errors = array();

	public $updated = false;

    public $timeIni;

    public $time;


	public function __construct()
	{
		if ($this->connectDb())
		{
			if(isset($_POST['edit']))
			{
                $this->timeIni = date('d-m-Y / H:i:s');
                $time_start = $this->microtime_float();

                //Core
				$this->saveEditedContact();

                $time_end = $this->microtime_float();
                $time = $time_end - $time_start;
                $time = $time * 1000;

                $this->time = round($time, 4);
                $this->insertLogDynamoDB();
			}
			else
			{
				$this->searchContact();
			}
		}
		else
		{
			$this->errors[] = "Desculpe, Sem conexão com o banco de dados.";
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

	private function searchContact()
	{
		// searching for contact to be edited
        $sql = "SELECT * FROM contacts WHERE id = '". $_GET['id'] ."' LIMIT 1 ;";
        $query_search_contact = $this->db_connection->query($sql);
        $this->contactsList = $query_search_contact->fetch_assoc();
        
	}

	private function saveEditedContact()
	{
		$date = $this->setDate();

		// searching for contact to be edited
        $sql = "UPDATE contacts SET name = '". $_POST['name'] ."' , nickname = '". $_POST['nickname'] ."' , email = '". $_POST['email'] ."' , telephone = '". $_POST['telephone'] ."' , date = '". $date ."' WHERE id = '". $_POST['id'] ."' ;";
        $query_update_contact = $this->db_connection->query($sql);
        $this->updated = true;

        if($query_update_contact AND ($_FILES["photo"]["name"] != ""))
        {
        	$this->savePhotoS3($_POST['id']);
        }
        
	}

	private function setDate()
    {
    	return "2016-" . $_POST['month'] . "-" . $_POST['day'];
    }

    private function savePhotoS3($id)
    {
        //Mudar nome do arquivo
        $nomeArquivo = $_FILES["photo"]["name"];
        $posPonto = strrpos($nomeArquivo, '.');
        $novoNome = "foto_contato_" . $id . substr($nomeArquivo, $posPonto);

 
        try {       
     
            // cria o objeto do cliente, necessita passar as credenciais da AWS
            $clientS3 = S3Client::factory(array(
                'credentials' => array(
                    'key'    => S3_ACCESS_KEY,
                    'secret' => S3_SECRET_KEY,
                )
            ));
     
            // método putObject envia os dados pro bucket selecionado (no caso, teste-marcelo
            $response = $clientS3->putObject(array(
                'Bucket' => "tnr-agenda1",
                'Key'    => $novoNome,
                'SourceFile' => $_FILES['photo']['tmp_name'],
            ));
            
            //Saving url photo's in the database
            //$this->savePhotoURL($id, $response['ObjectURL']);
     
        } catch(Exception $e) {
            $this->errors[] = $e->getMessage();
        }

    }

    private function savePhoto($id)
    {
    	$nomeArquivo = $_FILES["photo"]["name"];
        $temp = $_FILES["photo"]["tmp_name"];
        $posPonto = strrpos($nomeArquivo, '.');
        $novoNome = "foto_contato_" . $id . substr($nomeArquivo, $posPonto);
            
        $diretorio = "img_cad";
        move_uploaded_file($temp, $diretorio.'/'.$novoNome);
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
        $operation = 'ALT';
        
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