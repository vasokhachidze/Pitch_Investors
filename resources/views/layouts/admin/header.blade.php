@php
$setting_info = \App\Helper\GeneralHelper::setting_info('Company');
@endphp

<nav class="main-header navbar-white navbar-light custom-navbar">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="admin-user-tab">
      <div class="user-panel d-flex">
        <div class="info">
          <a href="{{ url('admin/admin') }}" class="d-block">{{ Session::get('username') }}</a>
        </div>
        <div class="image">
          @if (!empty(Session::get('vImage')))
          <img src="{{ asset('uploads/admin/' . Session::get('vImage')) }}" class="img-circle elevation-2" alt="User Image">
          @else
          <img src="{{ asset('admin/assets/images/default_profile.png') }}" class="img-circle elevation-2" alt="User Image">
          @endif

        </div>

      </div>
    </li>
  </ul>

</nav>