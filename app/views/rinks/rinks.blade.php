@extends('layouts.default')

@section('content')
	<div class="page">
		<h1>Search Rinks</h1>
		<div class="form">
			{{ Form::open(['route' => 'rinks.search']) }}
				{{ Form::select('field', ['name' => 'Rink Name', 'city' => 'City', 'code' => 'Code']) }}
				{{ Form::text('search', Input::get('search'), ['placeholder' => 'Search']) }}
				{{ Form::submit('Search') }}
			{{ Form::close() }}
		</div>
	</div>
	<div class="scroll">
		<ul>
			@foreach ($data['rinks'] as $rink)
				<li>
					<a href="/rinks/info/{{ $rink->code }}">
						<h3>{{ $rink->name }}</h3>
						<div>{{ $rink->address }}</div>
						<div>{{ $rink->city.', '.$rink->state.' '.$rink->zip }}</div>
						@if (!empty($rink->phone))
							<div><a class="phone" href="tel:{{ $rink->phone }}">{{ phone($rink->phone) }}</a></div>
						@endif
					</a>
				</li>
			@endforeach
		</ul>
		@if (!empty($data['pagination']))
			<div class="center" style="padding-top: 10px">
				<div>Page {{ $data['rinks']->getCurrentPage() }} of {{ $data['rinks']->getLastPage() }}</div>
				<div>
					@if ($data['rinks']->getCurrentPage() > 1)
						<a href="/rinks/{{ $data['pagination']['prev'] }}">« Prev</a>
					@endif
					@if ($data['rinks']->getCurrentPage() > 1 && $data['rinks']->getCurrentPage() < $data['rinks']->getLastPage())
						&nbsp;&nbsp;&nbsp;
					@endif
					@if ($data['rinks']->getCurrentPage() < $data['rinks']->getLastPage())
						<a href="/rinks/{{ $data['pagination']['next'] }}">Next »</a>
					@endif
				</div>
			</div>
		@endif
	</div>
@stop