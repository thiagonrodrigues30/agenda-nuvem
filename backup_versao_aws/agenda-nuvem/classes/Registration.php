<?php

require("vendor/autoload.php");
use Aws\S3\S3Client;

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
use Aws\DynamoDb\DynamoDbClient;

class Registration {


    
    private $db_connection = null;
    
    public $errors = array();
    
    public $messages = array();

    public $timeIni;

    public $time;


    public function __construct(){
        

    	if(isset($_POST['register']))
    	{
            $this->timeIni = date('d-m-Y / H:i:s');
            $time_start = $this->microtime_float();

            //The mechanical of the class
    		$this->registerNewContact();

            $time_end = $this->microtime_float();
            $time = $time_end - $time_start;
            $time = $time * 1000;

            $this->time = round($time, 4);
            $this->insertLogDynamoDB();
    	}
    }

    private function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    private function registerNewContact()
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

            // escaping, additionally removing everything that could be (html/javascript-) code
            $name = $this->db_connection->real_escape_string(strip_tags($_POST['name'], ENT_QUOTES));
            $email = $this->db_connection->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
            $nickname = $this->db_connection->real_escape_string(strip_tags($_POST['nickname'], ENT_QUOTES));

            // check if email address already exists
            $sql = "SELECT * FROM contacts WHERE email = '" . $email . "';";
            $query_check_email = $this->db_connection->query($sql);

            if ($query_check_email->num_rows >= 1) {
                $this->errors[] = "Desculpe, já existe um contato cadastrado com esse email.";
            } else {

            	$date = $this->setDate();

                // write new contact's data into database
                $sql = "INSERT INTO contacts (name, nickname, email, telephone, date)
                        VALUES('". $name ."' , '". $nickname ."' , '". $email ."' , '". $_POST['telephone'] ."' , '". $date ."');";
                $query_new_contact_insert = $this->db_connection->query($sql);

                // if contact has been added successfully
                if ($query_new_contact_insert) {

                	// select id of this inserted contact
                	$sql = "SELECT MAX(id) as id FROM contacts";
                	$query_max_id = $this->db_connection->query($sql);
                	$row = $query_max_id->fetch_assoc();
                	$id = $row['id'];

                	// save contact's photo
                	//$this->savePhoto($id);
                    $this->savePhotoS3($id);


                    $this->messages[] = "O contato foi inserido com sucesso.";

                } else {
                    $this->errors[] = "Desculpe, a inserção do contato falhou. Por favor, tente novamente mais tarde.";
                }
            }
        } else {
            $this->errors[] = "Desculpe, Sem conexão com o banco de dados.";
        }

    }

    private function setDate()
    {
    	return "2016-" . $_POST['month'] . "-" . $_POST['day'];
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
            $this->savePhotoURL($id, $response['ObjectURL']);
     
        } catch(Exception $e) {
            $this->errors[] = $e->getMessage();
        }

    }

    private function savePhotoURL($id, $url)
    {
        // searching for contact to be edited
        $sql = "UPDATE contacts SET photo_url = '". $url ."' WHERE id = '". $id ."' ;";
        $query_update_contact = $this->db_connection->query($sql);
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
        $operation = 'CAD';
        
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