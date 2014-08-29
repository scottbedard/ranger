@extends('layouts.default')

@section('content')
	<div class="scroll">
		<div class="pending_label">You have new games to accept</div>
		<ul>
			<?php $i = 0; ?>
			@foreach ($data['ranger']->pending as $game)
				<li>
					<a href="/game/{{ $i }}">
						<div class="row">
							<div class="date">{{ $game->date }}</div>
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
		<div class="button">
			{{ link_to_route('schedule.accept', 'Accept') }}
		</div>
	</div>

@stop