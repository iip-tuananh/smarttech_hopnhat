<footer class="footer">
    <div class="mid-footer">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-3 col-md-6 col-12 link-list">
                    <h4 class="title-menu">
                        Thông tin công ty
                    </h4>
                    <div class="des-footer">
                        {{ $config->web_des}}
                    </div>
                    <h4 class="title-menu">
                        Theo dõi chúng tôi
                    </h4>
                    <div class="list-social">
                        <a href="{{ $config->facebook }}" class="social-button" title="Facebook">
                            <img src="/site/images/facebook.png"
                                alt="Facebook">
                        </a>
                        <a href="{{ $config->twitter }}" class="social-button" title="Twitter">
                            <img src="/site/images/twitter.png"
                                alt="Twitter">
                        </a>
                        <a href="{{ $config->linkedin }}" class="social-button" title="Linkedin">
                            <img src="/site/images/linkedin.png"
                                alt="Linkedin">
                        </a>
                        <a href="{{ $config->youtube }}" class="social-button" title="Youtube">
                            <img src="/site/images/youtube.png"
                                alt="Youtube">
                        </a>
                        <a href="{{ $config->instagram }}" class="social-button" title="Instagram">
                            <img src="/site/images/instagram.png"
                                alt="Instagram">
                        </a>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-12 link-list col-footer">
                    <h4 class="title-menu">
                        Về chúng tôi
                        <span class="Collapsible__Plus"></span>
                    </h4>
                    <div class="hidden-mobile">
                        <ul class="list-menu">
                            <li><a href="{{ route('front.home-page') }}" title="Trang chủ">Trang chủ</a></li>
                            <li><a href="{{ route('front.about-us') }}" title="Giới thiệu">Giới thiệu</a></li>
                            @foreach ($product_categories as $category)
                            <li><a href="{{ route('front.show-product-category', $category->slug) }}" title="{{ $category->name }}">{{ $category->name }}</a></li>
                            @endforeach
                            @foreach ($post_categories as $postCategory)
                            <li><a href="{{ route('front.list-blog', $postCategory->slug) }}" title="{{ $postCategory->name }}">{{ $postCategory->name }}</a></li>
                            @endforeach
                            <li><a href="{{ route('front.contact-us') }}" title="Liên hệ">Liên hệ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-12 link-list col-footer">
                    <h4 class="title-menu">
                        Hỗ trợ khách hàng
                        <span class="Collapsible__Plus"></span>
                    </h4>
                    <div class="list-menu hidden-mobile">
                        <ul class="list-menu">
                            @foreach ($policies as $policy)
                            <li><a href="{{ route('front.policy-detail', $policy->slug) }}" title="{{ $policy->title }}">{{ $policy->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-3 col-md-6 col-12 link-list">
                    <h4 class="title-menu">
                        Thông tin liên hệ
                    </h4>
                    <div class="list-menu">
                        <div class="group-address">
                            <ul>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 13 19" fill="none">
                                        <path
                                            d="M6.46532 0.686035C3.26765 0.686035 0.651367 3.30231 0.651367 6.49999C0.651367 8.08776 2.2 10.9476 2.27636 11.0877C2.27881 11.0922 2.28058 11.0952 2.28318 11.0996L5.87299 17.1867C6.06347 17.5097 6.52849 17.5159 6.72747 17.198L10.4732 11.2154C10.4757 11.2113 10.4773 11.2088 10.4799 11.2049C10.562 11.0807 12.3374 8.37556 12.3374 6.55813C12.3374 3.30231 9.72113 0.686035 6.46532 0.686035ZM6.46532 9.69766C4.60486 9.69766 3.09323 8.18603 3.09323 6.32557C3.09323 4.4651 4.60486 2.95348 6.46532 2.95348C8.32579 2.95348 9.83741 4.4651 9.83741 6.32557C9.77927 8.24417 8.32579 9.69766 6.46532 9.69766Z"
                                            stroke="var(--mainColor)" stroke-width="1.25"
                                            stroke-miterlimit="10"></path>
                                    </svg>
                                    <span>{{ $config->address_company }}</span>
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="var(--mainColor)" class="bi bi-telephone"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z">
                                        </path>
                                    </svg>
                                    <a class="tel" href="tel:{{ str_replace(' ', '', $config->hotline) }}" title="{{ $config->hotline }}">{{ $config->hotline }}</a>
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="var(--mainColor)" class="bi bi-envelope"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z">
                                        </path>
                                    </svg>
                                    <a href="mailto:{{ $config->email }}" title="{{ $config->email }}">{{ $config->email }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="copyright" class="copyright">
        <div class="container">
            <div class="wsp">
                © Bản quyền thuộc về {{ $config->web_title }}
            </div>
        </div>
    </div>
</footer>
<a href="#" class="backtop" title="Lên đầu trang">
    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="angle-up" role="img"
        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
        class="svg-inline--fa fa-angle-up fa-w-10">
        <path fill="currentColor"
            d="M168.5 164.2l148 146.8c4.7 4.7 4.7 12.3 0 17l-19.8 19.8c-4.7 4.7-12.3 4.7-17 0L160 229.3 40.3 347.8c-4.7 4.7-12.3 4.7-17 0L3.5 328c-4.7-4.7-4.7-12.3 0-17l148-146.8c4.7-4.7 12.3-4.7 17 0z"
            class=""></path>
    </svg>
</a>