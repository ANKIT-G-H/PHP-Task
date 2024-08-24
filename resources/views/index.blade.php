<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PHP Task</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" >
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<link  href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>PHP-Simple To Do List App</h2>
            </div>
           
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <form action="javascript:void(0)" id="EmployeeForm" name="EmployeeForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="status" id="status" value="Done">
                    <div class="form-group">                        
                            <div class="col-sm-3">
                            <input type="text" class="form-control" id="name" name="name" required="">
                        </div>
                    </div>  
                    <div class="col-sm-6" style="margin-left: 23%;margin-top: -51px;">
                        <button type="submit" class="btn btn-primary" id="btn-save">Add Task</button>
                    </div>

                    
</form>
    <div class="card-body">
        <table class="table table-bordered" id="task">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
 
<!-- boostrap employee model -->

<!-- end bootstrap model -->
<script type="text/javascript">
$(document).ready( function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
 
    $('#task').DataTable({
        processing: true,
        serverSide: true,
        info: false,
        lengthChange: false,
        searching: false,
        bPaginate: false,
        ajax: "{{ url('task') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
       
    });
});
 
function add(){
   
    $('#EmployeeForm').trigger("reset");
    $('#id').val('');
   
  
    
}   
     
function editFunc(id){
    $.ajax({
        type:"POST",
        url: "{{ url('edit') }}",
        data: { id: id },
        dataType: 'json',
        success: function(res){
           
            $('#EmployeeModal').html("Edit Employee");
            $('#id').val(res.id);
            $('#name').val(res.name);
            $('#status').val('Done');
        
        }
    });
}  
 
function deleteFunc(id){
    if (confirm("Delete Record?") == true) {
        var id = id;
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
                var oTable = $('#task').dataTable();
                oTable.fnDraw(false);
            }
        });
    }
}
 
$('#EmployeeForm').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type:'POST',
        url: "{{ url('store')}}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
            $("#employee-modal").modal('hide');
            var oTable = $('#task').dataTable();
            oTable.fnDraw(false);
            $("#btn-save").html('Submit');
            $("#btn-save"). attr("disabled", false);
            $('#EmployeeForm')[0].reset();
            
        },
        error: function(data){
            console.log(data);
        }
    });
});
</script>
</body>
</html>