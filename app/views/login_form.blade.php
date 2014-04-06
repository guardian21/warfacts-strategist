<html>
	<head>
		<title>Login</title>
	</head>

	<body>
		<form action="{{ url('login') }}" method="post">
		<label for="username">Username:</label>
		<input type="text" name="username" placeholder="Username" />
		<label for="password">Password:</label>
		<input type="password" name="password" placeholder="Password" />
		<input type="submit" value="Login">
		<input type="checkbox" name="remember" /> <label for="remember">Remember me.</label>
		</form>
	</body>
</html>
