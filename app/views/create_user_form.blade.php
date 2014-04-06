<html>
	<head>
		<title>Create User</title>
	</head>
	
	<body>
		<form action="{{url('user') }}" method="post">
			<label for="email">Email:</label>
			<input type="text" name="email" placeholder="Email" />
			<label for="username">Username:</label>
			<input type="text" name="username" placeholder="Username" />
			<label for="password">Password:</label>
			<input type="password" name="password" placeholder="Password" />
			<label for="warfacts_id">Warfacts Id:</label>
			<input type="number" name="warfacts_id" placeholder="Warfacts_id" />
			<label for="empire">Empire (Empty if none):</label>
			<input type="text" name="empire" placeholder="Empire" />
			<input type="submit" value="Create">
		</form>
	</body>
</html>