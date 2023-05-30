<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <!-- <li class="nav-item start active open"> -->
            <li class="nav-item {{ request()->routeIs('admin.docs.index') ? 'active' : '' }}">
                <a href="{{ route('admin.docs.index') }}" class="nav-link nav-toggle">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/document_configuration.png')}}" alt="nav-item-icon" class="nav-item-icon">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/document_configuration_white.png')}}" alt="nav-item-icon" class="hover-icon">
                    <span class="title">Docs</span>
                    <!-- <span class="arrow"></span> -->
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.docs.settings') ? 'active' : '' }}">
                <a href="{{ route('admin.docs.settings') }}" class="nav-link nav-toggle">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/settings_icon.png')}}" alt="nav-item-icon" class="nav-item-icon">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/settings_icon_white.png')}}" alt="nav-item-icon" class="hover-icon">
                    <span class="title">Settings</span>
                    <!-- <span class="arrow"></span> -->
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.stores.index') ? 'active' : '' }}">
                <a href="{{ route('admin.stores.index') }}" class="nav-link nav-toggle">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/workshops.png')}}" alt="nav-item-icon" class="nav-item-icon">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/workshops_white.png')}}" alt="nav-item-icon" class="hover-icon">
                    <span class="title">Stores</span>
                    <!-- <span class="arrow"></span> -->
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.stores.logs') ? 'active' : '' }}">
                <a href="{{ route('admin.stores.logs') }}" class="nav-link nav-toggle">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/Transactions_Listing_icon.png')}}" alt="nav-item-icon" class="nav-item-icon">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/Transactions_Listing_icon_white.png')}}" alt="nav-item-icon" class="hover-icon">
                    <span class="title">Webhook Logs</span>
                    <!-- <span class="arrow"></span> -->
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.stores.favoriteconnectorwithwebhookevent') ? 'active' : '' }}">
                <a href="{{ route('admin.stores.favoriteconnectorwithwebhookevent') }}" class="nav-link nav-toggle">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/settings_icon.png')}}" alt="nav-item-icon" class="nav-item-icon">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/settings_icon_white.png')}}" alt="nav-item-icon" class="hover-icon">
                    <span class="title">Favorite Connector With Webhook Event</span>
                    <!-- <span class="arrow"></span> -->
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.stores.notify.api_version.update.view') ? 'active' : '' }}">
                <a href="{{ route('admin.stores.notify.api_version.update.view') }}" class="nav-link nav-toggle">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/vendor_management.png')}}" alt="nav-item-icon" class="nav-item-icon">
                    <img src="{{ URL::asset('assets/images/sidebar-icons/vendor_management_white.png')}}" alt="nav-item-icon" class="hover-icon">
                    <span class="title">Notify API version change</span>
                    <!-- <span class="arrow"></span> -->
                </a>
            </li>

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
