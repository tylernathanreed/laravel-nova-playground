<?php $exact = $exact ?? false; ?>
<?php $to = $to ?? null; ?>
<?php $bind = $bind ?? false; ?>

<li class="sidebar-item">

	@if($to)
		<router-link tag="h3"{{ $exact ? ' exact' : '' }}{{ $to ? " to={$to}" : '' }} class="sidebar-link dim">
		    {!! $icon !!}
		    <span class="text-white sidebar-label">{!! $label !!}</span>
		</router-link>
	@else
		<h3 class="sidebar-link dim">
		    {!! $icon !!}
		    <span class="text-white sidebar-label">{!! $label !!}</span>
		</h3>
	@endif

	{!! $slot !!}
</li>