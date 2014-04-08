{{--TODO When validation errors repopulate fields with previous values --}}

<html>
	<head>
		<title>Create User</title>
	</head>
	
	<body>

		<ul class="errors">
			@foreach($errors->all() as $message)
				<li>{{ $message }}</li>
			@endforeach
		</ul>


		<form action="{{url('user') }}" method="post">
			<label for="email">Email:</label>
			<input type="text" name="email" value= {{Input::old('email', 'Email')}} />
			<label for="username">Username:</label>
			<input type="text" name="username" value={{Input::old('username', "Username")}} />
			<label for="password">Password:</label>
			<input type="password" name="password" placeholder="Password" />
			<label for="password_confirmation":> Confirm Password </label>
			<input type="password" name="password_confirmation" placeholder="Confirm Password" />
			<label for="warfacts_id">Warfacts Id:</label>
			<input type="number" name="warfacts_id" value={{Input::old('warfacts_id', "Warfacts_id")}} />
			<label for="empire">Empire (Empty if none):</label>
			<input type="text" name="empire" value={{Input::old('empire', "Empire")}} />
			<label for="faction">Faction</label>
			<input type="text" name="faction" value={{Input::old('faction', "Faction")}} />
			<input type="submit" value="Create">
		</form>
	</body>
</html>