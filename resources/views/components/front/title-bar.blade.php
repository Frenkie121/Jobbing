<div id="titlebar" class="single">
	<div class="container">

		<div class="sixteen columns">
			<h2>{{ $title }}</h2>
			<nav id="breadcrumbs">
				<ul>
					<li>You are here:</li>
					<li><a href="{{ $previousUrl }}">{{ $previous }}</a></li>
					<li>{{ $title }}</li>
					{{ $slot }}
				</ul>
			</nav>
		</div>

	</div>
</div>