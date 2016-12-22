<?php
	include_once("header.php");
?>

<div id="PeopleTableContainer" style="width: 600px;"></div>
<?php
	include_once("footer.php");
?>
<script type="text/javascript">
		$(document).ready(function () {

		    //Prepare jTable
			$('#PeopleTableContainer').jtable({
				title: 'Course List',
				paging: true,
				pageSize: 4,
				sorting: true,
				defaultSorting: 'course_name ASC',
				actions: {
					listAction: 'dataActionManager.php?action=list',
					//createAction: 'dataActionManager.php?action=create',
					updateAction: 'dataActionManager.php?action=update',
					deleteAction: 'dataActionManager.php?action=delete'
				},
				fields: {
					id: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					course_name: {
						title: 'Course Name',
						width: '40%'
					},
					catagory_name: {
						title: 'Faculty Name',
						width: '20%',
						options: ''
					}
				}
			});

			//Load person list from server
			$('#PeopleTableContainer').jtable('load');

		});

	</script>