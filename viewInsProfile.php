<?php
	if(!session_id()) session_start();
	include_once("header.php");
	include_once("DB.php");
	$conn = DBMgr::getInstance()->getConnection();

	$sql = "SELECT i.id,i.name,i.email,i.contact,i.fb_id,i.image,i.join_date,f.catagory_name FROM instructor_info i, catagory f WHERE i.faculty_id = f.id AND i.email = ?";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(1,$_SESSION['uID']);

	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="uiForm">
    <div class="row">
        <div class="left">Name</div>
        <div class="middle">:</div>
        <div class="right"><?php echo $row['name'] ?></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Email</div>
        <div class="middle">:</div>
        <div class="right"><?php echo $row['email']; ?></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Contact</div>
        <div class="middle">:</div>
        <div class="right"><?php echo $row['contact']; ?></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Join Date</div>
        <div class="middle">:</div>
        <div class="right"><?php echo $row['join_date']; ?></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Faculty</div>
        <div class="middle">:</div>
        <div class="right"><?php echo $row['catagory_name']; ?></div>
        <br class="clear">
    </div>
    <div class="row">
        <div class="left">Facebook Link</div>
        <div class="middle">:</div>
        <div class="right"><?php echo $row['fb_id']; ?></div>
        <br class="clear">
    </div>
</div>

<?php
	include_once("footer.php");
?>