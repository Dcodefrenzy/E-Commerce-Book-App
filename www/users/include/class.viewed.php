<?php 

class viewInIndex{
		private $flag;


	public function GetFromAddBook($dbcon, $flag){
		$stmt= $dbcon-> prepare("SELECT * FROM add_books WHERE flag = :f")
		$stmt ->bind_param(':f', $flag); 
		$this->flag=$flag;
		$stmt->execute();

		return $stmt;

		}
	}
}
















 ?>