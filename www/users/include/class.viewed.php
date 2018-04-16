<?php 

class viewInIndex
{
		public $flag="";


	public function GetFromAddBook($dbcon, $flag){
		$stmt= $dbcon-> prepare("SELECT * FROM add_books WHERE flag = :f");
		$stmt ->bindParam(':f', $flag); 
		$stmt->execute();
		$this->flag = $stmt->fetch(PDO::FETCH_BOTH);
		return $this->flag;

		
	}
	public function ShowTrending($dbcon, $flag){
		
		$stmt= $dbcon-> prepare("SELECT * FROM add_books WHERE flag = :f");
		$stmt ->bindParam(':f', $flag); 
		$stmt->execute();


		return $stmt;

	}
}
















 ?>