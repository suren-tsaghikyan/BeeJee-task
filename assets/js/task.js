function Task() {
	const self = this;

	this.tasks   = [],
	this.columns = [],
	this.res,

	this.init = function() {
		this.bindParams();
		this.getTasks();
	},

	this.post = function(data, url) {
		return new Promise((res, rej) => {
			$.ajax({
				type: 'post',
				url: url,
				data: data,
				success: function(r){
					res(r)
				}
			})
		})
	},

	this.getTasks = function() {
		this.post({action: 'getTasks'}, '/getTasks')
		.then(res => {
			res = JSON.parse(res);
			self.res = res.res;
			self.columns = [
				{title: "Username"},
	            {title: "Email"},
	            {title: "Task"},
	            {title: "Status"},
			];
			if(res.login) {
				self.columns.push({title: "Action"});
			}
			res.res.forEach((e, i) => {
				var arr, text
				e.status = e.status == 0 ? 'Pending' : 'Completed';
				e.edited = e.edited == 0 ? '' : '(Edited By Administrator)';
				arr = [e.username, e.email, e.task, e.status+' '+e.edited];
				if(res.login) {
					text = `
						<i title="Edit task's title" class="fas fa-edit editTask" data-id=${i} data-toggle="modal" data-target="#editTask"></i>
						<i title="Complete task" class="fas fa-check-circle completedTask" data-id=${i}></i>
					`
					arr.push(text);
				}
				self.tasks[self.tasks.length] = arr;
			})

			self.createTable();
		})
	},

	this.createTable = function() {
	    $('#table_id').DataTable({
	        "lengthMenu": [[3, 10, 25, 50, -1], [3, 10, 25, 50, "All"]],
	        "lengthChange": false,
	        "searching": false,
	        "bInfo" : false,
	        "pagingType": "full_numbers",
	    	data: self.tasks,
	        columns: self.columns
	    });
	},

	this.isEmail = function(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}

	this.addNewTask = function() {
		var username = $('#username').val(),
			email    = $('#email').val(),
			task     = $('#task').val(),
			check    = {name: false, email: false, task: false};

		if( username == "" ) {
			$('.username_error').css('display', 'none');
			$('#username').css('border', '1px solid red');
			$('#username').before('<span class="username_error" style="color: red">This field is required!</span>');
			check.name = false;
		} else {
			$('#username').css('border', '');
			$('.username_error').css('display', 'none');
			check.name = true;
		}
		if( email == "" ) {
			$('.invalid_email_error').css('display', 'none');
			$('.email_error').css('display', 'none');
			$('#email').css('border', '1px solid red');
			$('#email').before('<span class="email_error" style="color: red">This field is required!</span>');
			check.email = false;
		} else if(!this.isEmail(email)) {
			$('.email_error').css('display', 'none');
			$('.invalid_email_error').css('display', 'none');
			$('#email').css('border', '1px solid red');
			$('#email').before('<span class="invalid_email_error" style="color: red">Invalid email address!</span>');
			check.email = false;
		} else {
			$('#email').css('border', '');
			$('.email_error').css('display', 'none');
			$('.invalid_email_error').css('display', 'none');
			check.email = true;
		}

		if( task == "" ) {
			$('.task_error').css('display', 'none');
			$('#task').css('border', '1px solid red');
			$('#task').before('<span class="task_error" style="color: red">This field is required!</span>');
			check.task = false;
		} else {
			$('#task').css('border', '');
			$('.task_error').css('display', 'none');
			check.task = true;
		}

		if(check.name && check.email && check.task) {
			$.ajax({
				type: 'post',
				url: '/insertNewTask',
				data: {username: username, email: email, task: task},
				success: function(r){
					alert('Your task has been added successfully!');
					window.location.reload();
				}
			})
		}
	},

	this.logout = function() {
		$.ajax({
			type: 'post',
			url: '/logout',
			data: {action: 'logout'},
			success: function(r){
				window.location.href = '/';
			}
		})
	}

	this.setCompleted = function(el) {
		this.post({id: this.res[el.getAttribute('data-id')].id}, '/completedTask')
		.then(res => {
			res = JSON.parse(res);
			alert(res.res);
			window.location.reload();
		})
	},

	this.editTask = function(el) {
		document.getElementById('taskText').value = this.res[el.getAttribute('data-id')].task;
		document.getElementById('task_id').value  = this.res[el.getAttribute('data-id')].id;
	},

	this.editTaskAction = function() {
		var data = {
			task: document.getElementById('taskText').value,
			id: document.getElementById('task_id').value
		};

		this.post(data, '/edetedTask')
		.then(res => {
			res = JSON.parse(res);
			alert(res.res);
			window.location.reload();
		})

	},

	this.bindParams = function() {
		var addTask = document.getElementById('addNewTaskButton');
		var logout = document.getElementById('logout');
		addTask.addEventListener('click', function() {
			self.addNewTask();
		})
		if(logout) {
			logout.addEventListener('click', function() {
				self.logout();
			})
		}

		$(document).on('click', '.completedTask', e => {
			self.setCompleted(e.target);
		})

		$(document).on('click', '.editTask', e => {
			self.editTask(e.target);
		})

		$('#editTaskButton').click(el => {
			this.editTaskAction();
		})
	}
}

$(document).ready(function () {
	var task = new Task(); 
	task.init();
})