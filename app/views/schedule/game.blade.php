@extends('layouts.default')

@section('content')
	<div class="game">
		<div class="section">
			<h1>Game</h1>
			<div class="info">
				<div>Date: {{ date($data['date_format'], $data['game']->date) }}</div>
				<div>Time: {{ date($data['time_format'], $data['game']->date) }}</div>
				<div>Level: {{ $data['game']->level }}</div>
				<div>Teams: {{ $data['game']->teams }}</div>
			</div>
		</div>

		@if (isset($data['rink']))
			<div class="section">
				<h1>Location</h1>
				<div class="info">
					@include('layouts.partials.rink')
				</div>
			</div>
			@if ($data['display_travel'])
				<div class="section">
					<h1>Travel</h1>
					<div class="info">
						@if(!empty($data['game']->travel['prev']['duration']))
							<div>
								<h3>From Previous Game</h3>
								<div>
									<span>{{ $data['prev']->rink['city'].', '.$data['prev']->rink['state'] }}</span>
									<span>{{ $data['game']->travel['prev']['duration'] }}</span>
								</div>
							</div>
						@endif
						@if(!empty($data['game']->travel['next']['duration']))
							<div>
								<h3>To Next Game</h3>
								<div>
									<span>{{ $data['next']->rink['city'].', '.$data['next']->rink['state'] }}</span>
									<span>{{ $data['game']->travel['next']['duration'] }}</span>
								</div>
							</div>
						@endif
						@if(!empty($data['game']->travel['base']['duration']))
							<div>
								<h3>Home Base</h3>
								<div>
									<span>{{ $data['user']['base'] }}</span>
									<span>{{ $data['game']->travel['base']['duration'] }}</span>
								</div>
							</div>
						@endif
					</div>
				</div>
			@endif
		@else
			<div class="section">
				<h1>Rink</h1>
				<div class="info">
					<div>Nobody has entered an address for this rink yet, help out your fellow officials by letting us know where it is!</div>
					{{ Form::open(['route' => 'rinks']) }}
						{{ Form::hidden('code', $data['game']->code) }}
						{{ Form::text('name', NULL, ['placeholder' => 'Rink Name']) }}
						{{ Form::text('address', NULL, ['placeholder' => 'Address']) }}
						{{ Form::text('city', NULL, ['placeholder' => 'City']) }}
						{{ Form::select('state', [
							'AL' => 'Alabama',
							'AK' => 'Alaska',
							'AZ' => 'Arizona',
							'AR' => 'Arkansas',
							'CA' => 'California',
							'CO' => 'Colorado',
							'CT' => 'Connecticut',
							'DE' => 'Delaware',
							'FL' => 'Florida',
							'GA' => 'Georgia',
							'HI' => 'Hawaii',
							'ID' => 'Idaho',
							'IL' => 'Illinois',
							'IN' => 'Indiana',
							'IA' => 'Iowa',
							'KS' => 'Kansas',
							'KY' => 'Kentucky',
							'LA' => 'Louisiana',
							'ME' => 'Maine',
							'MD' => 'Maryland',
							'MA' => 'Massachusetts',
							'MI' => 'Michigan',
							'MN' => 'Minnesota',
							'MS' => 'Mississippi',
							'MO' => 'Missouri',
							'MT' => 'Montana',
							'NE' => 'Nebraska',
							'NV' => 'Nevada',
							'NH' => 'New Hampshire',
							'NJ' => 'New Jersey',
							'NM' => 'New Mexico',
							'NY' => 'New York',
							'NC' => 'North Carolina',
							'ND' => 'North Dakota',
							'OH' => 'Ohio',
							'OK' => 'Oklahoma',
							'OR' => 'Oregon',
							'PA' => 'Pennsylvania',
							'RI' => 'Rhode Island',
							'SC' => 'South Carolina',
							'SD' => 'South Dakota',
							'TN' => 'Tennessee',
							'TX' => 'Texas',
							'UT' => 'Utah',
							'VT' => 'Vermont',
							'VA' => 'Virginia',
							'WA' => 'Washington',
							'WV' => 'West Virginia',
							'WI' => 'Wisconsin',
							'WY' => 'Wyoming'
						]); }}
						{{ Form::input('number', 'zip', NULL, ['placeholder' => 'Zip Code', 'max' => 99999]); }}
						{{ Form::text('phone', NULL, ['placeholder' => 'Phone Number']) }}
						<div class="center">
							{{ Form::submit('Submit') }}
						</div>
					{{ Form::close() }}
				</div>
			</div>
		@endif

		<div class="section">
			<h1>Crew</h1>
			<div class="info">
				<div>
					<h3>Referees</h3>
					@foreach ($data['game']->crew->referees as $official)
						<div>
							<span>{{ $official }}</span>
							@if (!empty($data['contacts'][$official]))
								<span>
									<a href="tel:{{ $data['contacts'][$official]['number'] }}">
										{{	icon($data['contacts'][$official]['type']).' '.
											phone($data['contacts'][$official]['number']) }}
									</a>
								</span>
							@else
								<span></span>
							@endif
						</div>
					@endforeach
				</div>
				<div>
					<h3>Linesmen</h3>
					@foreach ($data['game']->crew->linesmen as $official)
						<div>
							<span>{{ $official }}</span>
							@if (!empty($data['contacts'][$official]))
								<span>
									<a href="tel:{{ $data['contacts'][$official]['number'] }}">
										{{	icon($data['contacts'][$official]['type']).' '.
											phone($data['contacts'][$official]['number']) }}
									</a>
								</span>
							@else
								<span></span>
							@endif
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@stop