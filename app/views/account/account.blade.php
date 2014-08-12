@extends('layouts.default')

@section('content')
	<div class="game">
		{{ Form::open(['route' => 'account']) }}

			<div class="section">
				<h1>My Account</h1>
				<h2>Home Base</h2>
				<div class="label">
					We can calculate how long it will take to drive to your games, just enter your home zip code below.
				</div>
				<div class="form">
					{{ Form::input('number', 'base', $data['user']['base'], ['placeholder' => 'Home Base', 'max' => 99999]); }}
				</div>
			</div>

			<div class="section">
				<h2>Notifications</h2>
				<div class="label">
					To be notified of upcoming games, enter your cell phone number and carrier and we'll send you a text message the day before your game.
				</div>
				<div class="form">
					{{ Form::input('number', 'cell_number', $data['user']['cell_number'], ['placeholder' => 'Phone Number', 'max' => 9999999999]) }}
					{{ Form::select('cell_carrier', [
						'txt.att.net' => 'AT&T',
						'cingularme.com' => 'Cingular',
						'messaging.sprintpcs.com' => 'Sprint',
						'tmomail.net' => 'T-Mobile',
						'vtext.com' => 'Verizon',
						'vmobl.com' => 'Virgin'
					], $data['user']['cell_carrier'])}}
					<div class="small">Don't see your carrier? <a href="#">Contact us</a></div>
				</div>
			</div>

			<div class="form">
				{{ Form::submit('Save') }}
			</div>

		{{ Form::close() }}
	</div>
@stop