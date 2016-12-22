<?php
	include_once("header.php");
    include_once("DB.php");
    $conn = DBMgr::getInstance()->getConnection();

    if(isset($_POST['save']) && !empty($_POST['save'])){
        if(isExist($_POST['email'])){
            try{
                $sql = "INSERT INTO student_info(name,email,contact,gender,occupation,image,address,password) VALUES (?,?,?,?,?,?,?,?)";
                $sql1 = "INSERT INTO authentication_info (user_name,password,user_type) VALUES (?,?,?)";

                $conn->beginTransaction();

                $stmt = $conn->prepare($sql);

                $stmt->bindParam(1,$name);
                $stmt->bindParam(2,$email);
                $stmt->bindParam(3,$contact);
                $stmt->bindParam(4,$gender);
                $stmt->bindParam(5,$occu);
                $stmt->bindParam(6,$img);
                $stmt->bindParam(7,$address);
                $stmt->bindParam(8,$pass);

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
                                $gender         = $_POST['gender'];
                                $occu           = $_POST['occu'];
                                $img            = $contact.".".$ext;
                                $address        = $_POST['address'];
                                $pass           = $_POST['pass'];
                                $user_type      = "ST";

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


    function isExist(){

    }
?>
<form action = "registration.php" method = 'post' enctype='multipart/form-data'>
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
        <div class="left">Gender</div>
        <div class="middle">:</div>
        <div class="right"><select name = 'gender' id = 'gender'><option value = ''>-----</option><option value = 'M'>Male</option><option vlaue = 'F'>Female</option></select></div>
        <br class="clear">
    </div>
    
    <div class="row">
        <div class="left">Occupation</div>
        <div class="middle">:</div>
        <div class="right"><select name = 'occu' id = 'occu'><option value = ''>-----</option><option value = 'ST'>Student</option><option vlaue = 'SE'>Service Holder</option></select></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Address</div>
        <div class="middle">:</div>
        <div class="right"><textarea name = 'address' id = 'address'></textarea></div>
        <br class="clear">
    </div>  

    <div class="row">
        <div class="left">Image</div>
        <div class="middle">:</div>
        <div class="right"><input type="file" id="pic" name="pic"/></div>
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