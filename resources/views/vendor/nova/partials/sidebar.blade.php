<!-- Sidebar -->
<aside class="sidebar bg-grad-sidebar">
    <a href="{{ Nova::path() }}">
        <div class="sidebar-logo">
           @include('nova::partials.logo')
        </div>
    </a>

    <section class="sidebar-nav">
    	<ul class="sidebar-menu">
		    @foreach(Nova::availableTools(request()) as $tool)
		        {!! $tool->renderNavigation() !!}
		    @endforeach
		</ul>
	</section>
</aside>