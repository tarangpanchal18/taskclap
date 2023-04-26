@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Chartjs', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.CustomAdmin', true)

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">

    <!-- Informative Counter Cards -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
        <div class="inner">
            <h3>{{ $data['totalActiveUser'] }}</h3>
            <p>Active Users</p>
        </div>
        <div class="icon">
            <i class="fas fa-user"></i>
        </div>
        <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
        </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
        <div class="inner">
            <h3>{{ $data['totalCategory'] }}</h3>
            <p>Active Category</p>
        </div>
        <div class="icon">
            <i class="fas fa-certificate"></i>
        </div>
        <a href="{{ route('admin.category.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
        </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
        <div class="inner">
            <h3>{{ $data['totalBanner'] }}</h3>
            <p>Banners Added</p>
        </div>
        <div class="icon">
            <i class="fas fa-credit-card"></i>
        </div>
        <a href="{{ route('admin.banner.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
        </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
        <div class="inner">
            <h3>{{ request()->ip() }}</h3>
            <p>My IP Address</p>
        </div>
        <div class="icon">
            <i class="fas fa-terminal"></i>
        </div>
        <a href="#" class="small-box-footer">&nbsp;</i>
        </a>
        </div>
    </div>

    <!-- Informative Counter Cards -->
    <div class="col-md-4">
        <div class="card card-default">
            <div class="card-header">
            <h3 class="card-title">Category Stats</h3>
            </div>
            <div class="card-body">
                <canvas id="pie-chart-data" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 869px;" width="100%" height="224" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">User Stats</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="bar-chart-data" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 869px;" width="782" height="224" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    var pieChartLable = {!! $chartData["category_label"] !!};
    var pieChartData = {!! $chartData["category"] !!};
    var barChartLable = {!! $chartData["user_label"] !!};
    var barChartData = {!! $chartData["user"] !!};

    generatBarChart('bar-chart-data', barChartLable, barChartData);
    generatPieChart('pie-chart-data', pieChartLable, [{
        data: pieChartData,
        backgroundColor : ['#f56954', '#00a65a'],
    }]);
</script>
@stop
