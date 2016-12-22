<?php 
	include_once("header.php");
	include_once("DB.php");
    $conn = DBMgr::getInstance()->getConnection();


    function getCatagoryList($conn){
		$sql = "SELECT id,catagory_name FROM catagory";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$catagory_list_ary = [];

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$id 		= $row['id'];
			$name 		= $row['catagory_name'];

			$catagory_list_ary[$id] = $name;
		}
		return $catagory_list_ary;
	}

	$ary = getCatagoryList($conn);

    if(isset($_POST['save']) && !empty($_POST['save'])){
    	try{
            $sql = "INSERT INTO course (course_name,catagory_id) VALUES (?,?)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(1,$course_name);
            $stmt->bindParam(2,$cata_id);
              
            $course_name          = $_POST['course_name'];
            $cata_id 			  = $_POST['faculty_id'];
                

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

<form action = "addCourse.php" method = 'post'>
<div class="uiForm">
    <div class="row">
        <div class="left">Course Name</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="course_name" name="course_name"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Select Faculty</div>
        <div class="middle">:</div>
        <div class="right"><select name = 'faculty_id' id = 'faculty_id'>
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