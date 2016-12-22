<?php
	include_once("header.php");
	include_once("DB.php");
	$conn = DBMgr::getInstance()->getConnection();

	function getBatchList($conn){
		$sql = "SELECT id,batch_name FROM batch_details";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$batch_list_ary = [];

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$id 		= $row['id'];
			$name 		= $row['batch_name'];

			$batch_list_ary[$id] = $name;
		}
		return $batch_list_ary;
	}
	$ary = getBatchList($conn);
	$id = "";
	if(isset($_POST['batch_id'])){
		$id = $_POST['batch_id'];
	}
?>
	<table>
		<tr>
			<form name = 'frm' action = 'student_list.php' method='post'>
			<td><select name = 'batch_id' id = 'batch_id' onchange = 'javascript:frm.submit()'>
				<option value = ''>Select Batch</option>
				<?php
					foreach ($ary as $key => $value) {
						if($id == $key){
							echo "<option value = '".$key."' selected>".$value."</option>";
						} else {
							echo "<option value = '".$key."'>".$value."</option>";
						}
					}
				?>
			</select></td>
			</form>
			<td></td>
			<td></td>
		</tr>
	</table>
<?php
	include_once("footer.php");
?>