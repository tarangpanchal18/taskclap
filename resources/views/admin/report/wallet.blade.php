@extends('adminlte::page')
@section('title', 'Wallet Report')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<h1>Wallet Report</h1>
@stop

@section('content')
@include('layouts.alert-msg')
<div class="card">
    <form action="{{route('admin.report.wallet')}}">
        <div class="card-body row">

            <x-form-select size="3" name="user_id" label="Filter By user" data="{{ $userData->pluck('id','name') }}" value="{{ request()->user_id }}" useDataAsKeyVal="true" />

            <div class="form-group col-md-3">
                <button class="btn btn-default filter-search"><i class="fa fa-search"></i> Search</button>
                <a href="{{ route('admin.report.wallet') }}" class="btn btn-default filter-search"><i class="fas fa-undo"></i> Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr style="font-size: 13px;">
                    <th>Transaction Date</th>
                    <th>Transaction ID</th>
                    <th>Description</th>
                    <th>Order No</th>
                    <th>Transaction Type</th>
                    <th>Amount</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($walletData as $data)
                <tr>
                    <td>{{ formatDate($data->created_at) }}</td>
                    <td>{{ $data->uuid }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $data->type }}</td>
                    <td>₹ {{ formatNumber($data->amount) }}</td>
                    <td>
                        @php $finalTotal = $finalTotal + formatNumber($data->amount) @endphp
                        ₹ {{ formatNumber($finalTotal) }}
                    </td>
                </tr>
                @empty
                <th colspan="14" style="text-align: center"><h4>No Data found !</h4></th>
                @endforelse
                <tr>
                    <td colspan="5"></td>
                    <th>Total</th>
                    <th>₹ {{ formatNumber($finalTotal) }}</th>
                </tr>
            </tbody>
        </table>
        <div class="mt-4 float-left">
            @if($walletData)
            {{ $walletData->appends(request()->input())->links() }}
            @endif
        </div>
        <div class="mt-4 float-right">
            <button class="btn btn-success" id="assignProviderBtn" data-userId="{{ request()->user_id }}">Add Transaction</button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addWalletTransaction">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.report.wallet') }}" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Add Transaction to Wallet</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="type" value="deposit">
                    <input type="hidden" id="wallet_user_id" name="user_id">
                    <label>Enter Amount</label>
                    <input type="text" name="amount" class="form-control" min="0" max="9999">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Complete Transaction</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<x-alert-msg />
@stop
