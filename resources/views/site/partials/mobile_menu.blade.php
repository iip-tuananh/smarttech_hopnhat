<div class="wrapmenu" id="mobile-menu">
    <div class="containers">
        <!-- Menu mobile -->
        <div class="user-menu">
            <div class="user-icon">
                <img src="{{ $config->image ? $config->image->path : 'https://placehold.co/100x100' }}" alt="{{ $config->web_title }}" loading="lazy">
            </div>
            {{-- <div class="user-account">
                <a class="btnx" href="/account/login">Đăng nhập</a>
                <small><a href="/account/register">Đăng ký</a></small>
            </div> --}}
        </div>
        <div class="menu_mobile">
            <ul class="block-nav list-group">
                <li class="nav-item active ">
                    <a class="a-img" href="{{ route('front.home-page') }}" title="Trang chủ">
                        Trang chủ
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="a-img" href="{{ route('front.about-us') }}" title="Giới thiệu">
                        Giới thiệu
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="javascript:void(0);" title="Sản phẩm">
                        Sản phẩm
                    </a>
                    <i class="icon" data-toggle-submenu><img
                            src="//bizweb.dktcdn.net/100/496/216/themes/921741/assets/right-chevron.png?1743048451127"
                            alt="Lofi Decor"></i>
                    <div class="submenu">
                        <div class="toggle-submenu d-lg-none d-xl-none">
                            <i class="icon"><img
                                    src="//bizweb.dktcdn.net/100/496/216/themes/921741/assets/left-chevron.png?1743048451127"
                                    alt="Lofi Decor"></i>
                            <span>Sản phẩm</span>
                        </div>
                        <ul class="submenu__list">
                            @foreach ($productCategories as $category)
                            <li class="submenu__col">
                                <a href="{{ route('front.show-product-category', ['categorySlug' => $category->slug]) }}" title="{{$category->name}}">
                                    {{$category->name}}
                                </a>
                                @if ($category->childs->count() > 0)
                                <ul>
                                    @foreach ($category->childs as $child)
                                    <li>
                                        <a href="{{ route('front.show-product-category', ['categorySlug' => $child->slug]) }}" title="{{$child->name}}" class="a3">{{$child->name}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                @foreach ($postCategories as $postCategory)
                <li class="nav-item ">
                    <a class="a-img" href="{{ route('front.list-blog', ['slug' => $postCategory->slug]) }}" title="{{$postCategory->name}}">
                        {{$postCategory->name}}
                    </a>
                </li>
                @endforeach
                <li class="nav-item ">
                    <a class="a-img" href="{{ route('front.contact-us') }}" title="Liên hệ">
                        Liên hệ
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>