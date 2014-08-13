@extends('layouts.default')

@section('content')
	<div class="scroll">
		<ul>
			<?php $i = 0; ?>
			@foreach ($data['ranger']->games as $game)
				<li>
					<a href="/game/{{ $i }}">
						<div class="row">
							<div class="date">{{ date($data['date_format'], $game->date) }}</div>
							<div class="time">{{ date($data['time_format'], $game->date) }}</div>
						</div>
						<div class="row">
							<div class="teams">
								{{ $game->level }}
							</div>
							<div class="location">
								@if (!empty($game->rink))
									{{ $game->rink['city'].', '.$game->rink['state'] }}
								@else
									{{ strtoupper($game->code) }}
								@endif
							</div>
						</div>
					</a>
				</li>
				<?php $i++; ?>
			@endforeach
		</ul>
	</div>

@stop