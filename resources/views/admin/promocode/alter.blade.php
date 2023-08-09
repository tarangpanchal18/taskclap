@extends('adminlte::page')
@section('title', $action . ' Promocode')
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)
@section('plugins.daterangepicker', true)

@section('content_header')
<h1>{{ $action }} Promocode</h1>
@stop

@section('content')
<div class="card">
    @include('layouts.alert-msg')
    <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($action != 'Add') @method('PUT') @endif
        <div class="card-header">
            <div class="float-right">
                <a href="{{ route('admin.promocode.index') }}" class="btn btn-default"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
            </div>
            <p>Please add appropriate details to {{ $action }} Promocode</p>
        </div>
        <div class="card-body">

            <div class="row">

                <x-form-input name="promocode" type="text" label="Promocode" value="{{ $promocode->promocode }}" />

                <x-form-input name="description" type="text" label="Promocode Description" value="{{ $promocode->description }}" />

                <x-form-select
                    name="discount_type"
                    label="Discount type"
                    data="{{ json_encode([
                        'Flat' => 'Flat',
                        'Percentage' => 'Percentage',
                    ]) }}"
                    value="{{ $promocode->discount_type }}"
                    select2="false"
                />

                <x-form-input name="value" type="text" label="Promocode value" value="{{ $promocode->value }}" />

                <x-form-select
                    id="validity"
                    size="12"
                    name="validity"
                    label="Promocode Validity"
                    data="{{ json_encode([
                        'Permanent' => 'Permanent',
                        'Dynamic' => 'Dynamic',
                    ]) }}"
                    value="{{ $promocode->validity }}"
                />

                <div class="date-picker-box form-group col-md-12 row" style="display:{{ ($promocode->validity == 'Permanent' || $action == 'Add') ? 'none;' : 'block' }}">
                <x-form-input name="start_date" readonly="true" type="text" class="form-control dtpicker" label="Start Date" value="{{ formatDate($promocode->start_date, 'd-m-Y') }}" />
                <x-form-input name="end_date" readonly="true" type="text" class="form-control dtpicker" label="End Date" value="{{ formatDate($promocode->end_date, 'd-m-Y') }}" />
                </div>

                <div class="form-group col-md-6">
                    <label>Status</label>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-success" type="radio"
                                id="statusActive" value="Active" {{ $promocode->status == "Active" ? 'checked' : '' }}
                            name="status">
                            <label for="statusActive" class="custom-control-label">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-danger" type="radio"
                                id="statusInActive" value="InActive" {{ $promocode->status == "InActive" ? 'checked' : ''
                            }} name="status">
                            <label for="statusInActive" class="custom-control-label">InActive</label>
                        </div>
                    </div>
                    @error('status')<p class="text-danger">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ $action }} Data</button>
            <a href="{{ route('admin.promocode.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
$(document).ready(function() {
    $("#validity").change(function() {
        if($(this).val() == "Dynamic") {
            $(".date-picker-box").show();
        } else {
            $(".date-picker-box").hide();
        }
    });

    $('.dtpicker').daterangepicker({
        "singleDatePicker": true,
        "autoApply": true,
        locale: {
            format: 'DD-MM-YYYY',
        }
    });
});
</script>
@stop
