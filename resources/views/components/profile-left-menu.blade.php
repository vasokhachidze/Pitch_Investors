    <div class="col-lg-3 p-0">
        <div class="profile-left">
          <div class="profile-top">
            <img src="../front/assets/img/no-image.png" alt="">
            <h5>Pitch Investors user</h5>
            <h6>user@gmail.com</h6>
          </div>
          <ul>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#"><i class="fa-solid fa-grid-horizontal"></i> Customer Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#"><i class="fa-solid fa-bars"></i> Menu</a></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle show" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                <i class="fa-solid fa-user"></i> My Profile
              </a>
              <ul class="dropdown-menu show" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{url('my-profile')}}"><i class="fa-solid fa-pen"></i> Update Profile</a></li>
                <li><a class="dropdown-item" href="{{url('my-profile/update-email')}}"><i class="fa-solid fa-pen"></i> Update Email</a></li>
                <li><a class="dropdown-item" href="{{url('my-profile/change-password')}}"><i class="fa-solid fa-pen"></i> Update Password</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#"><i class="fa-solid fa-circle-heart"></i> My Favorite</a></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="{{url('logout-user')}}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a></a>
            </li>
          </ul>
        </div>
    </div>