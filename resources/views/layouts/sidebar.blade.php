<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Logo Panel -->
        <div class="user-panel" style="padding: 38px 0 28px 0;">
            <div style="background: linear-gradient(135deg, #e0e7ff 0%, #f0f4ff 100%); border-radius: 19px; box-shadow: 0 6px 24px rgba(63,92,209,0.10); width: 60%; margin: 0 auto 18px auto; display: flex; align-items: center; justify-content: center; padding: 1px 0; position: relative; z-index: 1;">
                <img src="{{ asset('assets/img/Ryoshka Logo.svg') }}" alt="Ryoshka Logo" style="width: 168%; max-width: 380px; height: auto; display: block; box-shadow: 0 4px 18px rgba(63,92,209,0.18); border: 4px solid #fff; border-radius: 18px; background: #fff; position: relative; z-index: 2; margin-top: -60px; margin-bottom: -60px;">
            </div>
        </div>
        <!-- Log on to codeastro.com for more projects! -->
        <!-- search form (Optional) -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- <li class="header">Functions</li> -->
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li><a href="{{ route('products.index') }}"><i class="fa fa-cubes"></i> <span>Product</span></a></li>
            <li><a href="{{ route('categories.index') }}"><i class="fa fa-list"></i> <span>Category</span></a></li>
            <li><a href="{{ route('customers.index') }}"><i class="fa fa-users"></i> <span>Customer</span></a></li>
            <!-- <li><a href="{{ route('sales.index') }}"><i class="fa fa-cart-plus"></i> <span>Penjualan</span></a></li> -->
            <li><a href="{{ route('suppliers.index') }}"><i class="fa fa-truck"></i> <span>Supplier</span></a></li>
            <li><a href="{{ route('productsOut.index') }}"><i class="fa fa-minus"></i> <span>Outgoing Products</span></a></li>
            <li><a href="{{ route('productsIn.index') }}"><i class="fa fa-cart-plus"></i> <span>Purchase Products</span></a></li>
            <li><a href="{{ route('user.index') }}"><i class="fa fa-user-secret"></i> <span>System Users</span></a></li>








        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

<style>
.sidebar-menu > li > a {
    font-size: 1.15em !important;
    padding: 14px 18px 14px 26px !important;
    color: #fff !important;
    display: flex;
    align-items: center;
    border-radius: 8px;
    margin: 7px 10px !important;
    transition: background 0.18s, color 0.18s, transform 0.18s;
    font-weight: 500;
    letter-spacing: 0.01em;
}
.sidebar-menu > li > a > i {
    font-size: 1.25em !important;
    margin-right: 14px !important;
    width: 24px;
    text-align: center;
}
.user-panel .info p {
    font-size: 1.08em !important;
    font-weight: 600;
    margin-bottom: 2px;
    color: #fff;
    letter-spacing: 0.01em;
}
.user-panel .info a {
    font-size: 0.98em !important;
}
@media (max-width: 991px) {
    .sidebar-menu > li > a {
        font-size: 1em !important;
        padding: 10px 10px 10px 14px !important;
    }
    .sidebar-menu > li > a > i {
        font-size: 1em !important;
        margin-right: 8px !important;
        width: 18px;
    }
    .user-panel .info p {
        font-size: 0.98em !important;
    }
}
</style>
