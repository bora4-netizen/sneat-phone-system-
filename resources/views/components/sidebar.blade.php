<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand custom">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo custom">
                <img src="{{ $company->image_logo }}" alt="logo" width="50px"/>
            </span>
            <span class="app-brand-text custom menu-text fw-bolder ms-2">{{ $company->name ?? ''}}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item{{ (request()->routeIs('dashboard')) ? ' active' : '' }}">
            <a href="{{ route('dashboard', withLang()) }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">{{__('sidebar.dashboard')}}</div>
            </a>
        </li>


        @can(['customer-list'], ['customer-create'])
        <!-- Customers Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">{{__('sidebar.customer.title')}}</span></li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-male-female"></i>
                <div data-i18n="{{__('sidebar.product_info.category')}}">{{__('customer.menu.title')}}</div>
            </a>
            <ul class="menu-sub">
              @can(['customer-list'])
              <li class="menu-item">
                <a href="{{ route('customers.create', withLang()) }}" class="menu-link">
                  <div data-i18n="{{__('common.lbl_add_new')}}">{{__('common.lbl_add_new')}}</div>
                </a>
              </li>
              @endif
              @can(['customer-create'])
              <li class="menu-item">
                <a href="{{ route('customers.index', withLang()) }}" class="menu-link">
                  <div data-i18n="{{__('sidebar.product_info.model_type')}}">{{__('customer.menu.list')}}</div>
                </a>
              </li>
              @endif
            </ul>
        </li>
        <!-- /Customers Management -->
        @endif

        <!-- Shop Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">{{__('sidebar.shop.title')}}</span></li>
         <!-- Product Management -->
        @can(['product-list'], ['product-create'])
        <li class="menu-item {{ (request()->routeIs('products*')) ? ' active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="{{__('sidebar.shop.product')}}">{{__('sidebar.shop.product')}}</div>
            </a>
            <ul class="menu-sub">
                @can('product-create')
                  <li class="menu-item {{ (request()->routeIs('products.create')) ? ' active' : '' }}">
                    <a href="{{ route('products.create', withLang()) }}" class="menu-link">
                        <div data-i18n="{{__('comman.lbl_add_new')}}">{{__('common.lbl_add_new')}}</div>
                    </a>
                  </li>
                @endcan
                @can('product-list')
                  <li class="menu-item{{ (request()->routeIs('products.index')) ? ' active' : '' }}">
                      <a href="{{ route('products.index', withLang()) }}" class="menu-link">
                          <div data-i18n="{{__('sidebar.shop.product_list')}}">{{__('sidebar.shop.product_list')}}</div>
                      </a>
                  </li>
                @endcan
            </ul>
        </li>
        @endcan
        <!-- /Product Management -->
        <!-- Product Items Management -->
        <li class="menu-item{{ (request()->routeIs('model_type*')) ? ' active open' : '' }}{{ (request()->routeIs('color*')) ? ' active open' : '' }}{{ (request()->routeIs('serial*')) ? ' active open' : '' }}{{ (request()->routeIs('storage*')) ? ' active open' : '' }}{{ (request()->routeIs('brand*')) ? ' active open' : '' }}{{ (request()->routeIs('network*')) ? ' active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-memory-card"></i>
                <div data-i18n="{{__('sidebar.product_info.category')}}">{{__('sidebar.product_info.category')}}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item{{ (request()->routeIs('model_type.index')) ? ' active' : '' }}">
                    <a href="{{ route('model_type.index', withLang()) }}" class="menu-link">
                        <div data-i18n="{{__('sidebar.product_info.model_type')}}">{{__('sidebar.product_info.model_type')}}</div>
                    </a>
                </li>

                <li class="menu-item{{ (request()->routeIs('color.index')) ? ' active' : '' }}">
                    <a href="{{ route('color.index', withLang()) }}" class="menu-link">
                        <div data-i18n="{{__('sidebar.product_info.color')}}">{{__('sidebar.product_info.color')}}</div>
                    </a>
                </li>

                <li class="menu-item{{ (request()->routeIs('serial.index')) ? ' active' : '' }}">
                  <a href="{{ route('serial.index', withLang()) }}" class="menu-link">
                      <div data-i18n="{{__('sidebar.product_info.serial')}}">{{__('sidebar.product_info.serial')}}</div>
                  </a>
                </li>


                <li class="menu-item{{ (request()->routeIs('storage.index')) ? ' active' : '' }}">
                  <a href="{{ route('storage.index', withLang()) }}" class="menu-link">
                      <div data-i18n="{{__('sidebar.product_info.storage')}}">{{__('sidebar.product_info.storage')}}</div>
                  </a>
                </li>


                <li class="menu-item{{ (request()->routeIs('brand.index')) ? ' active' : '' }}">
                  <a href="{{ route('brand.index', withLang()) }}" class="menu-link">
                      <div data-i18n="{{__('sidebar.product_info.brand')}}">{{__('sidebar.product_info.brand')}}</div>
                  </a>
                </li>

                <li class="menu-item{{ (request()->routeIs('network.index')) ? ' active' : '' }}">
                  <a href="{{ route('network.index', withLang()) }}" class="menu-link">
                      <div data-i18n="{{__('sidebar.product_info.network')}}">{{__('sidebar.product_info.network')}}</div>
                  </a>
                </li>

            </ul>
        </li>
        <!-- /Product Items Management -->


        <!-- Expense Management -->
        @can(['expense-list'], ['expense-create'])
        <li class="menu-item{{ (request()->routeIs('expenses*')) ? ' active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa-solid fa-money-bill-transfer"></i>
                <div data-i18n="{{__('expense.title')}}">{{__('expense.title')}}</div>
            </a>
            <ul class="menu-sub">
                @can('expense-list')
                @can('expense-create')
                <li class="menu-item {{ (request()->routeIs('expenses.create')) ? ' active' : '' }}">
                  <a href="{{ route('expenses.create', withLang()) }}" class="menu-link">
                      <div data-i18n="{{__('common.lbl_add_new')}}">{{__('common.lbl_add_new')}}</div>
                  </a>
                </li>
                @endcan
                  <li class="menu-item {{ (request()->routeIs('expenses.index')) ? ' active' : '' }}">
                      <a href="{{ route('expenses.index', withLang()) }}" class="menu-link">
                          <div data-i18n="{{__('expense.title')}}">{{__('expense.title')}}</div>
                      </a>
                  </li>
                @endcan
            </ul>
        </li>
        @endcan
        <!-- /Expense Management -->
        <!-- Order Management -->
        @can(['order-list'], ['order-create'])
        <li class="menu-item{{ (request()->routeIs('sales*') && !request()->routeIs('orders*')) ? ' active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-cart-alt"></i>
                <div data-i18n="{{__('sidebar.shop.product')}}">{{__('sidebar.shop.sales.title')}}</div>
            </a>
            <ul class="menu-sub">
                @can('order-create')
                  <li class="menu-item{{ (request()->routeIs('sales.create')) ? ' active' : '' }}">
                      <a href="{{ route('sales.create', withLang()) }}" class="menu-link">
                          <div data-i18n="{{__('common.lbl_add_new')}}">{{__('common.lbl_add_new')}}</div>
                      </a>
                  </li>
                @endcan
                @can('order-list')
                  <li class="menu-item{{ (request()->routeIs('sales.index')) ? ' active' : '' }}">
                      <a href="{{ route('sales.index', withLang()) }}" class="menu-link">
                          <div data-i18n="{{__('sidebar.shop.orders.invoices_list')}}">{{__('sidebar.shop.orders.invoices_list')}}</div>
                      </a>
                  </li>
                @endcan
            </ul>
        </li>
        @endcan
        <!-- /Expense Management -->
        <!-- Loan Management -->
        @can(['loan-list'], ['loan-create'], ['loan-payment-list'])
        <li class="menu-item{{ (request()->routeIs('loans*')) ? ' active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa-solid fa-hand-holding-dollar"></i>
                <div data-i18n="{{__('loan.title')}}">{{__('loan.title')}}</div>
            </a>
            <ul class="menu-sub">
                @can('loan-create')
                  <li class="menu-item{{ (request()->routeIs('loans.create')) ? ' active' : '' }}">
                      <a href="{{ route('loans.create', withLang()) }}" class="menu-link">
                          <div data-i18n="{{__('common.lbl_add_new')}}">{{__('common.lbl_add_new')}}</div>
                      </a>
                  </li>
                @endcan
                @can('loan-list')
                  <li class="menu-item{{ (request()->routeIs('loans.index')) ? ' active' : '' }}">
                      <a href="{{ route('loans.index', withLang()) }}" class="menu-link">
                          <div data-i18n="{{__('loan.list')}}">{{__('loan.list')}}</div>
                      </a>
                  </li>
                @endcan
                @can('loan-payment-list')
                  <li class="menu-item{{ (request()->routeIs('loans.payments.index')) ? ' active' : '' }}">
                      <a href="{{ route('loans.payments.index', withLang()) }}" class="menu-link">
                          <div data-i18n="{{__('loan.payment.title')}}">{{__('loan.payment.title')}}</div>
                      </a>
                  </li>
                @endcan
                @can('loan-payment-list')
                  <li class="menu-item{{ (request()->routeIs('loans.payments.late')) ? ' active' : '' }}">
                      <a href="{{ route('loans.payments.late', withLang()) }}" class="menu-link">
                          <div data-i18n="{{__('loan.late_payment')}}">{{__('loan.late_payment')}}</div>
                      </a>
                  </li>
                @endcan
            </ul>
        </li>
        @endcan
        <!-- /Loan Management -->
        <!-- POS Management -->
        {{-- ✅ FIX --}}
