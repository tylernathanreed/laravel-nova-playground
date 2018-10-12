@if(count(Nova::availableResources(request())))
    @component('components.sidebar-item')
        @slot('icon')
            <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill="var(--sidebar-icon)" d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"
                />
            </svg>
        @endslot

        @slot('label')
            {{ __('Resources') }}
        @endslot

        <?php $showGroups = count(Nova::groups(request())) > 1; ?>

        @if($showGroups)
            <ul class="sidebar-item-menu">
        @endif

            @foreach(Nova::groupedResources(request()) as $group => $resources)
                @if(count($resources) > 0)

                    @if($showGroups)
                        <li class="sidebar-item">
                            <h4 class="sidebar-link dim">
                                <i class="far fa-object-group sidebar-icon"></i>
                                <span class="sidebar-label">{{ $group }}</span>
                            </h4>
                        </li>
                    @endif

                            <ul class="sidebar-item-menu">
                                @foreach($resources as $resource)
                                    @if(!$resource::$displayInNavigation)
                                        @continue
                                    @endif

                                    <li class="sidebar-item">
                                        <router-link :to="{
                                            name: 'index',
                                            params: {
                                                resourceName: '{{ $resource::uriKey() }}'
                                            }
                                        }" class="sidebar-link dim">
                                            @if(method_exists($resource, 'icon'))
                                                {!! $resource::icon() !!}
                                            @endif
                                            <span class="sidebar-label">{{ $resource::label() }}</span>
                                        </router-link>
                                    </li>
                                @endforeach
                            </ul>

                    @if($showGroups)
                        </li>
                    @endif

                @endif
            @endforeach

        @if($showGroups)
            </ul>
        @endif

    @endcomponent
@endif

