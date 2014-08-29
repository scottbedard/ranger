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
					{{ Form::input('tel', 'base', $data['user']['base'], ['placeholder' => 'Home Base']); }}
				</div>
			</div>

			<?php
			/**
			 * Due to other projects, I don't have time to flesh out this functionality right now.
			 * The plan is to set up a cron that will email your carriers sms forwarder, so that
			 * the user gets a text message with information such as the rink address, travel time,
			 * partners phone numbers, etc..
			 *
			 * If anyone reading this feels like writing this, please go right ahead!
			 */
			/*
			<div class="section">
				<h2>Notifications</h2>
				<div class="label">
					To be notified of upcoming games, enter your cell phone number and carrier and we'll send you a text message the day before your game.
				</div>
				<div class="form">
					{{ Form::input('tel', 'cell_number', $data['user']['cell_number'], ['placeholder' => 'Phone Number']) }}
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
			*/
			?>
			<div class="form">
				{{ Form::submit('Save') }}
			</div>

		{{ Form::close() }}
	</div>
@stop