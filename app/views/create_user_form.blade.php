@extends('layout')

@section('content')


		<ul class="errors">
			@foreach($errors->all() as $message)
				<li>{{ $message }}</li>
			@endforeach
		</ul>


		<form action="{{url('user') }}" method="post">
			<div>
				<label for="email">Email:</label>
				<input type="text" name="email" value= {{Input::old('email', 'Email')}} />
			</div>
			<div>
				<label for="username">Username:</label>
				<input type="text" name="username" value={{Input::old('username', "Username")}} />
			</div>
			<div>
				<label for="password">Password:</label>
				<input type="password" name="password" placeholder="Password" />
			</div>
			<div>
				<label for="password_confirmation":> Confirm Password </label>
				<input type="password" name="password_confirmation" placeholder="Confirm Password" />
			</div>
			<div>
				<label for="warfacts_id">Warfacts Id:</label>
				<input type="number" name="warfacts_id" value={{Input::old('warfacts_id', "Warfacts_id")}} />
			</div>
			<div>
				<label for="empire">Empire (Empty if none):</label>
				<input type="text" name="empire" value={{Input::old('empire', "Empire")}} />
			</div>
			<div>
				<label for="faction">Faction</label>
				<input type="text" name="faction" value={{Input::old('faction', "Faction")}} />
			</div>
			<div>
				<input type="submit" value="Create">
		</form>


@stop
