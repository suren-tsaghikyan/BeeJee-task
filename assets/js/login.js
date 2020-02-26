function Login() {
	const self = this;

	this.init = function() {
		this.bindParams();
	},

	this.login = function() {
		var username = $('#username_login').val(),
			password = $('#password_login').val(),
			check    = {username: false, password: false};

		if( username == "" ) {
			$('.username_error').css('display', 'none');
			$('#username_login').css('border', '1px solid red');
			$('#username_login').before('<span class="username_error" style="color: red">This field is required!</span>');
			check.username = false;
		} else {
			$('#username_login').css('border', '');
			$('.username_error').css('display', 'none');
			check.username = true;
		}
		if( password == "" ) {
			$('.password_error').css('display', 'none');
			$('#password_login').css('border', '1px solid red');
			$('#password_login').before('<span class="password_error" style="color: red">This field is required!</span>');
			check.password = false;
		} else {
			$('#password_login').css('border', '');
			$('.password_error').css('display', 'none');
			check.password = true;
		}

		if(check.username && check.password) {
			$.ajax({
				type: 'post',
				url: '/login',
				data: {username: username, password: password},
				success: function(r){
					if(r == 'false') {
						$('.username_error').css('display', 'none');
						$('#username_login').before('<span class="incorrect" style="color: red">Username or password is incorrect!</span>');
					} else {
						$('.incorrect').css('display', 'none');
						window.location.href = '/';
					}
				}
			})
		}

	}

	this.bindParams = function() {
		var login_btn = document.getElementById('login-button');

		login_btn.addEventListener('click', function() {
			self.login();
		})
	}
}

$(document).ready(function () {
	var login = new Login(); 
	login.init();
})