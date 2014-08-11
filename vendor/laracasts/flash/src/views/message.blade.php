@if (Session::has('flash_notification.message'))
    @if (Session::has('flash_notification.overlay'))
        @include('flash::modal', ['modalClass' => 'flash-modal', 'title' => Session::get('flash_notification.title'), 'body' => Session::get('flash_notification.message')])
    @else
        <div class="status {{ Session::get('flash_notification.level') }}">
            <span></span>{{ Session::get('flash_notification.message') }}
        </div>
    @endif
@endif
