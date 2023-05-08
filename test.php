<?php 

$id = $_GET['idd'];
//echo $id;
include_once('config.php');

$stmt = $db->prepare("SELECT * FROM country WHERE country_id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if($stmt->errno !=  0){
	echo 'query failed';
}
else { ?>
city : <select name="_city">
<?php while ($row=$result->fetch_assoc()) {?>
<option value="<?php echo $row['city_id'];?>"> <?php echo $row['city_name'];?> </option>
<?php } ?>
</select>


<?php }
?>