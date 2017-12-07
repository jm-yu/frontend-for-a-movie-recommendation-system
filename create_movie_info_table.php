
<?php
//this script is to create a table which contains movie_id and movie_name information.

include "dbconf.php";


try{
	$conn = new PDO("mysql:host=".$host.";dbname=".$db_name.";charset=utf8", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//$sql = "CREATE DATABASE myDB";
	//$conn->exec($sql);
	//$conn->exec("select * from outputtmp where starting_phrase like 'a' ");
	
	$myfile = fopen("resources/movies_c.csv", "r") or die("unable to open file");
	$data = fgetcsv($myfile, 1000, ",");
	$data = fgetcsv($myfile, 1000, ",");
	while (($data = fgetcsv($myfile, 1000, ",")) != FALSE){
		$id = $data[0];
		$name = $data[1];
		$tag = $data[2];
		//echo $id."\t".$name."\n\n";
		$sql = "INSERT INTO movie_table (movie_id, movie_name, movie_tags) VALUES(\"".$id."\",\"".addslashes($name)."\",\"".$tag."\")";
		if ($conn->query($sql) == TRUE){
			echo "New record created";
		} else {
			echo "ERROR: ".$sql."<br>".$conn->error;
		}
		echo $sql."<br>";
		//echo var_dump($id);
	}
	fclose($myfile);

	$myfile = fopen("resources/links_c.csv", "r") or die("unable to open file");
	$data = fgetcsv($myfile, 1000, ",");
	$data = fgetcsv($myfile, 1000, ",");
	while (($data = fgetcsv($myfile, 1000, ",")) != FALSE){
		$id = $data[0];
		$imdb_id = $data[1];
		$tmdb_id = $data[2];
		//echo $id."\t".$name."\n\n";
		$sql = "UPDATE movie_table set imdb_id = \"".$imdb_id."\" , tmdb_id = \"".$tmdb_id."\"where movie_id = \"".$id."\"";
		if ($conn->query($sql) == TRUE){
			echo "Record updated ";
		} else {
			echo "ERROR: ".$sql."<br>".$conn->error;
		}
		echo $sql."<br>";
		//echo var_dump($id);
	}
	fclose($myfile);
	/*$sql = "SELECT * FROM movie_info";
	$query = $conn->prepare($sql);
	//$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
	$query->execute();
	$list = $query->fetchAll();
	echo var_dump($list);*/
	$conn->close();
}
catch(PDOException $e){
	echo $sql."<br>".$e->getMessage();
}
?>
