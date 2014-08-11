@extends('layouts.default')

@section('content')
	<div class="page">
		<h1>Sign In</h1>
		<div class="form">
			{{ Form::open(['route' => 'login']) }}
				@if (isset($username))
					{{ Form::text('username', $username, ['placeholder' => 'Username']); }}
				@else
					{{ Form::text('username', NULL, ['placeholder' => 'Username']); }}
				@endif
				{{ Form::password('password', ['placeholder' => 'Password']); }}
				{{ Form::submit('Sign In') }}
			{{ Form::close() }}
		</div>
		<div class="center">
			{{ link_to_route('forgotpw', 'Forgot Password') }}
		</div>
	</page>
@stop