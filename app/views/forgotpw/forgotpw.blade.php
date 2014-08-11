@extends('layouts.default')

@section('content')
	<div class="page">
		<h1>Forgot Password</h1>
		We don't store your password on our server, but we can ask Ranger to email it to you.
		<div class="form">
			{{ Form::open(['route' => 'forgotpw']) }}
				{{ Form::email('email', NULL, ['placeholder' => 'Email Address']); }}
				{{ Form::submit('Send Email') }}
			{{ Form::close() }}
		</div>
	</div>
@stop