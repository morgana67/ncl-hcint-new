@foreach($items as $menu_item)
    <div class="ftr__box ftr__links col-sm-4 clrlist listview">
        <h4>{{ $menu_item->title }}</h4>
        @if(!$menu_item->children->isEmpty())
            <ul>
                @foreach($menu_item->children as $children)
                    <li><a href="{{ $children->link() }}">{{ $children->title }}</a></li>
                @endforeach
            </ul>
        @endif
    </div>
@endforeach
