<?php
	if(!session_id()) session_start();

	include_once("header.php");
	include_once("DB.php");
    $conn = DBMgr::getInstance()->getConnection();

    function generateID($conn){
    	$sql = "SELECT MAX(id) as max_id FROM course_topic";
    	$stmt = $conn->prepare($sql);
    	$stmt->execute();

    	$row = $stmt->fetch(PDO::FETCH_ASSOC);
    	return $row['max_id'] + 1;
    }
    //echo generateID($conn);
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

	function getCourseList($conn){
		$sql = "SELECT id,course_name FROM course";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$course_list_ary = [];

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$id 		= $row['id'];
			$name 		= $row['course_name'];

			$course_list_ary[$id] = $name;
		}
		return $course_list_ary;
	}
	$course_list = getCourseList($conn);


	if(isset($_POST['save']) && !empty($_POST['save'])){
    	try{
    		if(!isExist($_POST['topic_title'],$_POST['batch_id'],$conn)){
    			$max_id = generateID($conn);
	            $sql = "INSERT INTO course_topic (id,topic_name,tdate,batch_id) VALUES (?,?,?,?)";
	            $sql1 = "INSERT INTO topic_content (course_topic_id,topic_desc,topic_file,importantLink1,importantLink2,videoLink1,videoLink2) VALUES (?,?,?,?,?,?,?)";
	            

	            $conn->beginTransaction();
	            $stmt = $conn->prepare($sql);

	            $stmt->bindParam(1,$max_id);
	            $stmt->bindParam(2,$topic_name);
	            $stmt->bindParam(3,$tdate);
	            $stmt->bindParam(4,$batch_id);


	            $stmt1 = $conn->prepare($sql1);
				$stmt1->bindParam(1,$max_id);
	            $stmt1->bindParam(2,$topic_desc);
	            $stmt1->bindParam(3,$topic_file);
	            $stmt1->bindParam(4,$importantLink1);
	            $stmt1->bindParam(5,$importantLink2);
	            $stmt1->bindParam(6,$videoLink1);
	            $stmt1->bindParam(7,$videoLink2);	            


	            $valid_formats = array("jpg", "png", "gif", "zip", "bmp","pptx","ppt","pdf","docx");
	            $max_file_size = 1024*10000;
				$path = "files/";
				$count = 0;
	            
	            $i = 1;
	            $rename = "";
	            foreach($_FILES['files']['name'] as $f => $name) {     
				    if ($_FILES['files']['error'][$f] == 4) {
				        continue;
				    }	       
				    if ($_FILES['files']['error'][$f] == 0) {	           
				        if ($_FILES['files']['size'][$f] > $max_file_size) {
				            $message[] = "$name is too large!.";
				            continue;
				        } else if(!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
							$message[] = "$name is not a valid format";
							continue;
						} else {
							$rename1 = $max_id."-".$i.".".pathinfo($name, PATHINFO_EXTENSION);
							if($rename == ""){
								$rename = $max_id."-".$i.".".pathinfo($name, PATHINFO_EXTENSION);
							} else {
								$rename .= "_".$max_id."-".$i.".".pathinfo($name, PATHINFO_EXTENSION);
							}
				            if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$rename1)){
				            	$count++;
				            }
				        }
				    }
				    $i++;
				}
				$topic_name			  = $_POST['topic_title'];
	            $batch_id 			  = $_POST['batch_id'];
	            $tdate	 			  = $_POST['tdate'];
	            $topic_file 		  = $rename;
	            $topic_desc 		  = $_POST['topic_desc'];
	            $importantLink1 	  = $_POST['impl1'];
	            $importantLink2 	  = $_POST['impl2'];
	            $videoLink1 		  = $_POST['vdo1'];
	            $videoLink2 		  = $_POST['vdo2'];

	            $stmt->execute();
                $stmt1->execute();
                $id = $conn->lastInsertId();
                $conn->commit();

	            if($id > 0) {
	                echo 'Insertion has been made...';
	            } else {
	                echo "Insertion has not been made...";
	            }
        	} else {
        		echo "Entry already exists...";
        	}
        } catch(PDOException $e){
        	$conn->rollback();
            echo $e->getMessage();
        }
    }

    function isExist($topic_title,$batch_id,$conn){
        $sql = "SELECT * FROM course_topic WHERE topic_name = ? AND batch_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1,$topic_title);
        $stmt->bindParam(2,$batch_id);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }
?>
<form action = "addTopic.php" method = 'post' enctype = 'multipart/form-data'>
<div class="uiForm">
    <div class="row">
        <div class="left">Topic Title</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="topic_title" name="topic_title"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Select Batch</div>
        <div class="middle">:</div>
        <div class="right"><select name = 'batch_id' id = 'batch_id'>
        	<option value = ''>-------------------</option>
        	<?php
        		foreach ($ary as $key => $value) {
        			echo "<option value = '".$key."'>".$value."</option>";
        		}
        	?>
        </select></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Course Name</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="crs_name" name="crs_name" readonly/></div>
        <br class="clear">
    </div>
    
    <div class="row">
        <div class="left">Topic Description</div>
        <div class="middle">:</div>
        <div class="right"><textarea name = 'topic_desc' id = 'topic_desc'></textarea></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">File</div>
        <div class="middle">:</div>
        <div class="right"><input type = 'file' name = 'files[]' id = 'files' multiple = ''></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Date</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" value = '<?php echo date("Y-m-d"); ?>' id="tdate" name="tdate" readonly/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Important Link 1</div>
        <div class="middle">:</div>
        <div class="right"><input type = 'text' name = 'impl1' id = 'impl1'></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Important Link 2</div>
        <div class="middle">:</div>
        <div class="right"><input type = 'text' name = 'impl2' id = 'impl2'></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Video Link 1</div>
        <div class="middle">:</div>
        <div class="right"><input type = 'text' name = 'vdo1' id = 'vdo1'></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Video Link 2</div>
        <div class="middle">:</div>
        <div class="right"><input type = 'text' name = 'vdo2' id = 'vdo2'></div>
        <br class="clear">
    </div>

    <div class="row">
    	<div class="left"></div>
        <div class="middle"></div>
        <div class="right"><input type="submit" value="Save" name = "save"/></div>
        <br class="clear">
    </div>
</div>
</form>
<?php
	include_once("footer.php");
?>

<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			url:"service_sql.php",
			type:'POST',
			dataType:"json",
			data:{action:'getCourseList'},
			success:function(data){
				var course_list = '<?php echo json_encode($course_list); ?>';
				var list = JSON.parse(course_list);
				
				$("#batch_id").change(function(){
					var id = $(this).attr('value');
					$("#crs_name").val(list[data[id]]);
				});
			}
		});
	});
</script>