<!DOCTYPE html>
<html>
	<head>
		<title>rtRanger</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
		<link rel="apple-touch-icon" href="/assets/images/icon.png"/>
		<!--[if lt IE 7]>
		<style media="screen" type="text/css">
		#container {
			height:100%;
		}
		</style>
		<![endif]-->
	</head>
	<body>

		<div id="container">

			<div id="header">
				<div class="logo">
					<a href="/">odp</a>
				</div>

				<div class="menu">
					<img src="/assets/images/menu.png" alt="" />
				</div>
			</div>

			@if (isset($data['navigation']))
				<div id="navigation">
					<ul>
						@foreach ($data['navigation'] as $route => $link)
							@if (!empty($link['selected']))
								<li class="selected">
							@else
								<li>
							@endif
								{{ link_to_route($route, $link['name']) }}
							</li>
						@endforeach
					</ul>
				</div>
			@endif

			<div id="content">
				@include('flash::message')
				@yield('content')
			</div>

			<div id="footer">
				footer
			</div>
			<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/functions.js"></script>
		</div>

	</body>

</html>