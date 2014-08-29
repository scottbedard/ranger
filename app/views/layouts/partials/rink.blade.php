<div>{{ $data['rink']['name'] }}</div>
<div>{{ $data['rink']['address'] }}</div>
<div>{{ $data['rink']['city'] }}, {{ $data['rink']['state'] }} {{ $data['rink']['zip'] }}</div>
@if (!empty($data['rink']['phone']))
	<div><a class="phone" href="tel:{{ $data['rink']['phone'] }}">{{ phone($data['rink']['phone']) }}</a></div>
@endif

<div class="center" style="padding-top: 10px">
	@if (!$data['rink']['confirmed_by'])
		<div>Nobody has confirmed this address yet</div>
		<div>
			<a href="/rinks/{{ $data['rink']['code'] }}/confirm">
				{{ icon('tick') }} This address is correct!
			</a>
		</div>
	@endif
</div>

<div class="center" style="padding-top: 10px">
	<div class="button">
		<a href="{{	'http://maps.apple.com/?q=#'.
					str_replace(' ', '+', $data['rink']['address'].', '.
					$data['rink']['city'].' '.
					$data['rink']['state'].', '.
					$data['rink']['zip']) }}">Launch Navigation</a>
	</div>
	@if ($data['rink']['locked_by'] == 0)
		@if ($data['rink']['reported_by'] == 0)
			<div>
				<a href="/rinks/{{ $data['rink']['code'] }}/report">
					{{ icon('error') }} Report Address
				</a>
			</div>
		@else
			<div>This address has been reported as incorrect, double check before you leave!</div>
		@endif
	@endif
</div>