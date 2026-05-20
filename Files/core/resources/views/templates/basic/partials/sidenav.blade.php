<div class="sidebar-menu">
    <span class="sidebar-menu__close d-lg-none d-inline-flex"><i class="las la-times"></i></span>
    <div class="sidebar-logo d-lg-none d-blcok">
        <a class="sidebar-logo__link ms-auto" href="{{ route('home') }}">
            <img src="{{ siteLogo('dark') }}" alt="@lang('Site Logo')">
        </a>
    </div>
    <ul class="sidebar-menu-list">
        <li class="sidebar-menu-list__item {{ menuActive('user.home') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.home') }}">
                <span class="icon"><i class="las la-tachometer-alt"></i></span>
                <span class="text">@lang('Dashboard')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item has-dropdown ">
            <a class="sidebar-menu-list__link {{ menuActive('user.order*', 3) }}" href="javascript:void(0)">
                <span class="icon"><i class="las la-shopping-cart"></i></span>
                <span class="text">@lang('Manage Orders')</span>
            </a>
            <div class="sidebar-submenu {{ menuActive('user.order*', 2) }}">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item {{ menuActive('user.order.overview') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.order.overview') }}">
                            <span class="text">@lang('New Order')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.order.mass') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.order.mass') }}">
                            <span class="text">@lang('Mass Orders')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.order.history') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.order.history') }}">
                            <span class="text">@lang('All Orders')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.order.pending') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.order.pending') }}">
                            <span class="text">@lang('Pending Orders')</span>
                            @if ($pendingOrders)
                                <span class="badge menu-badge pill bg--danger ms-auto">{{ $pendingOrders }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.order.processing') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.order.processing') }}">
                            <span class="text">@lang('Processing Orders')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.order.completed') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.order.completed') }}">
                            <span class="text">@lang('Completed Orders')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.order.cancelled') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.order.cancelled') }}">
                            <span class="text">@lang('Cancelled Orders')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.order.refunded') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.order.refunded') }}">
                            <span class="text">@lang('Refunded Orders')</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="sidebar-menu-list__item has-dropdown ">
            <a class="sidebar-menu-list__link {{ menuActive('user.dripfeed*', 3) }}" href="javascript:void(0)">
                <span class="icon"><i class="las la-fill-drip"></i></span>
                <span class="text">@lang('Dripfeed')</span>
            </a>
            <div class="sidebar-submenu {{ menuActive('user.dripfeed*', 2) }}">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item {{ menuActive('user.dripfeed.overview') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.dripfeed.overview') }}">
                            <span class="text">@lang('Dripfeed Order')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.dripfeed.history') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.dripfeed.history') }}">
                            <span class="text">@lang('All Orders')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.dripfeed.pending') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.dripfeed.pending') }}">
                            <span class="text">@lang('Pending Orders')</span>
                            @if ($pendingDripfeedOrders)
                                <span class="badge menu-badge pill bg--warning ms-auto">{{ $pendingDripfeedOrders }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.dripfeed.processing') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.dripfeed.processing') }}">
                            <span class="text">@lang('Processing Orders')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.dripfeed.completed') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.dripfeed.completed') }}">
                            <span class="text">@lang('Completed Orders')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.dripfeed.cancelled') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.dripfeed.cancelled') }}">
                            <span class="text">@lang('Cancelled Orders')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.dripfeed.refunded') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.dripfeed.refunded') }}">
                            <span class="text">@lang('Refunded Orders')</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.refill.index') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.refill.index') }}">
                <span class="icon"><i class="lab la-dropbox"></i></span>
                <span class="text">@lang('Refills')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item has-dropdown ">
            <a class="sidebar-menu-list__link {{ menuActive('user.deposit*', 3) }}" href="javascript:void(0)">
                <span class="icon"><i class="las la-wallet"></i></span>
                <span class="text">@lang('Manage Deposit')</span>
            </a>
            <div class="sidebar-submenu {{ menuActive('user.deposit*', 2) }}">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item {{ menuActive('user.deposit.index') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.deposit.index') }}">
                            <span class="text">@lang('Deposit Money') </span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.deposit.history') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.deposit.history') }}">
                            <span class="text">@lang('Deposit History') </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.transactions') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.transactions') }}">
                <span class="icon"><i class="las la-exchange-alt"></i></span>
                <span class="text">@lang('Transactions')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.referrals') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.referrals') }}">
                <span class="icon"><i class="las la-users"></i></span>
                <span class="text">@lang('My Referrals')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.favorite.index') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.favorite.index') }}">
                <span class="icon"> <i class="las la-star-half-alt"></i></span>
                <span class="text">@lang('Favorite Services')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item has-dropdown ">
            <a class="sidebar-menu-list__link {{ menuActive('ticket.*', 3) }}" href="javascript:void(0)">
                <span class="icon"><i class="la la-ticket"></i></span>
                <span class="text">@lang('Support Tickets')</span>
            </a>
            <div class="sidebar-submenu {{ menuActive('ticket.*', 2) }}">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item {{ menuActive('ticket.open') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('ticket.open') }}">
                            <span class="text">@lang('Open New Ticket')</span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('ticket.index') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('ticket.index') }}">
                            <span class="text">@lang('My Tickets')</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="sidebar-menu-list__item has-dropdown">
            <a class="sidebar-menu-list__link {{ menuActive(['user.profile.setting', 'user.change.password', 'user.twofactor'], 3) }}" href="javascript:void(0)">
                <span class="icon"><i class="las la-user"></i></span>
                <span class="text">@lang('Manage Profile')</span>
            </a>
            <div class="sidebar-submenu {{ menuActive(['user.profile.setting', 'user.change.password', 'user.twofactor'], 2) }}">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item {{ menuActive('user.profile.setting') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.profile.setting') }}">
                            <span class="text">@lang('Profile Setting') </span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.change.password') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.change.password') }}">
                            <span class="text">@lang('Change Password') </span>
                        </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{ menuActive('user.twofactor') }}">
                        <a class="sidebar-submenu-list__link" href="{{ route('user.twofactor') }}">
                            <span class="text">@lang('2FA Security') </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.api.index') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.api.index') }}">
                <span class="icon"><i class="las la-cloud-download-alt"></i></span>
                <span class="text">@lang('API')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item">
            <a class="sidebar-menu-list__link" href="{{ route('user.logout') }}">
                <span class="icon"><i class="las la-sign-out-alt"></i></span>
                <span class="text">@lang('Logout')</span>
            </a>
        </li>
    </ul>
</div>
