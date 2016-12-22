<?php
	if(!session_id()) session_start();
	include_once("DB.php");
    $conn = DBMgr::getInstance()->getConnection();

	function getCourseIDList($conn){
		$sql = "SELECT id,course_id FROM batch_details WHERE instructor_id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1,$_SESSION['u_ID']);
		$stmt->execute();

		$courseID_list_ary = [];

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$id 			= $row['id'];
			$course_id 		= $row['course_id'];

			$courseID_list_ary[$id] = $course_id;
		}
		return $courseID_list_ary;
	}

	function getTopicList($conn){
		$sql = "SELECT id,topic_name,batch_id,class_no FROM course_topic";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$topic_list_ary = [];
		$i = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$id = $row['id'];
			$topic_name = $row['topic_name'];
			$batch_id = $row['batch_id'];
			$class_no = $row['class_no'];

			$topic_list_ary[$i] = array("tid"=>$id,"topic_name"=>$topic_name,"batch_id"=>$batch_id,"class_no"=>$class_no);
			$i++;
		}
		return $topic_list_ary;
	}

	function getCourseTitleList($conn){
		$sql = "SELECT c.course_name,b.id FROM course c, batch_details b WHERE c.id = b.course_id";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$courseListAry = [];
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$courseListAry[$row['id']] = $row['course_name'];
		}
		return $courseListAry;
	}

	function getTopicListDetails($conn,$batch_id){
		$sql = "SELECT c.topic_name,c.tdate,c.class_no,c.batch_id,t.topic_desc,t.topic_file,t.importantLink1,t.importantLink2,t.videoLink1,t.videoLink2 FROM course_topic c, topic_content t WHERE c.id = t.course_topic_id AND c.batch_id = ? ORDER BY c.class_no DESC";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1,$batch_id);
		$stmt->execute();
		$str = "";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$str .= "<tr class = 'header'>";
				$str .= "<th align = 'left' style = 'padding-left:20px;border-bottom-left-radius:10px;border-top-left-radius:10px'>Topic Name</th>";
				$str .= "<td>:</td>";
				$str .= "<th align = 'left'>".$row['topic_name']."</th>";
				$str .= "<th>Class No</th>";
				$str .= "<td>:</td>";
				$str .= "<td width = '50'>".$row['class_no']."<sup>nd</sup></td>";
				$str .= "<th>Batch Name</th>";
				$str .= "<td>:</td>";
				$str .= "<th style = 'padding-right:20px;border-bottom-right-radius:10px;border-top-right-radius:10px'>".getBatchName($conn,$row['batch_id'])."</th>";
			$str .= "</tr>";

			$str .= "<tr>";
				$str .= "<th colspan = '9' align = 'left'>Topic Description</th>";
			$str .= "</tr>";

			$str .= "<tr>";
				$str .= "<td colspan = '9'>".$row['topic_desc']."</td>";
			$str .= "</tr>";

			$ary = explode("_", $row['topic_file']);
			foreach($ary as $key=>$value){
				$str .= "<tr>";
					$str .= "<td colspan = '9'><a href = '#'>files/".$ary[$key]."</a></td>";
				$str .= "</tr>";
			}

			$str .= "<tr>";
				$str .= "<th>Important Link 1 : </th>";
				$str .= "<td colspan = '8'>".$row['importantLink1']."</td>";
			$str .= "</tr>";

			$str .= "<tr>";
				$str .= "<th>Important Link 2 : </th>";
				$str .= "<td colspan = '8'>".$row['importantLink2']."</td>";
			$str .= "</tr>";

			$str .= "<tr>";
				$str .= "<td colspan = '9'><iframe width='400' height='200' src='".$row['videoLink1']."' frameborder='0' allowfullscreen></iframe></td>";
			$str .= "</tr>";

			$str .= "<tr>";
				$str .= "<td colspan = '9'><iframe width='400' height='200' src='".$row['videoLink2']."' frameborder='0' allowfullscreen></iframe></td>";
			$str .= "</tr>";

			$str .= "<tr height = '30'></tr>";
		}
		return $str;
	}

	function getBatchName($conn,$batch_id){
		$sql = "SELECT batch_name FROM batch_details WHERE id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id',$batch_id,PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC)['batch_name'];
	}


	if($_POST['action'] == 'getCourseList'){
		echo json_encode(getCourseIDList($conn));
	} else if($_POST['action'] == 'getTopicList'){
		echo json_encode(getTopicList($conn));
	} else if($_POST['action'] == "getCourseTitle"){
		echo json_encode(getCourseTitleList($conn));
	} else if($_POST['action'] == "getTopicListDet"){
		$batch_id = $_POST['batch_id'];
		echo getTopicListDetails($conn,$batch_id);
	}

	?>

