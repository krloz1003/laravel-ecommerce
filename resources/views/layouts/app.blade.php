<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
	<script type="text/javascript">
		window.Laravel = {			
			"baseUrl": "{{ url('') }}"
		}
	</script>
	<script src="{{ asset('js/app.js') }}" defer></script>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<v-app id="app">
			<v-app-bar app>
				<v-btn icon href="{{ url('') }}" >
					<v-icon>storefront</v-icon>
				</v-btn>
				<v-toolbar-title>{{ env('APP_NAME') }}</v-toolbar-title>
				<v-spacer></v-spacer>
    			
    			<v-tooltip bottom>
	      			<template v-slot:activator="{ on, attrs }">
						<v-btn icon v-bind="attrs" v-on="on" href="{{ url('products') }}" >
							<v-icon>shopping_bag</v-icon>
						</v-btn>	      				
	      			</template>
	      			<span>Products</span>
    			</v-tooltip>

    			<v-tooltip bottom>
	      			<template v-slot:activator="{ on, attrs }">
						<v-btn icon v-bind="attrs" v-on="on">
							<v-icon>people</v-icon>
						</v-btn>	      				
	      			</template>
	      			<span>Users</span>
    			</v-tooltip>
				
    			<v-tooltip bottom>
	      			<template v-slot:activator="{ on, attrs }">
						<v-btn icon v-bind="attrs" v-on="on">
							<v-icon>shopping_cart</v-icon>
						</v-btn>	      				
	      			</template>
	      			<span>Cart</span>
    			</v-tooltip>

    			<v-tooltip bottom>
	      			<template v-slot:activator="{ on, attrs }">
						<v-btn icon v-bind="attrs" v-on="on">
							<v-icon>logout</v-icon>
						</v-btn>	      				
	      			</template>
	      			<span>Logout</span>
    			</v-tooltip>

			</v-app-bar>
		<v-main>			
			@yield('content')
		</v-main>
	</v-app>
	{{--<div id="app">

		
		<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
			<div class="container">
				<a class="navbar-brand" href="{{ url('/') }}">
					{{ config('app.name', 'Laravel') }}
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav mr-auto">

					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ml-auto">
						<!-- Authentication Links -->
						@guest
							<li class="nav-item">
								<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
							</li>
							@if (Route::has('register'))
								<li class="nav-item">
									<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
								</li>
							@endif
						@else
							<li class="nav-item dropdown">
								<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
									{{ Auth::user()->name }}
								</a>

								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="{{ route('logout') }}"
									   onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
										@csrf
									</form>
								</div>
							</li>
						@endguest
					</ul>
				</div>
			</div>
		</nav>

	</div>--}}
</body>
</html>
