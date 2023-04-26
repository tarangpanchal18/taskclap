@extends('adminlte::page')
@section('title', $action . ' Banner')
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
    <h1>{{ $action }} Banner</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($action != 'Add') @method('PUT') @endif
            <div class="card-header">
                <div class="float-right">
                    <a href="{{ route('admin.banner.index') }}" class="btn btn-default"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
                </div>
                <p>Please add appropriate details to {{ $action }} Banner</p>
            </div>
            <div class="card-body">

                <div class="row">

                    <x-form-input name="name" type="text" label="Banner Title" value="{{ $banner->name }}" />

                    <x-form-input name="order" type="number" label="Image Order" value="{{ $banner->order }}" />

                    @if ($banner->image)
                    <div class="form-group col-md-6">
                        <label>Preview Image</label><br>
                        <img src="{{ asset('storage/uploads/banner/' . $banner->image) }}" alt="{{ $banner->name }}" class="admin-preview-banner img-thumbnail">
                    </div>
                    @endif

                    <div class="form-group col-md-12">
                        <label>Banner Image</label>
                        <input type="file" class="form-control" name="image">
                        @error('image')<p classs="text-danger">{{ $message  }}</p>@enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Status</label>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-success" type="radio" id="statusActive" value="Active" {{ $banner->status == "Active" ? 'checked' : '' }} name="status">
                                <label for="statusActive" class="custom-control-label">Active</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-danger" type="radio" id="statusInActive" value="InActive" {{ $banner->status == "InActive" ? 'checked' : '' }} name="status">
                                <label for="statusInActive" class="custom-control-label">InActive</label>
                            </div>
                        </div>
                        @error('status')<p classs="text-danger">{{ $message  }}</p>@enderror
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">{{ $action }} Data</button>
                <a href="{{ route('admin.banner.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@stop
