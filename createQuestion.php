<?php
	if (!session_id()) session_start();
	include_once("header.php");
	include_once("DB.php");
    $conn = DBMgr::getInstance()->getConnection();

    function getBatchList($conn){
		$sql = "SELECT id,batch_name FROM batch_details WHERE instructor_id = '".$_SESSION['u_ID']."'";
		$stmt = $conn->prepare($sql);
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

    function generateID($conn){
        $sql = "SELECT MAX(id) as max_id FROM question";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['max_id'] + 1;
    }

    if(isset($_POST['save']) && !empty($_POST['save'])){
        $max_id             = generateID($conn);
        if(!isExist($_POST['batch_id'],$max_id,$_POST['question'],$conn)){
            try{
                $sql = "INSERT INTO question (id,batch_id,question,question_desc,course_topic_id) VALUES (?,?,?,?,?)";
                $sql1 = "INSERT INTO answer (question_id,answer) VALUES (?,?)";
                $conn->beginTransaction();

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1,$max_id);
                $stmt->bindParam(2,$batch_id);
                $stmt->bindParam(3,$question);
                $stmt->bindParam(4,$question_desc);
                $stmt->bindParam(5,$course_topic_id);

                
                $batch_id           = $_POST['batch_id'];
                $course_topic_id    = $_POST['topic_id'];
                $question           = $_POST['question'];
                $question_desc      = $_POST['question_desc'];

                foreach ($_POST['ans_opt'] as $key => $answer) {
                    $stmt1 = $conn->prepare($sql1);
                    $stmt1->bindParam(1,$max_id);
                    $stmt1->bindParam(2,$answer);
                    $stmt1->execute();
                }

                $stmt->execute();
                $conn->commit();

                if($stmt){
                    echo "Insert data Successfully..";
                } else {
                    echo "Insertion failed...";
                }
            } catch(PDOException $e){
                $conn->rollback();
                echo $e->getMessage();
            }
        } else {
            echo "Data already exists..";
        }
    }

    function isExist($batch_id,$question_id,$question,$conn){
        $sql = "SELECT * FROM question WHERE id = ? AND batch_id = ? OR question = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1,$question_id);
        $stmt->bindParam(2,$batch_id);
        $stmt->bindParam(3,$question);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }
?>
<form action = "createQuestion.php" method = 'post'>
<table>
    <tr>
        <td>Select Batch</td>
        <td>:</td>
        <td><select name = 'batch_id' id = 'batch_id'>
            <option value = ''>-------------</option>
            <?php
                foreach ($ary as $key => $value) {
                    echo "<option value = '".$key."'>".$value."</option>";
                }
            ?>
            </select>
        </td>
        <td>Select Topic</td>
        <td>:</td>
        <td><select name = 'topic_id' id = 'topic_id'>
            <option value = ''>-------------</option>
        </select></td>
        <td>Class No</td>
        <td>:</td>
        <td><input type = 'text' name = 'class_no' id = 'class_no' readonly></td>
    </tr>
</table>
<div class="uiForm">
    <div class="row">
        <div class="left">Question</div>
        <div class="middle">:</div>
        <div class="right"><input type="text" id="question" name="question"/></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Question Description</div>
        <div class="middle">:</div>
        <div class="right"><textarea name = 'question_desc' id = 'question_desc' style = 'width:225px; height:150px'></textarea></div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Answer Option 1</div>
        <div class="middle">:</div>
        <div class="right">
            <input type = 'text' name = 'ans_opt[]' id = 'ans_opt_1'/>
        </div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Answer Option 2</div>
        <div class="middle">:</div>
        <div class="right">
            <input type = 'text' name = 'ans_opt[]' id = 'ans_opt_2'/>
        </div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Answer Option 3</div>
        <div class="middle">:</div>
        <div class="right">
            <input type = 'text' name = 'ans_opt[]' id = 'ans_opt_3'/>
        </div>
        <br class="clear">
    </div>

    <div class="row">
        <div class="left">Answer Option 4</div>
        <div class="middle">:</div>
        <div class="right">
            <input type = 'text' name = 'ans_opt[]' id = 'ans_opt_4'/><input type = 'button' id = 'plus' value = '+' style = 'width:40px'>
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
<script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url:"service_sql.php",
            type:"POST",
            dataType:"json",
            data:{action:'getTopicList'},
            success:function(data){
                $("#batch_id").change(function(){
                    var val = $(this).attr("value");
                    var str = "";
                    var nJSON = [];
                    for(var key in data){
                        if(data[key].batch_id == val){
                            nJSON.push({
                                "tid":data[key].tid,"batch_id":data[key].batch_id,"topic_name":data[key].topic_name,"class_no":data[key].class_no
                            });
                        }
                    }
                    for(var l = nJSON.length - 1; l>=0; l--){
                        if(l == nJSON.length - 1){
                            $("#class_no").val(nJSON[l].class_no);
                        }
                        str += "<option value = '"+nJSON[l].tid+"'>"+nJSON[l].topic_name+"</option>";
                    }
                    $("#topic_id").html(str);

                    $("#topic_id").change(function(){
                        var tid = $(this).attr('value');
                        for(var j in nJSON){
                            if(tid == nJSON[j].tid){
                                $("#class_no").val(nJSON[j].class_no);
                            }
                        }
                    });
                });
            }
        });
    });
</script>