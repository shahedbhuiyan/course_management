<?php
	include_once("header.php");
    include_once("DB.php");
    $conn = DBMgr::getInstance()->getConnection();
    if(isset($_POST['save']) && !empty($_POST['save'])){
        $sql = "SELECT * FROM authentication_info WHERE user_name = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(1,$user_name,PDO::PARAM_STR);
        $stmt->bindParam(2,$password,PDO::PARAM_STR);
        

        $user_name          = $_POST['email'];
        $password           = $_POST['pass'];

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $numRows = $stmt->rowCount();
        if($numRows == 1){
            if(!session_id()) session_start();
            $_SESSION['uID']        = $row['user_name'];
            $_SESSION['uType']      = $row['user_type'];
            if($_SESSION['uType'] == "IN"){
                $sql = "SELECT id FROM instructor_info WHERE email = ?";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(1,$_SESSION['uID'],PDO::PARAM_STR);

                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION['u_ID'] = $row['id'];
            } else if($_SESSION['uType'] == "ST") {
                $sql = "SELECT id FROM student_info WHERE email = ?";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(1,$_SESSION['uID'],PDO::PARAM_STR);

                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION['u_ID'] = $row['id'];   
            }
            header("Location:./index.php");
        } else {
            echo "Invalid Eamil or Passwored..";
        }
    }
?>
<form action = 'login.php' method = 'post'>
<div class="uiForm">
	<div class="row">
    	<div class="left">Email</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="email" name="email" autocomplete = 'off'/></div>
        <br class="clear">
    </div>

    <div class="row">
    	<div class="left">Password</div>
        <div class="middle">:</div>
        <div class="right"><input type="password" id="pass" name="pass" autocomplete = 'off'/></div>
        <br class="clear">
    </div>

    <div class="row">
    	<div class="left"></div>
        <div class="middle"></div>
        <div class="right">Not Registered? <a href = '#'>Click Here</a> || <a href = '#'>Forget Password?</a></div>
        <br class="clear">
    </div>


    <div class="row">
    	<div class="left"></div>
        <div class="middle"></div>
        <div class="right"><input type="submit" value="Save" id="save" name="save"/></div>
        <br class="clear">
    </div>
</div>
</form>
<?php
	include_once("footer.php");
?>