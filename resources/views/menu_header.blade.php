<ul class="nav navbar-nav navbar-main">
    @foreach($items as $menu_item)
        @php
            $isActive = null;
            if((strpos(url()->current(), url($menu_item->link())) !== false) && $menu_item->link() != ''){
                $isActive = 'active';
            }
            if(!$menu_item->children->isEmpty()){
                 foreach($menu_item->children as $children){
                      if((strpos(url()->current(), url($children->link())) !== false)){
                            $isActive = 'active';
                        }
                 }
            }
        @endphp
        <li class="{{$isActive}}">
            <a  @if(!$menu_item->children->isEmpty())
                 href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                 aria-haspopup="true" aria-expanded="false"
                @else
                 href="{{ $menu_item->link() }}"
                @endif
            >{{ $menu_item->title }}
                @if(!$menu_item->children->isEmpty())
                    <span class="caret"></span>
                @endif
            </a>
            @if(!$menu_item->children->isEmpty())
                <ul class="dropdown-menu">
                    @foreach($menu_item->children as $children)
                        <li><a href="{{ $children->link() }}">{{ $children->title }}</a></li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
    @if(!is_customer())
        <li class="login-link {{$isActive}}"><a href="{{route('login')}}">Login</a></li>
    @else
        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
               aria-expanded="false">My Account<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{{route('myOrder')}}" class="pagelinkcolor">My Orders</a></li>
                <li><a href="{{route('profile.changePassword')}}" class="pagelinkcolor">Change Password</a></li>
                <li><a href="{{route('profile.profile')}}" class="pagelinkcolor">Profile</a></li>
                <li><a href="!#" class="pagelinkcolor" id="logout">Log Out</a></li>
            </ul>
        </li>
    @endif

    <li class="cart-item">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
           aria-haspopup="true" aria-expanded="false"><i
                class="fa fa-shopping-cart fa-2"></i> <span>Cart<sup
                    class="badge"></sup></span> </a>

        <ul class="dropdown-menu">
            @if(user() != null && Cart::count() == 0 && user()->role_id == 2)
                 <li><a href="javascript:void(0);" class="pagelinkcolor">No items</a></li>
            @else
                @foreach(Cart::content() as $product)
                    <li><a href="{{route('product_detail',['slug' => $product->id])}}" class="pagelinkcolor">{{$product->name}}</a></li>
                @endforeach
                    <li>
                        <div class="p10 col-sm-12 active d-flex justify-content-flex-end">
                            <a class="btn btn-warning" href="{{route('cart.view')}}"><i class="fa fa-arrow-right"></i> View Cart</a>
                            <a class="btn btn-primary" href="{{route('cart.checkout')}}"><i class="fa fa-shopping-cart"></i> Check out</a>
                        </div>
                    </li>
            @endif

        </ul>
    </li>
</ul>

