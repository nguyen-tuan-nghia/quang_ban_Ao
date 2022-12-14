<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>{{ $web_detail->name }}</title>
    <!--/tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords"
        content="Grocery Shoppy Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script>
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!--//tags -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('web/logo/' . $web_detail->logo) }}" />
    <link href="{{ asset('client/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('client/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('client/css/font-awesome.css') }}" rel="stylesheet">
    <!--pop-up-box-->
    <link href="{{ asset('client/css/popuo-box.css') }}" rel="stylesheet" type="text/css" media="all" />
    <!--//pop-up-box-->
    <!-- price range -->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/jquery-ui1.css') }}">
    <!-- jquery -->
    <link rel="stylesheet" href="{{ asset('client/css/flexslider.css') }}" type="text/css" media="screen">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('client/js/jquery-2.1.4.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.css" />

    <!-- //jquery -->
    <!-- fonts -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
</head>

<body>
    <!-- top-header -->
    <div class="header-most-top">
        <p>??u ????i h??ng ?????u c???a khu v???c b??n h??ng v?? gi???m gi??</p>
    </div>
    <!-- //top-header -->
    <!-- header-bot-->
    <div class="header-bot">
        <div class="header-bot_inner_wthreeinfo_header_mid">
            <!-- header-bot-->
            <div class="col-md-4 logo_agile">
                <h1>
                    <a href="{{ url('/') }}">
                        {{ $web_detail->name }}
                        <img src="{{ asset('client/images/logo2.png') }}" alt=" ">
                    </a>
                </h1>
            </div>
            <!-- header-bot -->
            <div class="col-md-8 header">
                <!-- header lists -->
                <ul>
                    <li>
                        {{-- <a href="#" class="">
                            <span class="fa fa-map-marker" aria-hidden="true"></span> Shop Locator</a> --}}
                    </li>
                    <li>
                        {{-- <a href="#">
                            <span class="fa fa-truck" aria-hidden="true"></span>Track Order</a> --}}
                    </li>
                    <li>
                        <span class="fa fa-phone" aria-hidden="true"></span> {{ $web_detail->phone }}
                    </li>
                    @if (!Auth::user())
                        <li>
                            <a href="#" data-toggle="modal" data-target="#myModal1">
                                <span class="fa fa-unlock-alt" aria-hidden="true"></span> ????ng nh???p </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#myModal2">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span> ????ng k?? </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ URL::to('/cart/history') }}">
                                <div id="avatar">{{ Auth::user()->name }}</div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('/logout') }}">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span>????ng xu???t</a>
                        </li>
                    @endif
                </ul>
                <!-- //header lists -->
                <!-- search -->
                <div class="agileits_search">
                    <form action="{{ url('/search') }}" method="post">
                        @csrf
                        <input name="search" type="search" id="keywords" autocomplete="off"
                            placeholder="H??m nay t??i c?? th??? l??m g?? ????? gi??p b???n?" required="">
                        <button type="submit" class="btn btn-default" aria-label="Left Align">
                            <span class="fa fa-search" aria-hidden="true"> </span>
                        </button>
                        <div class="search-ajax" id="search_ajax"></div>
                    </form>
                </div>
                <!-- //search -->
                <!-- cart details -->
                <div class="top_nav_right">
                    <div class="wthreecartaits wthreecartaits2 cart cart box_1">
                        {{-- <form action="#" method="post" class="last"> --}}
                        {{-- <input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="display" value="1"> --}}
                        {{-- <button class="w3view-cart" type="submit" name="submit" value=""> --}}
                        <a class="w3view-cart" id="cart"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        </a>
                        {{-- </button> --}}
                        {{-- </form> --}}
                    </div>
                </div>
                <!-- //cart details -->
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- signin Model -->
    @include('public.login.signin')
    <!-- //signin Model -->
    <!-- signup Model -->
    @include('public.login.signup')
    <!-- //signup Model -->
    <!-- //header-bot -->
    <!-- navigation -->
    <div class="ban-top">
        <div class="container">
            <div class="top_nav_left">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse menu--shylock" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav menu__list">
                                <li class="active">
                                    <a class="nav-stylehead" href="{{ Url('/') }}">Trang ch???
                                        <span class="sr-only">(current)</span>
                                    </a>
                                </li>
                                @foreach ($danh_muc as $key => $val)
                                    @if ($val->category_parent == 0)
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle nav-stylehead"
                                                data-toggle="dropdown" role="button" aria-haspopup="true"
                                                aria-expanded="false">{{ $val->name }}
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu multi-column columns-3">
                                                <div class="agile_inner_drop_nav_info">
                                                    <div class="col-sm-4 multi-gd-img">
                                                        <ul class="multi-column-dropdown">
                                                            @foreach ($danh_muc as $key2 => $val2)
                                                                @if ($val2->category_parent == $val->id)
                                                                    <li>
                                                                        <a
                                                                            href="{{ url('danh-muc/' . $val2->slug) }}">{{ $val2->name }}</a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                                {{-- <li>
                                    <a class="nav-stylehead" href="{{ Url('/gioi-thieu') }}">Gi???i thi???u
                                        <span class="sr-only">(current)</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a class="nav-stylehead" href="{{ Url('/contact') }}">Li??n h???
                                        <span class="sr-only">(current)</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a class="nav-stylehead" href="{{ Url('/tin-tuc') }}">Tin t???c
                                        <span class="sr-only">(current)</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    @yield('content')
    <!-- //special offers -->
    <!-- newsletter -->
    <div class="footer-top">
        <div class="container-fluid">
            <div class="col-xs-8 agile-leftmk">
                <h2>????n h??ng c???a b???n ???????c giao t??? c??c c???a h??ng ?????a ph????ng</h2>
                <p>Giao h??ng mi???n ph?? cho ????n h??ng ?????u ti??n c???a b???n!!</p>
                <div class="newsform-w3l">
                    <span class="fa fa-envelope-o" aria-hidden="true"></span>
                </div>
            </div>
            <div class="col-xs-4 w3l-rightmk">
                <img src="{{ asset('client/images/tab3.png') }}" alt=" ">
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- //newsletter -->
    <!-- footer -->
    <footer>
        <div class="container">
            <!-- footer first section -->
            <p class="footer-main">
                Nh?? s??ch " Kh??ng ai t??? ch???i ho???c gh??t ni???m vui b???i v?? b???n th??n ni???m vui l?? ni???m vui, nh??ng v??
                nh???ng n???i ??au l???n l?? k???t qu??? c???a nh???ng ng?????i kh??ng bi???t c??ch theo ??u???i ni???m vui theo l?? tr??. T??i s??? gi???i
                th??ch nh???ng g?? ???? ???????c nh?? ph??t minh ra s??? th???t ???? n??i v??, nh?? n?? ???? l??, ki???n ??????tr??c s?? c???a cu???c s???ng
                may m???n.</p>
            <!-- //footer first section -->
            <!-- footer second section -->
            <div class="w3l-grids-footer">
                <div class="col-xs-4 offer-footer">
                    <div class="col-xs-4 icon-fot">
                        <span class="fa fa-map-marker" aria-hidden="true"></span>
                    </div>
                    <div class="col-xs-8 text-form-footer">
                        <h3>Theo d??i ????n h??ng c???a b???n</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-4 offer-footer">
                    <div class="col-xs-4 icon-fot">
                        <span class="fa fa-refresh" aria-hidden="true"></span>
                    </div>
                    <div class="col-xs-8 text-form-footer">
                        <h3>Tr??? h??ng mi???n ph?? v?? d??? d??ng</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-4 offer-footer">
                    <div class="col-xs-4 icon-fot">
                        <span class="fa fa-times" aria-hidden="true"></span>
                    </div>
                    <div class="col-xs-8 text-form-footer">
                        <h3>H???y tr???c <br>tuy???n</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- //footer second section -->
            <!-- footer third section -->
            <div class="footer-info w3-agileits-info">
                <!-- footer categories -->
                <div class="col-sm-5 address-right">
                    <div class="col-xs-6 footer-grids">
                        <h3>Danh muc</h3>
                        <ul>
                            @foreach ($danh_muc as $key => $val)
                                <li>
                                    <a href="#">{{ $val->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- //footer categories -->
                <!-- quick links -->
                <div class="col-sm-5 address-right">
                    <div class="col-xs-6 footer-grids">

                    </div>
                    <div class="col-xs-8 footer-grids">
                        <h3>Li??n l???c v???i ch??ng t??i</h3>
                        <ul>
                            <li>
                                <i class="fa fa-map-marker"></i> {{ $web_detail->address }}
                            </li>
                            <li>
                                <i class="fa fa-mobile"></i> {{ $web_detail->phone }}
                            </li>
                            <li>
                                <i class="fa fa-envelope-o"></i>
                                <a href="mailto:example@mail.com">{{ $web_detail->email }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- //quick links -->
                <!-- social icons -->
                <div class="col-sm-2 footer-grids  w3l-socialmk">
                    <h3>Theo d??i ch??ng t??i</h3>
                    <div class="social">
                        <ul>
                            <li>
                                <a class="icon fb" href="#">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a class="icon tw" href="#">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a class="icon gp" href="#">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    {!! $web_detail->fanpage !!}
                </div>
                <!-- //social icons -->
                <div class="clearfix"></div>
            </div>
        </div>
    </footer>
    <!-- //footer -->
    <script type="text/javascript">
        $('#keywords').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/keywords') }}",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#search_ajax').fadeIn();
                        $('#search_ajax').html(data);
                    }
                });

            } else {

                $('#search_ajax').fadeOut();
            }
        });

        $(document).on('click', '.li_search_ajax', function() {
            $('#keywords').val($(this).text());
            $('#search_ajax').fadeOut();
        });
    </script>
    <script>
        $("#cart").click(function() {
            var auth = "{{ Auth::user() }}";
            if (auth) {
                window.location.href = "{{ url('/cart') }}";
            } else {
                $('#myModal1').modal('show');
            }
        });
    </script>
    <script>
        function cartstore(id) {
            var auth = "{{ Auth::user() }}";
            if (auth) {
                var id = id;
                var image = $("#product_image" + id).val();
                var quantity = $("#product_quantity" + id).val();
                var price = $("#product_price" + id).val();
                var name = $("#product_name" + id).val();
                $.ajax({
                    url: "{{ url('/cart/store') }}",
                    method: "POST",
                    data: {
                        id: id,
                        image: image,
                        quantity: quantity,
                        price: price,
                        name: name
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        Swal.fire({
                            title: "",
                            text: "B???n ???? th??m s???n ph???m v??o gi??? h??ng",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "<a style='color:white' href='{{ url('/cart') }}'><i class='la la-headphones'></i>T???i gi??? h??ng</a>",
                            showCancelButton: true,
                            cancelButtonText: "<i class='la la-thumbs-down'></i> Mua ti???p",
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-default"
                            }
                        });
                    }
                });
            } else {
                $('#myModal1').modal('show');
            }
        }
    </script>
    <!-- popup modal (for signin & signup)-->
    {{-- <script src="{{ asset('client/js/jquery.magnific-popup.js')}}"></script>
	<script>
		$(document).ready(function () {
			$('.popup-with-zoom-anim').magnificPopup({
				type: 'inline',
				fixedContentPos: false,
				fixedBgPos: true,
				overflowY: 'auto',
				closeBtnInside: true,
				preloader: false,
				midClick: true,
				removalDelay: 300,
				mainClass: 'my-mfp-zoom-in'
			});

		});
	</script> --}}
    <script src="{{ asset('client/js/jquery.flexisel.js') }}"></script>
    <script>
        $(window).load(function() {
            $("#flexiselDemo1").flexisel({
                visibleItems: 3,
                animationSpeed: 1000,
                autoPlay: true,
                autoPlaySpeed: 3000,
                pauseOnHover: true,
                enableResponsiveBreakpoints: true,
                responsiveBreakpoints: {
                    portrait: {
                        changePoint: 480,
                        visibleItems: 1
                    },
                    landscape: {
                        changePoint: 640,
                        visibleItems: 2
                    },
                    tablet: {
                        changePoint: 768,
                        visibleItems: 2
                    }
                }
            });

        });
    </script>
    <!-- //flexisel (for special offers) -->
    <!-- start-smooth-scrolling -->
    <script src="{{ asset('client/js/move-top.js') }}"></script>
    <script src="{{ asset('client/js/easing.js') }}"></script>
    <script>
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event) {
                event.preventDefault();

                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 1000);
            });
        });
    </script>
    <!-- //end-smooth-scrolling -->

    <!-- smooth-scrolling-of-move-up -->
    <script>
        $(document).ready(function() {
            /*
            var defaults = {
            	containerID: 'toTop', // fading element id
            	containerHoverID: 'toTopHover', // fading element hover id
            	scrollSpeed: 1200,
            	easingType: 'linear'
            };
            */
            $().UItoTop({
                easingType: 'easeOutQuart'
            });

        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.js"></script>
    <script src="{{ asset('client/js/bootstrap.js') }}"></script>
    <!-- //for bootstrap working -->
    <!-- //js-files -->
    {{-- vnpay --}}
</body>

</html>
