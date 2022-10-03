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
          @can('dashboard_stats')
              <li class="nav-item">
                  <a href="{{ adminUrl('orders') }}" class="nav-link" data-toggle="tooltip" title="show orders">
                      <i class="fa fa-shopping-bag"></i>
                  </a>
              </li>
          @endcan
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
          <!-- Messages Dropdown Menu -->
          @can('show_notifications')
              <li class="nav-item dropdown orders_notification_dropdown" id="userNotifications">
                  <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="far fa-comments"></i>
                      <span class="badge badge-danger navbar-badge">
                          {{ auth()->user()->notifications->where('read_at', '=', '')->count() }}
                      </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                      @foreach (auth()->user()->notifications->where('read_at', '=', '') as $notification)
                          <a href="{{ $notification->data['linkTo'] }}" class="dropdown-item">
                              <!-- Message Start -->
                              <div class="media">
                                  <img src="{{ url('images/purchase-icon.png') }}" alt="User Avatar"
                                      class="img-size-50 mr-3 img-circle">
                                  <div class="media-body">
                                      <h3 class="dropdown-item-title text-primary">
                                          <span
                                              class="badge badge-pill bg-primary">{{ $notification->data['title'] }}</span>
                                          <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                      </h3>
                                      <p class="text-sm">{!! $notification->data['msg'] !!}</p>
                                      <p class="text-sm text-muted">
                                          <i class="far fa-clock mr-1 text-primary"></i>
                                          {{ $notification->created_at }}
                                      </p>
                                  </div>
                              </div>
                              <!-- Message End -->
                          </a>
                          <div class="dropdown-divider"></div>
                      @endforeach

                      @if (auth()->user()->unreadNotifications->count() > 0)
                          <a href="{{ adminUrl('readAllNotifications') }}" class="dropdown-item dropdown-footer bg-primary">
                              <i class="fa fa-reply-all"></i>
                              Select all as read
                          </a>
                      @else
                          <span class="dropdown-item dropdown-footer bg-primary">
                              <i class="fa fa-exclamation-circle"></i>
                              No Orders
                          </span>
                      @endif
                  </div>
              </li>
          @endcan

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
