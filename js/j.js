
$(document).ready(function(){
	$('.datetimepicker').datetimepicker();
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
		$.post('Controllers/addTask.php', { task:taskName, dueOn:dueDate, prio:priority }, 
			function(data) {	
				if (data){	insertTaskInTable(data);	}
			}
		);
	}
}

function editTask(e,id){
	e = (e) ? e : window.event;
	var src = e.srcElement || e.target;
	src.parentNode.parentNode.innerHTML;
	var cells = src.parentNode.parentNode.cells;
	cells[0].innerHTML = '<input type="text" value="'+cells[0].innerHTML+'">';
	cells[1].innerHTML = createPriorityInput(cells[1].innerHTML);
	cells[2].innerHTML = '<input type="text" '
						+((cells[2].innerHTML!='No due date')?'value="'+cells[2].innerHTML+'"':'')
						+' class="datetimepicker">';
	cells[3].innerHTML = '<button onclick="updateTask(event,'+id+');">Update</button>';
	try{$('.datetimepicker').datetimepicker();}catch(e){};
}
function createPriorityInput(val){
	return "<select><option value='1' "+((val=='Very High')?'selected':'')+">Very High</option>"
			+"<option value='2' "+((val=='High')?"selected":"")+">High</option>"
			+"<option value='3' "+((val=='Kind of Important')?"selected":"")+">Kind of Important</option>"
			+"<option value='4' "+((val=='Low')?"selected":"")+">Low</option>"
			+"<option value='5' "+((val=='Very Low')?"selected":"")+">Very Low</option>"
		+"</select>";
}

function deleteTask(id){
	var r = confirm("Are you sure you want to delete this task?");
	if (r == true) {
	}
}

function markAsDone(e,rowId){
	e = (e) ? e : window.event;
	var src = e.srcElement || e.target;
	$.post('Controllers/editTask.php', { status:'Done',id:rowId }, 
		function(data) {	
			if (data){
				src.parentNode.parentNode.parentNode.removeChild(src.parentNode.parentNode);
				insertTaskInTable(data);
			}
		}
	);
}
function markAsNotDone(e,rowId){
	e = (e) ? e : window.event;
	var src = e.srcElement || e.target;
	$.post('Controllers/editTask.php', { status:'Not Done',id:rowId }, 
		function(data) {	
			if (data){
				src.parentNode.parentNode.parentNode.removeChild(src.parentNode.parentNode);
				insertTaskInTable(data);
			}
		}
	);
}

function updateTask(e,rowId){
	e = (e) ? e : window.event;
	var src = e.srcElement || e.target;
	var cells = src.parentNode.parentNode.cells;
	var taskName = cells[0].childNodes[0].value;
	var priority = cells[1].childNodes[0].options[cells[1].childNodes[0].selectedIndex].value;
	var dueOn = cells[2].childNodes[0].value;
	$.post('Controllers/editTask.php', { task:taskName, prio:priority, dueDate:dueOn ,id:rowId }, 
		function(data) {	
			if (data){
				src.parentNode.parentNode.parentNode.removeChild(src.parentNode.parentNode);
				insertTaskInTable(data);
			}
		}
	);
}

function insertTaskInTable(taskString){
	
	if(taskString.indexOf('markAsDone')>0)
	{
		$('#taskList table').first().find('tr').last().after(taskString);
		sortTable($('#taskList table').first().get()[0],taskString);
	}
	else
	{
		$('#taskList table').last().find('tr').last().after(taskString);
		sortTable($('#taskList table').last().get()[0],taskString);
	}
}

function sortTable(table, taskString){
	var rows = table.rows;
	var arr = [], i, j, cells;
    // 2-dimensions array filled with the table cells values
    for (i = 1; i < rows.length; i++) { // we start after the table headers
        cells = rows[i].cells;
        arr[i] = [];
        for (j = 0; j < 4; j++) { // 4 columns 
            arr[i][j] = cells[j].innerHTML;
        }
    }
    // sort the array by the column number #2 (due date column)
    arr.sort(function (a, b) {
    	if (a[2] == b[2])		return a[1]-b[1]; // if the due date is the same, we sort by priority
    	else if (a[2] > b[2]) 	return 1;
    	else 					return -1;
    });
    // replace rows by the one created
    for (i = 1; i < rows.length; i++) {
        rows[i].innerHTML = "<td>" + arr[i-1].join("</td><td>") + "</td>";
        if(rows[i].innerHTML== taskString.slice(4,-5))
        	rows[i].className='newRow';
    }
}


