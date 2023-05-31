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

                <div class="form-group col-md-6">
                    <label>Categories Serve</label>
                    <select name="category_id[]" class="form-control select2" multiple="" tabindex="-1" aria-hidden="true">
                        @foreach($categoryData as $category)
                            @if($provider->category_id && in_array("$category->id" , $provider->category_id))
                            <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                            @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('category_id')<p style="color: #dc3545;font-style: italic">{{ $message }}</p> @enderror
                </div>

                <x-form-input name="email" type="email" label="Provider Email" value="{{ $provider->email }}" />

                <x-form-input name="phone" type="phone" label="Provider Phone" value="{{ $provider->phone }}" />

                <x-form-input name="vehicle_number" type="text" label="Provider Vehicle Number" value="{{ $provider->vehicle_number }}" />

                <x-form-textarea name="address" label="Address" value="{{ $provider->address }}" size="12" />

                <x-form-textarea name="notes" label="Notes" value="{{ $provider->notes }}" size="12" />

                @if ($provider->image)
                <div class="form-group col-md-12">
                    <label>Preview Image</label><br>
                    <img style="width: 150px;height:150px;" src="{{ asset('storage/uploads/provider/' . $provider->image) }}" alt="{{ $provider->name }}" class="admin-preview img-thumbnail">
                </div>
                @endif
                <div class="form-group col-md-12">
                    <label>Image</label>
                    <input type="file" class="form-control" name="image">
                    @error('image')<p classs="text-danger">{{ $message }}</p>@enderror
                </div>

                @if ($provider->id_proof)
                <div class="form-group col-md-12">
                    <label>Preview Id Proof</label><br>
                    <img style="width: 250px;height:150px;" src="{{ asset('storage/uploads/provider/documents/' . $provider->id_proof) }}" alt="{{ $provider->name }}" class="admin-preview img-thumbnail">
                </div>
                @endif
                <div class="form-group col-md-12">
                    <label>Id Proof</label>
                    <input type="file" class="form-control" name="id_proof">
                    @error('id_proof')<p classs="text-danger">{{ $message }}</p>@enderror
                </div>

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
                    @error('status')<p style="color: #dc3545;font-style: italic" classs="text-danger">{{ $message }}</p>@enderror
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
