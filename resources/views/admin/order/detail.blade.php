@extends('adminlte::page')
@section('title', 'Order Detail | ' . $order->order_id)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<style>
    .select2-container{
        width: 100%!important;
    }
</style>
<div class="card">
    <div class="card-header">
        <div class="float-left">
            <h1>Order Detail</h1>
        </div>
        <div class="float-right">
            <a href="{{ route('admin.orders') }}" class="btn btn-default"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @include('layouts.alert-msg')
        <div class="row">
            <!-- Manage Order -->
            <div class="col-md-12">
                <div class="card card-outline card-danger">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-cog"></i> Manage Order</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body row" style="padding-bottom: 0px;">

                        @if(in_array($order->payment_status, ['Placed', 'Pending']))
                        <div class="form-group col-md-3">
                            <label>Change Order Status To</label>
                            <select class="form-control select2">
                                <option value="" disabled selected>Select Order Status</option>
                                @foreach($orderStatus as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        @if(in_array($order->payment_status, ['Started', 'Pending']))
                        <div class="form-group col-md-3">
                            <label>Change Payment Status To</label>
                            <select class="form-control select2">
                                <option value="" disabled selected>Select Order Status</option>
                                @foreach($paymentStatus as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="form-group col-md-12" style="margin-bottom: 0px;">
                            <p class="text-sm text-danger"><strong>Note:</strong> Once you change order status to <strong>Completed/Failed/Rejected/Cancelled</strong> you want be able to add additional or material charge.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Details -->
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-user"></i> User Detail</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr><th>Name</th><td>{{ $order->name }}</td></tr>
                                <tr><th>Phone</th><td>{{ $order->phone }}</td></tr>
                                <tr><th>Email</th><td>{{ $order->email }}</td></tr>
                                <tr><th>Address (Map)</th><td>{{ $order->user->address_lat }},{{ $order->user->address_long }}</td></tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ generate_badge($order->user->status) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Provider Details -->
            <div class="col-md-6">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-users-cog"></i> Provider Detail</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($order->provider)
                        <table class="table table-bordered">
                            <tbody>
                                <tr><th>Name</th><td>{{ $order->provider->name }}</td></tr>
                                <tr><th>Phone</th><td>{{ $order->provider->phone }}</td></tr>
                                <tr><th>Email</th><td>{{ $order->provider->email }}</td></tr>
                                <tr><th>Address</th><td>{{ $order->provider->address }}</td></tr>
                                <tr>
                                    <th>Status</th>
                                    <td><span class="badge badge-{{($order->provider->status == "Active") ? 'success' : 'danger' }}">{{ $order->user->status }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <h4>No Provider assigned yet !</h4>
                        <button class="btn btn-success btn-sm" id="assignProviderBtn" data-toggle="modal" data-target="#assignProviderMdl">Assign Now</button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Details
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-archive"></i> Order Detail</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    @foreach ($order->orderDetail as $orderDetail)
                    <div class="card-body">
                        <h4 class="text-danger">Purchased Product {{$loop->iteration}}</h4>
                        <table class="table table-bordered">
                            <tbody>
                                <tr colspan="4">
                                    <th>Product Title</th><td colspan="4">{{ $orderDetail->product_title }}</td>
                                </tr>
                                <tr>
                                    <th>Product Description</th><td colspan="4">{!! $orderDetail->product_description !!}</td>
                                </tr>
                                <tr>
                                    <th>Strike Price</th><td><del>{{ $orderDetail->product_strike_price }}</del></td>
                                    <th>Actual Price</th><td>{{ $orderDetail->product_price }}</td>
                                </tr>
                                <tr>
                                    <th>Product Commission</th><td>{{ $orderDetail->product_commission }} %</td>
                                    <th>Service Duration (in time)</th><td>{{ $orderDetail->product_approx_duration }}</td>
                                </tr>
                                <tr>
                                    <th>Warranty (in time)</th><td>{{ $orderDetail->warranty }} Days</td>
                                    <th>Status</th><td><span class="badge badge-{{($orderDetail->product->status == "Active") ? 'success' : 'danger' }}">{{ $orderDetail->product->status }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div> -->

            <!-- Invoice Details -->
             <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-invoice"></i> Invoice Detail</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" style="margin-bottom: 6em;">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Product</th>
                                            <th>Warranty</th>
                                            <th>Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderDetail as $orderDetail)
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $orderDetail->product_title}}</td>
                                            <td>{{ $orderDetail->warranty }} Days</td>
                                            <td>₹ {{ $orderDetail->product_price }}</td>
                                            <td>₹ {{ $orderDetail->product_price }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="lead">Order Placed On : <strong>{{ date('d M Y (h:ia)', strtotime($order->created_at)) }}</strong></p>
                                <p class="lead">Order Status : <strong>{{ $order->order_status }}</strong></p>
                                <p class="lead">Payment Status: <strong>{{ $order->payment_status }}</strong></p>
                                <p class="lead">Payment Type</p>
                                @if($order->payment_type == "Cash")
                                <img src="https://cdn-icons-png.flaticon.com/512/2489/2489756.png" alt="Cash" style="height: 55px;">
                                @elseif($order->payment_type == "Upi")
                                <img src="https://www.vectorlogo.zone/logos/upi/upi-ar21.png" alt="UPI" style="height: 55px;">
                                @elseif($order->payment_type == "NetBanking")
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTKceKsLy4OFxVl6N0Qxh577deTABrBKYoxMPmmoY6ifg&usqp=CAU&ec=48665698" alt="UPI" style="height: 55px;">
                                @else
                                <img src="https://t3.ftcdn.net/jpg/04/87/13/40/360_F_487134056_ttJAg56QAcB15RKhdOQUKPXGxwGt5xqB.jpg" alt="UPI" style="height: 55px;">
                                @endif
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem</p>

                            </div>
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>₹ {{ $order->subtotal }}</td>
                                            </tr>
                                            <tr>
                                                <th>Material Total</th>
                                                <td>₹ {{ ($order->material_charge_amount_total) ? $order->material_charge_amount_total : "0.00" }}</td>
                                            </tr>
                                            <tr>
                                                <th>Additional Total</th>
                                                <td>₹ {{ ($order->orderDetail[0]->additional_charge) ? $order->orderDetail[0]->additional_charge : "0.00" }}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td>₹ {{ ($order->discount) ? $order->discount : "0.00" }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tax</th>
                                                <td>₹ {{ ($order->tax) ? $order->tax : "0.00" }}</td>
                                            </tr>
                                            <tr style="background: rgba(0,0,0,.05);">
                                                <th>Total:</th>
                                                <td>₹ {{ $order->total }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="assignProviderMdl">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.orders.detail', $order) }}" method="POST">
            <div class="modal-header">
                <h4 class="modal-title">Assign Service Provider</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="type" value="assign_provider">
                <select name="provider_id" class="select2 form-control" required>
                    <option value="" selected disabled>Select Provider</option>
                    @foreach($providerList as $provider)
                    <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Assign Now</button>
            </div>
        </form>
        </div>
    </div>
</div>
@stop
