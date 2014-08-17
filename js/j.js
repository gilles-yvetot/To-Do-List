
$(document).ready(function(){
	$('#datetimepicker').datetimepicker();
});

function showForm(){
	$('#form').css('display','block');
}

function toggleId(id){
	$('#'+id).toggleClass('inlBl');
}

function addTask(){
	var taskName='',dueDate='',priority='';
	
	taskName =$('#taskName').val();
	if($('#datetimepicker').css('display') != 'none' && $('#datetimepicker').val())
		dueDate =$('#datetimepicker').val();
	if($('#selPrio').css('display') != 'none' && $('#selPrio').val())
		priority =$('#selPrio').val();
	if(taskName){
		$.post('actions/addTask.php', { task:taskName, dueOn:dueDate, prio:priority }, 
			function(data) {
				var arr = JSON.parse(data);
				if (arr && Array.isArray(arr) && arr.length==0)){

				}
			});
	}
}

function insertTaskInTable(task){
	$('')
}