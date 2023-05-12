@extends('adminlte::page')
@section('title', $action . ' Service')
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
    <h1>{{ $action }} Service</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($action != 'Add') @method('PUT') @endif
            <div class="card-header">
                <div class="float-right">
                    <a href="{{ route('admin.products.services.index', $product) }}" class="btn btn-default"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
                </div>
                <p>Please add appropriate details to {{ $action }} Service of <span class="badge badge-info">{{ $product->title }}</span></p>
            </div>
            <div class="card-body">

                <div class="row">

                    <input type="hidden" name="parent_id" value="{{ $product->id }}">
                    <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                    <input type="hidden" name="sub_category_id" value="{{ $product->sub_category_id }}">

                    <x-form-input name="title" type="text" label="Title" value="{{ $service->title }}" />

                    <x-form-input name="strike_price" type="text" label="Strike Price" value="{{ $service->strike_price }}" />

                    <x-form-input name="price" type="text" label="Price" value="{{ $service->price }}" />

                    <x-form-textarea name="description" type="text" label="Description" value="{!! $service->description !!}" id="editor" size="12" />

                    <x-form-input name="commission" type="text" label="Commission (in %)" value="{{ $service->commission }}" />

                    <x-form-input name="approx_duration" type="text" label="Approx Duration" value="{{ $service->approx_duration }}" />

                    <div class="form-group col-md-6">
                        <label>Status</label>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-success" type="radio" id="statusActive" value="Active" {{ $service->status == "Active" ? 'checked' : '' }} name="status">
                                <label for="statusActive" class="custom-control-label">Active</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-danger" type="radio" id="statusInActive" value="InActive" {{ $service->status == "InActive" ? 'checked' : '' }} name="status">
                                <label for="statusInActive" class="custom-control-label">InActive</label>
                            </div>
                        </div>
                        @error('status')<p style="color: #dc3545;font-style: italic" classs="text-danger">{{ $message  }}</p>@enderror
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">{{ $action }} Data</button>
                <a href="{{ route('admin.products.services.index', $product) }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@stop
