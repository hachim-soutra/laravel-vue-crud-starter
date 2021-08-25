<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt blue"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/orders" class="nav-link">
          <!-- <i class="nav-icon fas fa-list orange"></i> -->
          <i class="nav-icon fas fa-shopping-cart blue"></i>
          <p>
          Orders
          </p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/products" class="nav-link">
          <!-- <i class="nav-icon fas fa-list orange"></i> -->
          <i class="nav-icon fas fa-chart-bar blue"></i>

          <p>
          Analytics
          </p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/consumers" class="nav-link">
          <i class="nav-icon fas fa-user-check blue"></i>
          <p>
          Customers
          </p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/shippings" class="nav-link">
          <i class="nav-icon fas fa-shipping-fast blue"></i>
          <p>
          Shipping
          </p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/messages" class="nav-link">
          <i class="nav-icon far fa-comments blue"></i>
          <p>
          Messaging
          </p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/products" class="nav-link">
          <i class="nav-icon fas fa-list blue"></i>
          <p>
            Product
          </p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/transactions" class="nav-link">
          <i class="nav-icon fas fa-list blue"></i>
          <p>
            Transaction
          </p>
        </router-link>
      </li>

      @can('isAdmin')
        <li class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-users nav-icon blue"></i>
            <p>Users</p>
          </router-link>
        </li>
      @endcan



      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/product/category" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Category
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/tag" class="nav-link">
              <i class="nav-icon fas fa-tags green"></i>
              <p>
                Tags
              </p>
            </router-link>
          </li>
<!--
            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                  <i class="nav-icon fas fa-cogs blue"></i>
                  <p>
                      Developer
                  </p>
              </router-link>
            </li> -->
        </ul>
      </li>

      @endcan



      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>
