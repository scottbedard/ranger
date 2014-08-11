@extends('layouts.default')

@section('content')
	<div class="page">
		<h1>Search Officials</h1>
		<div class="form">
			{{ Form::open(['route' => 'officials.search']) }}
				{{ Form::text('search', Input::get('search'), ['placeholder' => 'Search']) }}
				{{ Form::submit('Search') }}
			{{ Form::close() }}
		</div>
	</div>
	<div class="scroll">
		<ul>
			@foreach ($data['officials'] as $official)
				<li>
					<h3>{{ $official['name']; }}</h3>
					@if (!empty($official['cell']))
						<div><a class="phone" href="tel:{{ $official['cell'] }}">{{ icon('phone').' '.phone($official['cell']) }}</a></div>
					@endif
					@if (!empty($official['home']))
						<div><a class="phone" href="tel:{{ $official['home'] }}">{{ icon('house').' '.phone($official['home']) }}</a></div>
					@endif
				</li>
			@endforeach
		</ul>
		@if (!empty($data['pagination']))
			<div class="center" style="padding-top: 10px">
				<div>Page {{ $data['officials']->getCurrentPage() }} of {{ $data['officials']->getLastPage() }}</div>
				<div>
					@if ($data['officials']->getCurrentPage() > 1)
						<a href="/officials/{{ $data['pagination']['prev'] }}">« Prev</a>
					@endif
					@if ($data['officials']->getCurrentPage() > 1 && $data['officials']->getCurrentPage() < $data['officials']->getLastPage())
						&nbsp;&nbsp;&nbsp;
					@endif
					@if ($data['officials']->getCurrentPage() < $data['officials']->getLastPage())
						<a href="/officials/{{ $data['pagination']['next'] }}">Next »</a>
					@endif
				</div>
			</div>
		@endif
	</div>
@stop