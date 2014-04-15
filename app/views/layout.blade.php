<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Warring Factions Strategist</title>
		<link rel="stylesheet" href="{{ asset('packages/bootstrap/css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/css/general.css') }}" />
		@yield('head')

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