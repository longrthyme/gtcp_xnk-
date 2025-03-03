@if(!empty($categories))
<div class="block-archive">
    <div class="container mb-lg-4 mb-3">
        <div class='page-content'>
            <div class="page-wrapper">
                <div class="nav-scroll">
                    <ul class="nav nav-pills nav-product-tabs" id="pills-tab" role="tablist">
                        @foreach($categories as $item)
                            @php
                                $menu_active = '';
                                if (url()->current() == $item->getUrl())
                                   $menu_active = ' active';
                            @endphp
                            <li class="nav-item">
                                <a class="nav-link {{ $menu_active }}" href="{{ $item->getUrl() }}"><span>{{ $item->name }}</span></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endif