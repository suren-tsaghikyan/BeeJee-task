<button type="button" class="add_new_task mb-3 mt-3" data-toggle="modal" data-target="#addNewTask">Add A New Task <i class="fas fa-plus-circle"></i></button>
<table id="table_id" class="table table-striped table-bordered"></table>
<script src="assets/js/task.js"></script>

<!-- Modal -->

<div class="modal" id="addNewTask">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add a new task</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         	<div class="form-group">
			    <input type="text" class="form-control" id="username" placeholder="Username">
			</div>
			<div class="form-group">
			    <input type="email" class="form-control" id="email" placeholder="Email Address">
			</div>
			<div class="form-group">
			    <input type="text" class="form-control" id="task" placeholder="Task">
			</div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button id="addNewTaskButton" type="button" class="btn btn-success">Add <i class="fas fa-plus-circle"></i></button>
        </div>
        
      </div>
    </div>
</div>




<!-- Edit modal -->
<div class="modal" id="editTask">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit task</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
			<input type="hidden" class="form-control" id="task_id" placeholder="Username">
         	<div class="form-group">
			    <input type="text" class="form-control" id="taskText" placeholder="Task">
			</div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button id="editTaskButton" type="button" class="btn btn-success">Edit</button>
        </div>
        
      </div>
    </div>
</div>