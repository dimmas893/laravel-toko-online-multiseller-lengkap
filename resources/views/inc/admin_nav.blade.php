<header id="navbar">
    <div id="navbar-container" class="boxed">

        @php
            $generalsetting = \App\GeneralSetting::first();
        @endphp


        <div class="navbar-header">
            <a href="{{route('admin.dashboard')}}" class="navbar-brand">
                @if($generalsetting->logo != null)
                    <img loading="lazy"  src="{{ asset($generalsetting->admin_logo) }}" class="brand-icon" alt="{{ $generalsetting->site_name }}">
                @else
                    <img loading="lazy"  src="{{ asset('img/logo_shop.png') }}" class="brand-icon" alt="{{ $generalsetting->site_name }}">
                @endif
                <div class="brand-title">
                    <span class="brand-text">{{ $generalsetting->site_name }}</span>
                </div>
            </a>
        </div>

        <div class="navbar-content">

            <ul class="nav navbar-top-links">

                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="#">
                        <i class="demo-pli-list-view"></i>
                    </a>
                </li>

                @if (\App\Addon::where('unique_identifier', 'pos_system')->first() != null && \App\Addon::where('unique_identifier', 'pos_system')->first()->activated)
                <li class="" data-toggle="tooltip" data-placement="bottom" data-original-title="POS">
                    <a class="" href="{{ route('poin-of-sales.index') }}">
                        <i class="fa fa-print"></i>
                    </a>
                </li>
                @endif
                <li class="" data-toggle="tooltip" data-placement="bottom" data-original-title="Browse Frontend">
                    <a target="_blank" href="{{ route('home') }}">
                        <i class="fa fa-globe"></i>
                    </a>
                </li>


            </ul>
            <ul class="nav navbar-top-links">

                @php
                    $orders = DB::table('orders')
                                ->orderBy('code', 'desc')
                                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                                ->where('order_details.seller_id', \App\User::where('user_type', 'admin')->first()->id)
                                ->where('orders.viewed', 0)
                                ->select('orders.id')
                                ->distinct()
                                ->count();
                    $sellers = \App\Seller::where('verification_status', 0)->where('verification_info', '!=', null)->count();
                @endphp

                <li class="dropdown" id="lang-change">
                    @php
                        if(Session::has('locale')){
                            $locale = Session::get('locale', Config::get('app.locale'));
                        }
                        else{
                            $locale = 'en';
                        }
                    @endphp
                    @if(\App\Language::where('code', $locale)->first() != null)
                        <a href="" class="dropdown-toggle top-bar-item" data-toggle="dropdown">
                            <img loading="lazy"  src="{{ asset('frontend/images/icons/flags/'.$locale.'.png') }}" class="flag" style="margin-right:6px;"><span class="language">{{ \App\Language::where('code', $locale)->first()->name }}</span>
                        </a>
                    @endif
                    <ul class="dropdown-menu">
                        @foreach (\App\Language::all() as $key => $language)
                            <li class="dropdown-item @if($locale == $language) active @endif">
                                <a href="#" data-flag="{{ $language->code }}"><img loading="lazy"  src="{{ asset('frontend/images/icons/flags/'.$language->code.'.png') }}" class="flag" style="margin-right:6px;"><span class="language">{{ $language->name }}</span></a>
                            </li>
                        @endforeach
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true">
                        <i class="demo-pli-bell"></i>
                        @if($orders > 0 || $sellers > 0)
                            <span class="badge badge-header badge-danger"></span>
                        @endif
                    </a>

                    <!--Notification dropdown menu-->
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="opacity: 1;">
                        <div class="nano scrollable has-scrollbar" style="height: 265px;">
                            <div class="nano-content" tabindex="0" style="right: -17px;">
                                <ul class="head-list">
                                    @if($orders > 0)
                                        <li>
                                            <a class="media" href="{{ route('orders.index.admin') }}" style="position:relative">
                                                <span class="badge badge-header badge-info" style="right:auto;left:3px;"></span>
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">{{ $orders }} new order(s)</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if($sellers > 0)
                                        <li>
                                            <a class="media" href="{{ route('sellers.index') }}">
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">{{__('New verification request(s)')}}</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="nano-pane" style="">
                                <div class="nano-slider" style="height: 170px; transform: translate(0px, 0px);"></div>
                            </div>
                        </div>
                    </div>
                </li>

                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="ic-user pull-right">

                            <i class="demo-pli-male"></i>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                        <ul class="head-list">
                            <li>
                                <a href="{{ route('profile.index') }}"><i class="demo-pli-male icon-lg icon-fw"></i> {{__('Profile')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('logout')}}"><i class="demo-pli-unlock icon-lg icon-fw"></i> {{__('Logout')}}</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->
            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>
