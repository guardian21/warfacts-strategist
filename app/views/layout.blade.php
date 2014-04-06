<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Warring Factions Strategist</title>
		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
	</head>

	<body>
		<div class="container">
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					<a href="{{ action('FleetsController@show') }}" class="navbar-brand"> Fleets List </a>
				</div>
			</nav>
		@yield('content')
		</div>
	</body>
</html>