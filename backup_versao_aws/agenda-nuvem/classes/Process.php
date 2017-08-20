<?php

class Process{

	public $res = null;

	
	public function __construct(){

    	if(isset($_POST['process']))
    	{
    		$this->gerarSobrecarga2();
    	}

	}

	function gerarSobrecarga(){

		set_time_limit(60);

		$res = 2;

		$i = 1;
		while($i < 100000000000000)
		{
			$res = $res * $res;
			$i++;
		}

		$this->res = $res;
	}

	function gerarSobrecarga2(){

		set_time_limit(500);

		for($i = 1; $i < 200; $i++)
		{
			exec("cmd.exe \c dir.bat");
		}
	}



}


?>