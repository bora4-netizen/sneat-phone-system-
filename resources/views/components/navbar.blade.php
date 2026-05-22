<!-- Navbar -->
<nav class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar" >
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
          @if (app()->getLocale() == 'kh')
          <li class="nav-item lh-1 me-3">
              <a class=""
            href="{{ $route }}"
        ><img src="{{ asset('/assets/img/icons/united-states_icon.png')}}" alt="EN"></a>
      </li>
      @else
          <li class="nav-item lh-1 me-3">
              <a class=""
                  href="{{ $route  }}"
              ><img src="{{ asset('/assets/img/icons/cambodia-icon.png')}}" alt="KH"></a>
          </li>
      @endif
             <!-- Notification -->
          <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <i class="bx bx-bell bx-sm"></i>
              <span class="badge bg-danger rounded-pill badge-notifications">{{ $countOverdueLoans }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end py-0">
              <li class="dropdown-menu-header border-bottom">
                <div class="dropdown-header d-flex align-items-center py-3">
                  <h5 class="text-body mb-0 me-auto">Notification</h5>
                  <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="menu-icon tf-icons fa-solid fa-hand-holding-dollar"></i></a>
                </div>
              </li>
              <li class="dropdown-notifications-list scrollable-container">
                <ul class="list-group list-group-flush">
                  @foreach ($overdueLoans as $value)
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <a href="{{ route('loans.edit', withLang(['loan' => $value->id])) }}">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <img src="{{ $value->customer->profile_image }}" alt="" class="w-px-40 h-auto rounded-circle">
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $value->customer->name }}</h6>
                        <p class="mb-0">{{ setToStringDolla($value->monthly_payment) }}</p>
                        <small class="text-muted">{{ $value->overdueDays}} {{ __('common.lbl_ago')}}</small>
                      </div>
                    </div>
                  </a>
                  </li>
                  @endforeach
                </ul>
              </li>
              <li class="dropdown-menu-footer border-top p-3">
                <a href="{{ route('loans.payments.late', withLang())}}" class="btn btn-primary text-uppercase w-100">{{ __('common.lbl_view_all')}}</a>
              </li>
            </ul>
          </li>
          <!--/ Notification -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{ Auth::user()->getProfile() }}" alt class="w-px-40 h-auto rounded-circle" onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-profile.png') }}';"/>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                  <img src="{{ Auth::user()->getProfile() }}" alt class="w-px-40 h-auto rounded-circle" onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-profile.png') }}';"/>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                <small class="text-muted">{{ Auth::user()->getPosition() }}</small>
                            </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('users.edit.profile', withLang()) }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">{{ __('button.profile') }}</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout', withLang()) }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">{{ __('button.logout') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout', withLang()) }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
<!-- / Navbar -->
