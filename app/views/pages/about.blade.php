@extends('layouts.default')

@section('content')
	<div class="game">

		<div class="section">
			<h1>About</h1>
			<div class="info">
				This project was created to provide a more enjoyable method of interacting with RefRanger. This project was created completely independently of OSWebs, and has no affiliation with them or USA Hockey.
			</div>
		</div>

		<div class="section">
			<h1>How does this work</h1>
			<div class="info">
				A few people have asked, how does this work if it's not affiliated with ranger? This app interacts with Ranger similarly to how you normally do. Because Ranger doesn't check where a request is coming from, we are able to log in remotely and extract your schedule information. After that, we do some work on our end to do things like calculate driving distances, and keeping track or rink addresses.
			</div>
		</div>

		<div class="section">
			<h1>Security</h1>
			<div class="info">
				We will never store your password on our server, and only ask for your password so that we can send your credentials to Ranger and retrieve your schedule. With that said, it should be mentioned that although this app was built as securely as possible, Ranger on the other hand was not. They do not use the standard practice of <a href="https://www.youtube.com/watch?v=8ZtInClXe1Q">hashing and salting</a>, so we recommend using a unique password specifically for Ranger.
			</div>
		</div>

		<div class="section">
			<h1>Contributing</h1>
				<div class="info">
				This project is open source and is available on GitHub. If you're a developer and want to contribute, or just curious and want to look under the hood, please go right ahead!
				<div style="text-align: center; padding-top: 10px">
					<a href="http://github.com/scottbedard/ranger">View Repository</a>
				</div>
			</div>
		</div>

	</div>
@stop