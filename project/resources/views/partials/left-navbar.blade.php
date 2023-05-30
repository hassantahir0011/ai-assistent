<div class="left-menu-section left-menu-collapes" id="">

    <ul class="nav flex-column flex-nowrap overflow-hidden ">
        <li class="nav-item ">
            <a class="nav-link text-truncate" href="{{ route('dashboard') }}"><i class="fa fa-cog menu-icons" aria-hidden="true"></i> <span class=" menu-text">Webhooks Setup</span></a>
        </li>
        <li class="nav-item "><a class="nav-link text-truncate" href="{{ route('registered_webhooks') }}"><i class="fa fa-registered menu-icons" aria-hidden="true"></i> <span class=" menu-text">Registered Webhooks</span></a></li>
        <li class="nav-item"><a class="nav-link text-truncate" href="{{ route('webhook_logs') }}"><i class="fa fa-history menu-icons" aria-hidden="true"></i> <span class=" menu-text">Logs</span></a></li>
        <li class="nav-item dropdown-link0981">
            <a class="nav-link collapsed text-truncate" href="javascript:void(0)" data-toggle="collapse" data-target="#submenu1"><i class="fa fa-user menu-icons" aria-hidden="true"></i> <span class=" menu-text">Account</span></a>

        </li>
        <div class="collapse" id="submenu1" aria-expanded="false">
            <ul class="flex-column nav sub-item-links">
                <li class="nav-item"><a class="nav-link py-0" href="{{ route('plans_listing') }}"><i class="fa fa-money menu-icons" aria-hidden="true"></i><span class="dropdown-child-text">Plan Subscriptions</span></a></li>
                <li class="nav-item"><a class="nav-link py-0" href="{{ route('terms_and_conditions') }}"><i class="fa fa-info-circle menu-icons" aria-hidden="true"></i><span class="dropdown-child-text">Terms and Services</span></a></li>

            </ul>
        </div>
        <li class="nav-item dropdown-link0981">
            <a class="nav-link collapsed text-truncate" href="javascript:void(0)" data-toggle="collapse" data-target="#submenu2"><i class="fa fa-question-circle menu-icons" aria-hidden="true"></i> <span class=" menu-text">Need Help?</span></a>

        </li>
        <div class="collapse" id="submenu2" aria-expanded="false">
            <ul class="flex-column nav sub-item-links">
                <li class="nav-item"><a class="nav-link py-0" href="{{ route('faqs') }}"><i class="fa fa-question-circle menu-icons" aria-hidden="true"></i><span class="dropdown-child-text">Guides &amp; FAQs</span></a></li>

            </ul>
        </div>
    </ul>


</div>