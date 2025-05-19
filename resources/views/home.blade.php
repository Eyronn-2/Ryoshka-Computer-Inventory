@extends('layouts.master')

@section('top')
<style>
    .dashboard-card {
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: none;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
    .dashboard-card .inner {
        padding: 20px;
        position: relative;
        z-index: 2;
    }
    .dashboard-card .icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 80px;
        opacity: 0.4;
        transition: all 0.3s ease;
        z-index: 1;
        color: rgba(255, 255, 255, 0.9);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    .dashboard-card:hover .icon {
        transform: translateY(-50%) scale(1.1);
        opacity: 0.6;
    }
    .dashboard-card h3 {
        font-size: 38px;
        font-weight: bold;
        margin: 0;
        white-space: nowrap;
        padding: 0;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }
    .dashboard-card p {
        font-size: 16px;
        margin-top: 10px;
        font-weight: 500;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }
    .dashboard-card .small-box-footer {
        background: rgba(0, 0, 0, 0.1);
        color: #fff;
        display: block;
        padding: 10px 0;
        position: relative;
        text-align: center;
        text-decoration: none;
        border-radius: 0 0 15px 15px;
        transition: all 0.3s ease;
        z-index: 2;
    }
    .dashboard-card .small-box-footer:hover {
        background: rgba(0, 0, 0, 0.2);
        color: #fff;
    }
    .dashboard-section {
        margin-bottom: 30px;
    }
    .dashboard-section-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
        padding-bottom: 10px;
        border-bottom: 2px solid #f4f4f4;
    }
    .bg-aqua { 
        background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%);
        color: #fff;
    }
    .bg-green { 
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        color: #fff;
    }
    .bg-yellow { 
        background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
        color: #fff;
    }
    .bg-red { 
        background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
        color: #fff;
    }
    .bg-purple { 
        background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%);
        color: #fff;
    }
    .bg-maroon { 
        background: linear-gradient(135deg, #cb2d3e 0%, #ef473a 100%);
        color: #fff;
    }
    .bg-primary { 
        background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
        color: #fff;
    }
    .bg-orange { 
        background: linear-gradient(135deg, #f46b45 0%, #eea849 100%);
        color: #fff;
    }
    .bg-danger { 
        background: linear-gradient(135deg, #ff512f 0%, #dd2476 100%);
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Overview Section -->
    <div class="dashboard-section">
        <h2 class="dashboard-section-title">System Overview</h2>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ \App\User::count() }}</h3>
                        <p>System Users</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-secret"></i>
                    </div>
                    <a href="/user" class="small-box-footer">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card small-box bg-green">
                    <div class="inner">
                        <h3>{{ \App\Category::count() }}</h3>
                        <p>Categories</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list"></i>
                    </div>
                    <a href="{{ route('categories.index') }}" class="small-box-footer">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ \App\Product::count() }}</h3>
                        <p>Products</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cubes"></i>
                    </div>
                    <a href="{{ route('products.index') }}" class="small-box-footer">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card small-box bg-red">
                    <div class="inner">
                        <h3>{{ \App\Customer::count() }}</h3>
                        <p>Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="{{ route('customers.index') }}" class="small-box-footer">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card small-box bg-info" style="background: linear-gradient(135deg, #757f9a 0%, #d7dde8 100%); color: #fff;">
                    <div class="inner">
                        <h3>{{ \App\Product::where('is_archived', true)->count() }}</h3>
                        <p>Archived Products</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-archive"></i>
                    </div>
                    <a href="{{ route('products.index') }}" class="small-box-footer">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Section -->
    <div class="dashboard-section">
        <h2 class="dashboard-section-title">Inventory Management</h2>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card small-box bg-purple">
                    <div class="inner">
                        <h3>{{ \App\Supplier::count() }}</h3>
                        <p>Suppliers</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-signal"></i>
                    </div>
                    <a href="{{ route('suppliers.index') }}" class="small-box-footer">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card small-box bg-maroon">
                    <div class="inner">
                        <h3>{{ \App\Product_In::count() }}</h3>
                        <p>Total Purchases</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cart-plus"></i>
                    </div>
                    <a href="{{ route('productsIn.index') }}" class="small-box-footer">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card small-box bg-primary">
                    <div class="inner">
                        <h3>{{ \App\Product_Out::count() }}</h3>
                        <p>Total Outgoing</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-minus"></i>
                    </div>
                    <a href="{{ route('productsOut.index') }}" class="small-box-footer">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Alerts Section -->
    <div class="dashboard-section">
        <h2 class="dashboard-section-title">Stock Alerts</h2>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card small-box bg-orange">
                    <div class="inner">
                        <h3>{{ \App\Product::where('quantity', '<', 5)->where('quantity', '>', 0)->count() }}</h3>
                        <p>Low Stock Products</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <a href="{{ route('products.index') }}" class="small-box-footer">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card small-box bg-danger">
                    <div class="inner">
                        <h3>{{ \App\Product::where('quantity', 0)->count() }}</h3>
                        <p>Out of Stock Products</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-times-circle"></i>
                    </div>
                    <a href="{{ route('products.index') }}" class="small-box-footer">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('top')
@endsection
