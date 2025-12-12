<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{-- <li class=" nav-item"><a href="{{ asset('assets/dashboard') }}/index.html"><i class="la la-home"></i><span class="menu-title"
                        data-i18n="nav.dash.main">Dashboard</span><span
                        class="badge badge badge-info badge-pill float-right mr-2">3</span></a>
                <ul class="menu-content">
                    <li class="active"><a class="menu-item" href="{{ asset('assets/dashboard') }}/dashboard-ecommerce.html"
                            data-i18n="nav.dash.ecommerce">eCommerce</a>
                    </li>
                    <li><a class="menu-item" href="{{ asset('assets/dashboard') }}/dashboard-crypto.html" data-i18n="nav.dash.crypto">Crypto</a>
                    </li>
                    <li><a class="menu-item" href="{{ asset('assets/dashboard') }}/dashboard-sales.html" data-i18n="nav.dash.sales">Sales</a>
                    </li>
                </ul>
            </li> --}}
            <li class=" nav-item {{ Request::is('*/home*') ? 'active' : '' }}"><a href="{{ route('dashboard.home') }}"><i
                        class="la la-home"></i><span class="menu-title"
                                                     data-i18n="nav.disabled_menu.main">@lang('dashboard.dashboard')</span></a>
            </li>
            @can('roles')
                <li class=" nav-item {{ Request::is('*/roles*') ? 'open active' : '' }}"><a href="#"><i
                            class="la la-television"></i><span class="menu-title"
                                                               data-i18n="nav.templates.main">@lang('dashboard.roles')</span></a>
                    <ul class="menu-content">
                        <li class="{{ Request::is('*/roles*') ? 'is-shown' : '' }}">
                            <a class="menu-item" href="{{ route('dashboard.roles.create') }}"
                               data-i18n="">@lang('dashboard.add_roles')</a>
                        </li>
                        <li class="{{ Request::is('*/roles*') ? 'is-shown' : '' }}">
                            <a class="menu-item" href="{{ route('dashboard.roles.index') }}"
                               data-i18n="">@lang('dashboard.roles')</a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('users')
                <li class=" nav-item {{ Request::is('*/users*') ? 'open active' : '' }}"><a href="#"><i
                            class="la la-television"></i><span class="menu-title"
                                                               data-i18n="nav.templates.main">@lang('dashboard.users')</span></a>
                    <ul class="menu-content">
                        <li class="{{ Request::is('*/users*') ? 'is-shown' : '' }}">
                            <a class="menu-item" href="{{ route('dashboard.users.create') }}"
                               data-i18n="">@lang('dashboard.add_user')</a>
                        </li>
                        <li class="{{ Request::is('*/users*') ? 'is-shown' : '' }}">
                            <a class="menu-item" href="{{ route('dashboard.users.index') }}"
                               data-i18n="">@lang('dashboard.users')</a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('clients')
                <li class=" nav-item {{ Request::is('*/clients*') ? 'open' : '' }}">
                    <a href="#"><i class="la la-home">
                        </i><span class="menu-title" data-i18n="nav.dash.main">@lang('dashboard.clients')</span><span
                            class="badge badge badge-info badge-pill float-right mr-2">0</span></a>
                    <ul class="menu-content">
                        <li class="{{ Request::is('*/clients') ? 'active' : '' }}"><a class="menu-item"
                                                                                         href="{{ route('dashboard.clients.index') }}"
                                                                                         data-i18n="nav.dash.ecommerce">@lang('dashboard.clients')</a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('invoices')
                <li class=" nav-item {{ Request::is('*/invoices*') ? 'open' : '' }}">
                    <a href="#"><i class="la la-home">
                        </i><span class="menu-title" data-i18n="nav.dash.main">@lang('dashboard.invoices')</span><span
                            class="badge badge badge-info badge-pill float-right mr-2">0</span></a>
                    <ul class="menu-content">
                        <li class="{{ Request::is('*/invoices') ? 'active' : '' }}"><a class="menu-item"
                                                                                     href="{{ route('dashboard.invoices.index') }}"
                                                                                     data-i18n="nav.dash.ecommerce">@lang('dashboard.invoices')</a>
                        </li>


                    </ul>
                </li>
            @endcan

        </ul>
    </div>
</div>
