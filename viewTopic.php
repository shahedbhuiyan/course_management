<?php
	if(!session_id()) session_start();
	include_once("header.php");
	include_once("DB.php");
    $conn = DBMgr::getInstance()->getConnection();

    function getBatchList($conn){
		$sql = "SELECT id,batch_name FROM batch_details WHERE instructor_id = ?";
		$stmt = $conn->prepare($sql);

		$stmt->bindParam(1,$_SESSION['u_ID']);

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
?>

<table>
	<tr>
		<td valign = 'top'><select name = 'batch_id' style = 'height:300px' id = 'batch_id' multiple>
			<option value = ''>----------------------</option>
			<?php
				foreach ($ary as $key => $value) {
					echo "<option value = '".$key."'>".$value."</option>";
				}
			?>
		</select></td>
		<td valign = 'top'>
			<table>
				<tr>
					<th>Course Title : </th>
					<th id = 'course_title' align = 'left'></th>
				</tr>
			</table>
			<table id = 'details_tbl' cellspacing = '0' cellpadding = '8'>
	
			</table>
		</td>
	</tr>
</table>
<?php
	include_once("footer.php");
?>
<script type="text/javascript">
	$(document).ready(function(){
		var courseList = [];
		$.ajax({
			url:"service_sql.php",
			type:"POST",
			dataType:"json",
			data:{action:"getCourseTitle"},
			success:function(data){
				courseList = data;
			}
		});

		$("#batch_id").change(function(){
			var val = $(this).attr('value');
			if(val != ""){
				$("#course_title").html(courseList[val]);
			} else {
				$("#course_title").html("");	
			}
			$.ajax({
				url:"service_sql.php",
				type:"POST",
				data:{action:"getTopicListDet",batch_id:val},
				success:function(data){
					$("#details_tbl").html(data);
				}
			});
		});
	});
</script>
<style type="text/css">
	#details_tbl{
		font-family: verdana;
		font-size: 14px;
	}
	.header{
		background-color: green;
		color:white;
	}
</style>