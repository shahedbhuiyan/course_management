<?php 
	include_once("header.php");
	include_once("DB.php");
    $conn = DBMgr::getInstance()->getConnection();

    function getInstructorList($conn){
        $sql = "SELECT id,name FROM instructor_info";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $instructor_list_ary = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $id         = $row['id'];
            $name       = $row['name'];

            $instructor_list_ary[$id] = $name;
        }
        return $instructor_list_ary;
    }

    $ary1 = getInstructorList($conn);

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

	$ary = getCourseList($conn);

    if(isset($_POST['save']) && !empty($_POST['save'])){
    	try{
            $sql = "INSERT INTO batch_details (batch_name,course_id,enrollment_key,st_date,instructor_id) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(1,$batch_name);
            $stmt->bindParam(2,$course_id);
            $stmt->bindParam(3,$enrollment_key);
            $stmt->bindParam(4,$st_date);
            $stmt->bindParam(5,$ins_id);

              
            $batch_name             = $_POST['batch_name'];
            $course_id              = $_POST['course_id'];
            $enrollment_key         = $_POST['en_key'];
            $st_date                = $_POST['st_date'];
            $ins_id                 = $_POST['instructor_id'];
                

            $stmt->execute();

            if($conn->lastInsertId() > 0) {
                echo 'Insertion has been made...';
            } else {
                echo "Insertion has not been made...";
            }
        } catch(PDOException $e){
            echo $e->getMessage();
        }
    }
?>

<form action = "addBatch.php" method = 'post'>
<div class="uiForm">
    <div class="row">
        <div class="left">Batch Name</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="batch_name" name="batch_name"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Select Course</div>
        <div class="middle">:</div>
        <div class="right"><select name = 'course_id' id = 'course_id'>
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
        <div class="left">Batch Start</div>
        <div class="middle">:</div>
        <div class="right"><input type="date" id="st_date" name="st_date"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Set EnrollmentKey</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="en_key" name="en_key"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Select Instructor</div>
        <div class="middle">:</div>
        <div class="right">
            <select name = 'instructor_id' id = 'instructor_id'>
                <option value = ''>------------------</option>
                <?php
                    foreach ($ary1 as $key => $value) {
                        echo "<option value = '".$key."'>".$value."</option>";
                    }
                ?>
            </select>
        </div>
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