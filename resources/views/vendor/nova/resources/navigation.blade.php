@if(count(Nova::availableResources(request())))
    <treeview tag="li" class="sidebar-item" toggle-tag="h3" toggle-class="sidebar-link dim">
        <template slot="label">
            <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill="var(--sidebar-icon)" d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"
                />
            </svg>

            <span class="text-white sidebar-label">
                {{ __('Resources') }}
            </span>
        </template>

        <?php $showGroups = count(Nova::groups(request())) > 1; ?>

        <template slot="menu">
            @if($showGroups)
                <ul class="sidebar-item-menu">
            @endif

                @foreach(Nova::groupedResources(request()) as $group => $resources)
                    @if(count($resources) > 0)

                        @if($showGroups)
                            <treeview tag="li" class="sidebar-item" toggle-tag="h4" toggle-class="sidebar-link dim">
                                <template slot="label">
                                    <i class="far fa-object-group sidebar-icon"></i>
                                    <span class="sidebar-label">{{ $group }}</span>
                                </template>

                                <template slot="menu">
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
                                </template>
                            </treeview>
                        @endif

                    @endif
                @endforeach

            @if($showGroups)
                </ul>
            @endif
        </template>
    </treeview>
@endif

