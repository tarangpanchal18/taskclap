@extends('adminlte::page')
@section('title', 'Orders List')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<h1>Orders List</h1>
@stop

@section('content')
<div class="card">
    {{-- <form action="{{route('admin.orders')}}">
        <div class="card-body row">
            <div class="form-group col-md-3">
                <label>Filter By Category</label>
                <select name="category" id="filter_category" class="form-control select2">
                    <option value="">Select Category</option>
                    @foreach ($categoryData as $cat)
                    <option {{ request()->query('category') == $cat->id ? 'selected' : '' }} value="{{ $cat->id }}">{{
                        $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <button class="btn btn-default filter-search"><i class="fa fa-search"></i> Search</button>
                <a href="{{ route('admin.orders') }}" class="btn btn-default filter-search"><i
                        class="fas fa-undo"></i> Reset</a>
            </div>
        </div>
    </form> --}}
</div>

<div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr>
                    <th>OrderId</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Area</th>
                    <th>Pincode</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                    <th>Provider</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($orderData as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->area->name }}</td>
                    <td>{{ $order->pincode }}</td>
                    <td><span class="text-info">{{ $order->subtotal }}</span></td>
                    <td><span class="text-danger">{{ $order->total }}</span></td>
                    <td>
                        @if($order->provider)
                            <a href="{{ route('admin.providers.edit', $order->provider->id) }}" target="_blank">{{ $order->provider->name }}</a>
                        @else
                            <a href="{{ route('admin.orders.detail', $order) }}" class="btn btn-default btn-sm">Assign Now</a>
                        @endif
                    </td>
                    <td>{{ generate_badge($order->payment_status) }}</td>
                    <td>{{ generate_badge($order->order_status) }}</td>
                    <td><a href="{{ route('admin.orders.detail', $order) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> View</a></td>
                </tr>
            @empty
            <td colspan="10">
                <p style="text-align: center">No Orders Found !</p>
            </td>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
