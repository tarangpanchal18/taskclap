@extends('adminlte::page')
@section('title', $action . ' Product')
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
    <h1>{{ $action }} Product</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($action != 'Add') @method('PUT') @endif
            <div class="card-header">
                <div class="float-right">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-default"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
                </div>
                <p>Please add appropriate details to {{ $action }} Product</p>
            </div>
            <div class="card-body">

                <div class="row">

                    <x-form-select name="category_id" label="Select Category" id="category" event="onchange='fetchAndSetSubCategory(this.value)'" />

                    <x-form-select name="sub_category_id" label="Select Sub Category" id="subcategory" />

                    <x-form-input name="title" type="text" label="Title" value="{{ $product->title }}" />

                    <x-form-input name="description" type="text" label="Description" value="{{ $product->description }}" />

                    <x-form-input name="long_description" type="text" label="Long Description" value="{{ $product->long_description }}" />

                    <x-form-input name="price" type="text" label="Price" value="{{ $product->price }}" />

                    <x-form-input name="commission" type="text" label="Commission (in %)" value="{{ $product->commission }}" />

                    <x-form-input name="approx_duration" type="text" label="Approx Duration" value="{{ $product->approx_duration }}" />

                    @if ($product->image)
                    <div class="form-group col-md-12">
                        <label>Preview Image</label><br>
                        <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="{{ $product->name }}" class="admin-preview img-thumbnail">
                    </div>
                    @endif

                    <div class="form-group col-md-12">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image">
                        @error('image')<p classs="text-danger">{{ $message  }}</p>@enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Status</label>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-success" type="radio" id="statusActive" value="Active" {{ $product->status == "Active" ? 'checked' : '' }} name="status">
                                <label for="statusActive" class="custom-control-label">Active</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-danger" type="radio" id="statusInActive" value="InActive" {{ $product->status == "InActive" ? 'checked' : '' }} name="status">
                                <label for="statusInActive" class="custom-control-label">InActive</label>
                            </div>
                        </div>
                        @error('status')<p classs="text-danger">{{ $message  }}</p>@enderror
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">{{ $action }} Data</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@stop

@section('js')
<script>

    fetchAndSetCategory({{ $product->category_id}});
    @if ($action != "Add")
    fetchAndSetSubCategory({{ $product->category_id }}, {{ $product->sub_category_id }});
    @endif
</script>
@stop