@can(['order-create'])

<li class="menu-item{{ (request()->routeIs('orderCustomer*')) ? ' active' : '' }}">
    <a href="{{ route('orderCustomer.index', withLang()) }}" class="menu-link">
      <i class="menu-icon tf-icons fa-solid fa-cash-register"></i>
      <div data-i18n="{{__('sidebar.shop.orders.title')}}">{{__('sidebar.shop.orders.title')}}</div>
  </a>
</li>
@endcan
        <!-- /POS Management -->
        <!-- Report Management -->
        @can(['report-list'])
        <li class="menu-item{{ (request()->routeIs('reports*')) ? ' active open' : '' }}">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons fa-solid fa-chart-line"></i>
            <div data-i18n="{{__('report.title')}}">{{__('report.title')}}</div>
          </a>
          @can('role-list')
          <ul class="menu-sub">
              <li class="menu-item{{ (request()->routeIs('reports.product')) ? ' active' : '' }}">
                <a href="{{ route('reports.product', withLang()) }}" class="menu-link">
                    <div data-i18n="{{__('report.product.title')}}">{{__('report.product.title')}}</div>
                </a>
              </li>
              <li class="menu-item{{ (request()->routeIs('reports.stock')) ? ' active' : '' }}">
                  <a href="{{ route('reports.stock', withLang()) }}" class="menu-link">
                      <div data-i18n="Role Management">{{__('report.stock.title')}}</div>
                  </a>
              </li>
              <li class="menu-item{{ (request()->routeIs('reports.expense')) ? ' active' : '' }}">
                <a href="{{ route('reports.expense', withLang()) }}" class="menu-link">
                    <div data-i18n="Role Management">{{__('report.expense.title')}}</div>
                </a>
              </li>
              <li class="menu-item{{ (request()->routeIs('reports.sale')) ? ' active' : '' }}">
                <a href="{{ route('reports.sale', withLang()) }}" class="menu-link">
                  <div data-i18n="Role Management">{{__('report.sale.title')}}</div>
                </a>
              </li>
              <li class="menu-item{{ (request()->routeIs('reports.loan')) ? ' active' : '' }}">
                <a href="{{ route('reports.loan', withLang()) }}" class="menu-link">
                    <div data-i18n="Role Management">{{__('report.loan.title')}}</div>
                </a>
              </li>
              <li class="menu-item{{ (request()->routeIs('reports.profit-loss')) ? ' active' : '' }}">
                <a href="{{ route('reports.profit-loss', withLang()) }}" class="menu-link">
                    <div data-i18n="Role Management">{{__('report.profit_loss.title')}}</div>
                </a>
              </li>
          </ul>
          @endcan
        </li>
        @endcan
        <!-- /Report Management -->
        <!-- /Shop Management -->
        <!-- User Management-->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">{{__('sidebar.shop.setting')}}</span></li>
        @can('company-setting-edit')
        <li class="menu-item{{ (request()->routeIs('company*')) ? ' active' : '' }}">
          <a href="{{ route('company.index', withLang()) }}" class="menu-link">
            <i class="menu-icon tf-icons fa-solid fa-shop"></i>
            <div data-i18n="Shop Information">{{__('sidebar.shop.info')}}</div>
        </a>
        </li>
        @endcan
        <li class="menu-header small text-uppercase"><span class="menu-header-text">{{__('sidebar.user.management')}}</span></li>
        @can('role-list')
        <li class="menu-item{{ (request()->routeIs('roles*')) ? ' active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa-solid fa-users-gear"></i>
                <div data-i18n="User Setting">{{__('sidebar.user.setting')}}</div>
            </a>
            @can('role-list')
            <ul class="menu-sub">
                <li class="menu-item{{ (request()->routeIs('roles.index')) ? ' active' : '' }}">
                    <a href="{{ route('roles.index', withLang()) }}" class="menu-link">
                        <div data-i18n="Role Management">{{__('sidebar.user.role')}}</div>
                    </a>
                </li>
            </ul>
            @endcan
        </li>
        @endcan
        @can(['user-list'], ['user-create'])
        <li class="menu-item{{ (request()->routeIs('users*')) ? ' active open' : '' }} {{ (request()->routeIs('register')) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-user"></i>
                <div data-i18n="User">{{__('sidebar.user.user')}}</div>
            </a>
            <ul class="menu-sub">
                @can('user-list')
                <li class="menu-item{{ (request()->routeIs('users.index')) ? ' active' : '' }}">
                    <a href="{{ route('users.index', withLang()) }}" class="menu-link">
                        <div data-i18n="Notifications">{{__('sidebar.user.list')}}</div>
                    </a>
                </li>
                @endcan
                @can('user-create')
                <li class="menu-item{{ (request()->routeIs('register')) ? ' active' : '' }}">
                    <a href="{{ route('register', withLang()) }}" class="menu-link">
                        <div data-i18n="Account">{{__('sidebar.user.add')}}</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
    </ul>
</aside>
<!-- / Menu -->
