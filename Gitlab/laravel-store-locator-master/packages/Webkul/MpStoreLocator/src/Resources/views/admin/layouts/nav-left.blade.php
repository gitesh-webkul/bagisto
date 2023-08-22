<div class="navbar-left">
    <ul class="menubar">
        @foreach ($menu->items as $menuItem)
            @if(core()->getConfigData('sales.carriers.pickup_store.active') != 1 && $menuItem['key'] == "mpstorelocator")
                <?php continue; ?>
            @else
                <li class="menu-item {{ $menu->getActive($menuItem) }}">
                    <a href="{{ count($menuItem['children']) ? current($menuItem['children'])['url'] : $menuItem['url'] }}">
                        <span class="icon {{ $menuItem['icon-class'] }}"></span>
                        <span>{{ trans($menuItem['name']) }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
