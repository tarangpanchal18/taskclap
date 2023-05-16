@extends('adminlte::page')
@section('title', 'Order Detail | ' . $order->order_id)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')

<div class="card">
    <div class="card-header">
        <h1>Order Detail</h1>
    </div>
    <div class="card-body">
        <div class="row">

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
                                    <td><span class="badge badge-{{($order->user->status == "Active") ? 'success' : 'danger' }}">{{ $order->user->status }}</span></td>
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
                        <table class="table table-bordered">
                            <tbody>
                                <tr><th>Name</th><td>{{ $order->provider->name }}</td></tr>
                                <tr><th>Phone</th><td>{{ $order->provider->phone }}</td></tr>
                                <tr><th>Email</th><td>{{ $order->provider->email }}</td></tr>
                                <tr>
                                    <th>Status</th>
                                    <td><span class="badge badge-{{($order->provider->status == "Active") ? 'success' : 'danger' }}">{{ $order->user->status }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
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
            </div>

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
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Product</th>
                                            <th>Serial #</th>
                                            <th>Description</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Call of Duty</td>
                                            <td>455-981-221</td>
                                            <td>El snort testosterone trophy driving gloves handsome</td>
                                            <td>$64.50</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Need for Speed IV</td>
                                            <td>247-925-726</td>
                                            <td>Wes Anderson umami biodiesel</td>
                                            <td>$50.00</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Monsters DVD</td>
                                            <td>735-845-642</td>
                                            <td>Terry Richardson helvetica tousled street art master</td>
                                            <td>$10.70</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Grown Ups Blue Ray</td>
                                            <td>422-568-642</td>
                                            <td>Tousled lomo letterpress</td>
                                            <td>$25.99</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="lead">Payment Methods:</p>
                                <img src="https://adminlte.io/themes/v3/dist/img/credit/visa.png" alt="Visa">
                                <img src="https://adminlte.io/themes/v3/dist/img/credit/mastercard.png" alt="Mastercard">
                                <img src="https://adminlte.io/themes/v3/dist/img/credit/american-express.png" alt="American Express">
                                <img src="https://adminlte.io/themes/v3/dist/img/credit/paypal2.png" alt="Paypal">
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem</p>
                                <p class="lead">Order Placed On : {{ $order->created_at }}</p>
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
                                                <td>₹ {{ $order->material_charge_amount_total }}</td>
                                            </tr>
                                            <tr>
                                                <th>Additional Total</th>
                                                <td>₹ {{ $order->orderDetail[0]->additional_charge }}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td>₹ {{ ($order->discount) ? $order->discount : "0.00" }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tax</th>
                                                <td>₹ {{ ($order->tax) ? $order->tax : "0.00" }}</td>
                                            </tr>
                                            <tr>
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
@stop

@section('content')
@stop
