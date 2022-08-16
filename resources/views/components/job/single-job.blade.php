<li><a href="{{ $url }}">
  <img src="{{ $image }}" alt="{{ $title }}">
  <div class="job-list-content">
      <h4>{{ $title }} <span class="{{ $classType }}">{{ $type }}</span></h4>
      <div class="job-icons">
        <span><i class="fa fa-briefcase"></i> King</span>
        <span><i class="fa fa-map-marker"></i> {{ $location }}</span>
        <span><i class="fa fa-money"></i> {{ $salary }} / hour</span>
      </div>
      @if (!Route::is('home'))
        <p>{{ $description }}</p>
      @endif
  </div>
  </a>
  <div class="clearfix"></div>
</li>