<!-- Sidebar -->
<aside class="main-sidebar min-h-screen flex-none pt-header min-h-screen w-sidebar bg-grad-sidebar">
    <a href="{{ Nova::path() }}">
        <div class="absolute pin-t pin-l pin-r bg-logo flex items-center w-sidebar h-header px-6 text-white">
           @include('nova::partials.logo')
        </div>
    </a>

    <section class="sidebar">
    	<ul class="sidebar-menu list-reset">
		    @foreach(Nova::availableTools(request()) as $tool)
		        {!! $tool->renderNavigation() !!}
		    @endforeach
		</ul>
	</section>
</aside>