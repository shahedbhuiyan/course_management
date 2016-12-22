<?php 
	include_once("header.php");
	include_once("DB.php");
    $conn = DBMgr::getInstance()->getConnection();

    if(isset($_POST['save']) && !empty($_POST['save'])){
    	try{
            $sql = "INSERT INTO catagory (catagory_name) VALUES (?)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(1,$cata_name);
              
            $cata_name          = $_POST['faculty'];
                

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

<form action = "addFaculty.php" method = 'post'>
<div class="uiForm">
    <div class="row">
        <div class="left">Faculty Name</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="faculty" name="faculty"/></div>
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