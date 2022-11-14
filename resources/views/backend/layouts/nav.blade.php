  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
          <li class="nav-item mr-4">
              <a href="{{ url('') }}" class="nav-link px-0" data-toggle="tooltip" title="aller au site"
                  target="_blank">
                  <span class="badge bg-primary"><i class="fa fa-unlock"></i> Dernière connexion: {{ auth()->user()->lastLogin() }}</span>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ url('') }}" class="nav-link px-0" data-toggle="tooltip" title="aller au site"
                  target="_blank">
                  <i class="fa fa-globe"></i>
              </a>
          </li>

          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown mr-4">
              <a class="nav-link" id="show-profile" href="#">
                  <i class="fa fa-user"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                  <a href="{{ route('user.edit_profile') }}" class="dropdown-item">
                      <i class="fa fa-user-o mr-2"></i>
                      <span class="text-muted text-sm">profile</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="{{ adminUrl('logout') }}" class="dropdown-item">
                      <i class="fa fa-sign-out mr-2"></i>
                      <span class="text-muted text-sm">Se déconnecter</span>
                  </a>
              </div>
          </li>
      </ul>
  </nav>
  <!-- /.navbar -->
