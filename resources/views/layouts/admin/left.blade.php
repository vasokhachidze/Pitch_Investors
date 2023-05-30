@php
$setting_info = \App\Helper\GeneralHelper::setting_info('Company');

$url = Request::segment(2);
$url2 = Request::segment(3);
@endphp

@section('custom-css')
    <style></style>
@endsection

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{-- <a href="{{route('admin.dashboard')}}"> --}}
    <a href="{{ url('admin/admin') }}">
        <img src="{{ asset('uploads/logo/logo.png') }}" alt="Pitch Investors" class="brand-image elevation-3" style="padding: 20px 5px; width: 100%;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar mt-4">
        <!-- Sidebar user panel (optional) -->


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('admin/dashboard') }}" class="nav-link @if ($url == 'dashboard  ') active @endif">
                        <i class="nav-icon fas fa fa-tachometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/admin') }}" class="nav-link @if ($url == 'admin') active @endif">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>Admin</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/user/listing') }}" class="nav-link @if ($url == 'user') active @endif">
                        <i class="pr-2 fas fa-users"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/banner/listing') }}" class="nav-link @if ($url == 'banner') active @endif">
                        <i class="pr-2 fas fa-image"></i>
                        <p>Banner</p>
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="{{ url('admin/plan/listing') }}" class="nav-link @if ($url == 'plan') active @endif">
                        <i class="pr-2 fas fa-credit-card"></i>
                        <p>Plan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/contract/listing') }}" class="nav-link @if ($url == 'contract') active @endif">
                        <i class="pr-2 fas fa-file-contract"></i>

                        <p>Contract</p>
                    </a>
                </li>
                @php
                    if ($url == 'investor' || $url == 'business-advisor' || $url == 'investment') {
                        $active = 'active';
                        $defultopen = 'defultopen';
                    } else {
                        $active = '';
                        $defultopen = '';
                    }
                @endphp
                <li class="nav-item {{ $defultopen }}">
                    <a href="javascript:;" class="nav-link {{ $active }}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item @if ($url == 'investor') {{ $active }} @endif">
                            <a href="{{ url('admin/investor/listing') }}" class="nav-link">
                                <i class="pr-2 fas fa-image"></i>
                                <p>Investor</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url == 'business-advisor') {{ $active }} @endif">
                            <a href="{{ url('admin/business-advisor/listing') }}" class="nav-link">
                                <i class="pr-2 fas fa-image"></i>
                                <p>Business Advisor</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url == 'investment') {{ $active }} @endif">
                            <a href="{{ url('admin/investment/listing') }}" class="nav-link">
                                <i class="pr-2 fas fa-image"></i>
                                <p>Investment</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/contactus/listing') }}" class="nav-link @if ($url == 'contactus') active @endif">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>
                            Contact us
                        </p>
                    </a>
                </li>
                </li>
                {{-- <li class="nav-item">
                  <a href="{{ url('admin/notificationmaster/listing') }}" class="nav-link @if ($url == 'notificationmaster') active @endif">
                    <i class="nav-icon fas fa-user-alt"></i>
                    <p>
                     Notification Master
                    </p>
                  </a>
                </li> --}}
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ url('#') }}"
                        class="nav-link @if ($url == 'admin') {{ $active }} @endif">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>
                            Site Setting
                        </p>
                    </a>
                </li> --}}
                @php
                    if ($url == 'languagelabel' || $url == 'testimonial' || $url == 'industry' || $url == 'region' || $url == 'county' || $url == 'subCounty') {
                        $active = 'active';
                        $defultopen = 'defultopen';
                    } else {
                        $active = '';
                        $defultopen = '';
                    }
                @endphp
                <li class="nav-item {{ $defultopen }}">
                    <a href="javascript:;" class="nav-link {{ $active }}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Master
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item @if ($url == 'languagelabel') {{ $active }} @endif">
                            <a href="{{ url('admin/languagelabel/listing') }}" class="nav-link">
                                <i class="pr-2 fa fa-industry"></i>
                                <p>Language Label</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url == 'testimonial') {{ $active }} @endif">
                            <a href="{{ url('admin/testimonial/listing') }}" class="nav-link">
                                <i class="pr-2 fa fa-industry"></i>
                                <p>Testimonial</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url == 'industry') {{ $active }} @endif">
                            <a href="{{ url('admin/industry/listing') }}" class="nav-link ">
                                <i class="pr-2 fas fa-image"></i>
                                <p>Category / Industry</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url == 'region') {{ $active }} @endif">
                            <a href="{{ url('admin/region/listing') }}" class="nav-link ">
                                <i class="pr-2 fas fa-image"></i>
                                <p>Region</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url == 'county') {{ $active }} @endif">
                            <a href="{{ url('admin/county/listing') }}" class="nav-link ">
                                <i class="pr-2 fas fa-image"></i>
                                <p>County</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url == 'subCounty') {{ $active }} @endif">
                            <a href="{{ url('admin/subCounty/listing') }}" class="nav-link ">
                                <i class="pr-2 fas fa-image"></i>
                                <p>Sub County</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="nav-item">
            <a href="{{ url('admin/homepage/homepage') }}" class="nav-link @if ($url2 == 'homepage') active @endif">
            <i class="homeleft-main ml-1 pr-1 fas fa-home"></i>
              <p>
              Home Page
              </p>
            </a>
          </li> -->
                @php
                    if ($url == 'system_email') {
                        $active = 'active';
                        $defultopen = 'defultopen';
                    } else {
                        $active = '';
                        $defultopen = '';
                    }
                @endphp
                <li class="nav-item @if ($url == 'system_email') defultopen @endif">
                    <a href="javascript:;" class="nav-link @if ($url == 'system_email' || $url == 'notification_master' || $url == 'contact_us') active @endif">
                        <i class="nav-icon fas fa-envelope-open-text"></i>
                        <p>
                            Email
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item @if ($url == 'system_email') {{ $active }} @endif">
                            <a href="{{ url('admin/system_email/listing') }}" class="nav-link">
                                <i class="pl-2 pr-2 fas fa-envelope"></i>
                                <p>System Email</p>
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                        <a href="{{ url('admin/cmspage/listing') }}" class="nav-link @if ($url == 'cmspage') active @endif">
                          <i class="nav-icon fas fa-user-alt"></i>
                          <p>
                            Cms Pages
                          </p>
                        </a>
                      </li> --}}
                    </ul>
                </li>
                @php
                    if ($url2 == 'Appearance' || $url2 == 'Email' || $url2 == 'Company' || $url2 == 'Social' || $url2 == 'Currency') {
                        $active = 'active';
                        $defultopen = 'defultopen';
                    } else {
                        $active = '';
                        $defultopen = '';
                    }
                @endphp
                <li class="nav-item">
                    <a href="{{ url('admin/pageSetting/listing') }}" class="nav-link @if ($url == 'pageSetting') active @endif">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Page Setting
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ $defultopen }} ">
                    <a href="javascript:;" class="nav-link {{ $active }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Setting
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">

                        <li class="nav-item @if ($url2 == 'Email') {{ $active }} @endif">
                            <a href="{{ url('admin/setting/Email') }}" class="nav-link">
                                <i class="pr-2 same-icon fas fa-envelope"></i>
                                <p>Email Setting</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url2 == 'Company') {{ $active }} @endif">
                            <a href="{{ url('admin/setting/Company') }}" class="nav-link">
                                <i class="pr-2 same-icon fas fa-info"></i>
                                <p>Company Info</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url2 == 'Appearance') {{ $active }} @endif">
                            <a href="{{ url('admin/setting/Appearance') }}" class="nav-link">
                                <i class="pr-2 same-icon fas fa-cogs"></i>
                                <p>General Setting</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url2 == 'Social') {{ $active }} @endif">
                            <a href="{{ url('admin/setting/Social') }}" class="nav-link">
                                <i class="pr-2 fab same-icon fa-google-plus-g"></i>
                                <p>Social Info</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url2 == 'Currency') {{ $active }} @endif">
                            <a href="{{ url('admin/setting/Currency') }}" class="nav-link">
                                <i class="pr-2 fab same-icon fa-google-plus-g"></i>
                                <p>Payment Setting</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @php
                    if ($url == 'connection' || $url == 'premium_service' ) {
                        $active = 'active';
                        $defultopen = 'defultopen';
                    } else {
                        $active = '';
                        $defultopen = '';
                    }
                @endphp
                <li class="nav-item {{ $defultopen }}">
                    <a href="javascript:;" class="nav-link {{ $active }}">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item @if ($url == 'connection') {{ $active }} @endif">
                            <a href="{{ url('admin/connection/listing') }}" class="nav-link">
                                <i class="pr-2 fas fa-clone"></i>
                                <p>Connection Requests</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($url == 'premium_service') {{ $active }} @endif">
                            <a href="{{ url('admin/premium_service/listing') }}" class="nav-link">
                                <i class="pr-2 fas fa-credit-card"></i>
                                <p>Premium Service Requests</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
