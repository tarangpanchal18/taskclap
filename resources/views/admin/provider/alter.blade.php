@extends('adminlte::page')
@section('title', $action . ' Provider')
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<h1>{{ $action }} Provider</h1>
@stop

@section('content')
<div class="card">

    @include('layouts.alert-msg')

    <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($action != 'Add') @method('PUT') @endif
        <div class="card-header">
            <div class="float-right">
                <a href="{{ route('admin.providers.index') }}" class="btn btn-default"><i
                        class="fa fa-arrow-alt-circle-left"></i> Back</a>
            </div>
            <p>Please add appropriate details to {{ $action }} Provider</p>
        </div>
        <div class="card-body">

            <div class="row">

                <x-form-input name="name" type="text" label="Provider Name" value="{{ $provider->name }}" />

                <x-form-input name="email" type="email" label="Provider Email" value="{{ $provider->email }}" />

                <x-form-input name="phone" type="phone" label="Provider Phone" value="{{ $provider->phone }}" />

                <x-form-textarea name="address" label="Address" value="{{ $provider->address }}" size="12" />

                <x-form-textarea name="notes" label="Notes" value="{{ $provider->notes }}" size="12" />

                <div class="form-group col-md-6">
                    <label>Status</label>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-success" type="radio"
                                id="statusActive" value="Active" {{ $provider->status == "Active" ? 'checked' : '' }}
                            name="status">
                            <label for="statusActive" class="custom-control-label">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-danger" type="radio"
                                id="statusInActive" value="InActive" {{ $provider->status == "InActive" ? 'checked' : ''
                            }} name="status">
                            <label for="statusInActive" class="custom-control-label">InActive</label>
                        </div>
                    </div>
                    @error('status')<p classs="text-danger">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ $action }} Data</button>
            <a href="{{ route('admin.providers.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
@stop
