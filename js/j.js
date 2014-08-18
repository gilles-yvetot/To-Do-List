
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
		$.post('Controllers/addTask.php', { task:taskName, dueOn:dueDate, prio:priority }, 
			function(data) {	
				if (data){	insertTaskInTable(data);	}
			}
		);
	}
}

function insertTaskInTable(taskString){
	// insert the new row
	$('#taskList table tr').last().after(taskString);
	// sort the table
	var rows = $('#taskList table').first().get()[0].rows;
	var arr = [], i, j, cells;
    // 2-dimensions array filled with the table cells values
    for (i = 1; i < rows.length; i++) { // we start after the table headers
        cells = rows[i].cells;
        arr[i] = [];
        for (j = 0; j < 3; j++) { // 3 columns 
            arr[i][j] = cells[j].innerText;
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
        rows[i].innerHTML = "<td>" + arr[i-1].join("</td><td>") + "<td></td></td>";
        if(rows[i].innerHTML== taskString.slice(4,-5))
        	rows[i].className='newRow';
    }

}