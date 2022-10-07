<div>
  @if (auth()->check() && auth()->user()->role_id === 3 && auth()->user()->userable->hasAppliedToJob($id))
      <button class="button" style="background-color: gold; margin-left: 55px" aria-disabled="true">Already Applied</button>
  @else
    <a href="{{ route('freelance.apply', $slug) }}" class="button"
      onclick="event.preventDefault();
      document.querySelector('#apply{{ $id }}').submit();">Apply For This Job</a>
    <form action="{{ route('freelance.apply', $slug) }}" method="post" style="display: none" id="apply{{ $id }}">
      @csrf
      @method('PATCH')
    </form>
  @endif
</div>