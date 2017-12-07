<?php
session_start();
//echo $_SESSION['username'];
include "dbconf.php";
try{
	$conn = new PDO("mysql:host=".$host.";dbname=".$db_name.";charset=utf8", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
	echo $sql."<br>".$e->getMessage();
}

try{
	$sql = "SELECT user_id FROM user_table_test WHERE username = '".$_SESSION['username']."'";
	$query = $conn->prepare($sql);
	$query->execute();
	$list = $query->fetchAll();
	//echo var_dump($list);
}
catch(PDOException $e){
	echo $sql."<br>".$e->getMessage();
}
if (sizeof($list) == 0){
	$user_id = "OneTimeUser";
} else {
	$user_id = $list[0][0];
}
$myfile = fopen("./resources/test.csv", "w");


//echo $user_id;
for( $i = 1; $i<6; $i++ ) {
	if (getID(addslashes($_POST["movie_id_".$i]),$conn) != ""){
		try{

			$movie_id = getID(addslashes($_POST["movie_id_".$i]),$conn);
			$rating_id = uniqid("r");
			$rating = $_POST["ratings_".$i];
			
			$sql = "replace into rating_table_test (rating_id, user_id, movie_id, rating) values('".$rating_id."', '".$user_id."', '".$movie_id."', '".$rating."')";
			$conn->query($sql);
		}
		catch(PDOException $e){
			echo $sql."<br>".$e->getMessage();
		}		
	}     
}
try{
		$sql = "SELECT movie_id, rating FROM rating_table_test WHERE user_id = '".$user_id."'";
		//echo $sql."<br>";
		$query = $conn->prepare($sql);
		$query->execute();
		$list = $query->fetchAll();
		//echo var_dump($list)."<br>";
		//echo $list[0]['movie_id'];
		for ($i = 0; $i < sizeof($list); $i++){
			fputcsv($myfile, array($list[$i]['movie_id'],$list[$i]['rating']));
		}
}
catch(PDOException $e){
	echo $sql."<br>".$e->getMessage();
}
//echo getID(123, $conn);
//$txt = " ".$_POST["name"]."\t".$_POST["ratings"]."\n";


fclose($myfile);

$commend = "cd /Applications/MAMP/htdocs/movie_reorganized/neural_collaborative_filtering-master && /Library/Frameworks/Python.framework/Versions/2.7/bin/python NeuMF_latest.py --mode predict --dataset ml-1m --epochs 20 --batch_size 256 --num_factors 8 --layers [64,32,16,8] --reg_mf 0 --reg_layers [0,0,0,0] --num_neg 4 --lr 0.001 --learner adam --verbose 1 --out 1 && cd /Applications/MAMP/htdocs/movie_reorganized/";
exec($commend);
//$commend = "cd /Applications/MAMP/htdocs/movie_reorganized/neural_collaborative_filtering-master && python te.py";
//echo $commend;
$output = fopen("./resources/rank1.txt", "r");
$ranks = fgets($output);
$ranks = str_replace("[", "", $ranks);
$ranks = str_replace("]", "", $ranks);
$ranks = explode(",", $ranks);
$idx = 1;
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
echo"<table>
  <tr>
    <th>Movie Name</th>
    <th>IMDB link</th>
    <th>TMDB link</th>
  </tr>";
foreach ($ranks as $rank){
	try{
		$sql = "SELECT movie_name FROM movie_table WHERE movie_id = '".trim($rank)."'";
		//echo $sql."<br>";
		$query = $conn->prepare($sql);
		$query->execute();
		$list = $query->fetchAll();
		$sql = "SELECT imdb_id, tmdb_id FROM movie_table WHERE movie_id = '".trim($rank)."'";
		$query = $conn->prepare($sql);
		$query->execute();
		$result = $query->fetchAll();
		$imdb_id = $result[0][0];
		$tmdb_id = $result[0][1];
		echo "<tr><td>".$list[0][0]."</td>".
			"<td><a href = 'http://www.imdb.com/title/tt".$imdb_id."' target = '_blank'>imdb</a></td>".
			"<td><a href = 'https://www.themoviedb.org/movie/".$tmdb_id."' target = '_blank'>tmdb</a></td></tr>";
		//echo "<li>".$list[0][0]."</li>";

		$idx = $idx + 1;
	}
	catch(PDOException $e){
		echo $sql."<br>".$e->getMessage();
	}
}
echo"</table>";

fclose($output);

function getID($movie_name, $conn){
	try{
		$sql = "SELECT movie_id FROM movie_table WHERE movie_name = '".$movie_name."'";
		//echo $sql."<br>";
		$query = $conn->prepare($sql);
		$query->execute();
		$list = $query->fetchAll();
		//echo $list[0][0]."<br>";
		return $list[0][0];
	}
	catch(PDOException $e){
		echo $sql."<br>".$e->getMessage();
	}
}

//fwrite($myfile, $txt);

//fwrite($myfile, "\t".$_POST["ratings"]);
?>
</body>
</html>