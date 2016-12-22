<?php
	if(!session_id()) session_start();
	
?>
<div id="menu">
            	<div class="menu_item"><a href="index.php">Home</a></div>
            	<?php 
            		if(!isset($_SESSION['uID']) && empty($_SESSION['uID'])) {
            	?>
                <div class="menu_item"><a href="registration.php">SignUp</a></div>
                <div class="menu_item"><a href="login.php">LogIn</a></div>
                <?php
                	} 

                	if(isset($_SESSION['uID']) && $_SESSION['uType'] == "AD") {
                ?>
                <div class="menu_item"><a href="addInstructor.php">Create Instructor</a></div>
                <div class="menu_item"><a href="addFaculty.php">Create Faculty</a></div>
                <div class="menu_item"><a href="addCourse.php">Create Course</a></div>
                <div class="menu_item"><a href="addBatch.php">Create Batch</a></div>
                <div class="menu_item"><a href="student_list.php">Students List</a></div>
                <div class="menu_item"><a href="#">Students Progress</a></div>
                <div class="menu_item"><a href="viewCourses.php">View Course</a></div>
                <div class="menu_item"><a href="logout.php">LogOut</a></div>
                <?php 
                	}
                	if(isset($_SESSION['uID']) && $_SESSION['uType'] == "ST") {
                ?>
                <div class="menu_item"><a href="#">View Profile</a></div>
                <div class="menu_item"><a href="#">Change Password</a></div>
                <div class="menu_item"><a href="#">View Course</a></div>
                <div class="menu_item"><a href="#">Exam</a></div>
                <div class="menu_item"><a href="logout.php">LogOut</a></div>
                <?php
                	}
                	if(isset($_SESSION['uID']) && $_SESSION['uType'] == "IN") {
                ?>
                <div class="menu_item"><a href="viewInsProfile.php">View Profile</a></div>
                <div class="menu_item"><a href="#">Change Password</a></div>
                <div class="menu_item"><a href="viewCourses.php">View Course</a></div>
                <div class="menu_item"><a href="#">Student List</a></div>
                <div class="menu_item"><a href="#">Student Results</a></div>
                <div class="menu_item"><a href="addTopic.php">Create Topic</a></div>
                <div class="menu_item"><a href="viewTopic.php">View Topic</a></div>
                <div class="menu_item"><a href="createQuestion.php">Create Question</a></div>
                <div class="menu_item"><a href="#">View Question</a></div>
                <div class="menu_item"><a href="logout.php">LogOut</a></div>
                <?php
                	}
                ?>
            </div>