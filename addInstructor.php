<?php
	include_once("header.php");
    include_once("DB.php");
    $conn = DBMgr::getInstance()->getConnection();

    function getFacultyList($conn){
        $sql = "SELECT id,catagory_name FROM catagory";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $course_list_ary = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $id         = $row['id'];
            $name       = $row['catagory_name'];

            $course_list_ary[$id] = $name;
        }
        return $course_list_ary;
    }

    $ary = getFacultyList($conn);

    if(isset($_POST['save']) && !empty($_POST['save'])){
        if(!isExist($_POST['email'],$conn)){
            try{
                $sql = "INSERT INTO instructor_info (name,email,contact,image,password,fb_id,join_date,faculty_id) VALUES (?,?,?,?,?,?,?,?)";
                $sql1 = "INSERT INTO authentication_info (user_name,password,user_type) VALUES (?,?,?)";


                $conn->beginTransaction();
                //table one
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(1,$name);
                $stmt->bindParam(2,$email);
                $stmt->bindParam(3,$contact);
                $stmt->bindParam(4,$img);
                $stmt->bindParam(5,$pass);
                $stmt->bindParam(6,$fb_id);
                $stmt->bindParam(7,$join_date);
                $stmt->bindParam(8,$faculty_id);

                //table two
                $stmt1 = $conn->prepare($sql1);

                $stmt1->bindParam(1,$email);
                $stmt1->bindParam(2,$pass);
                $stmt1->bindParam(3,$user_type);

                
                
                if((!empty($_FILES["pic"])) && ($_FILES['pic']['error'] == 0)) {
                    $filename = basename($_FILES['pic']['name']);
                    $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                    if (($ext == "jpg") && ($_FILES["pic"]["type"] == "image/jpeg") && ($_FILES["pic"]["size"] < 350000)) {
                        $newname = dirname(__FILE__).'/upload/'.$_POST['contact'].".".$ext;
                        if (!file_exists($newname)) {
                            if ((move_uploaded_file($_FILES['pic']['tmp_name'],$newname))) {
                                $name           = $_POST['name'];
                                $email          = $_POST['email'];
                                $contact        = $_POST['contact'];
                                $fb_id          = $_POST['fb_link'];
                                $faculty_id     = $_POST['faculty_id'];
                                $img            = $contact.".".$ext;
                                $join_date      = $_POST['jdate'];
                                $pass           = $_POST['pass'];
                                $user_type      = "IN";

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
                                echo "Error: A problem occurred during file upload!";
                            }
                        } else {
                            echo "Error: File ".$_FILES["pic"]["name"]." already exists";
                        }
                    } else {
                        echo "Error: Only .jpg images under 350Kb are accepted for upload";
                    }
                } else {
                    echo "Error: No file uploaded";
                }
            } catch(PDOException $e){
                $conn->rollback();
                echo $e->getMessage();
            }
        } else {
            echo "User already exists...";
        }
    }


    function isExist($email,$conn){
        $sql = "SELECT * FROM instructor_info WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1,$email);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }
?>
<form action = "addInstructor.php" method = 'post' enctype='multipart/form-data'>
<div class="uiForm">
    <div class="row">
        <div class="left">Name</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="name" name="name"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Email</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="email" name="email"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Password</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="pass" name="pass"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">ReType Password</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="repass" name="repass"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Contact</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="contact" name="contact"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Facebook Link</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="fb_link" name="fb_link"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Image</div>
        <div class="middle">:</div>
        <div class="right"><input type="file" id="pic" name="pic"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Join Date</div>
        <div class="middle">:</div>
        <div class="right"><input type="date" id="jdate" name="jdate"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Select Faculty</div>
        <div class="middle">:</div>
        <div class="right">
            <select name = 'faculty_id' id = 'faculty_id'>
                <option value = ''>----------</option>
                <?php
                    foreach (@$ary as $key => $value) {
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