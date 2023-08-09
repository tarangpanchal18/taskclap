@extends('adminlte::page')
@section('title', $action . ' Page')
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<h1>{{ $action }} Page</h1>
@stop

@section('content')
<div class="card">

    @include('layouts.alert-msg')

    <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($action != 'Add') @method('PUT') @endif
        <div class="card-header">
            <div class="float-right">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-default"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
            </div>
            <p>Please add appropriate details to {{ $action }} Page</p>
        </div>
        <div class="card-body">

            <div class="row">

                <x-form-input name="title" type="text" label="Title" value="{{ $page->title }}" />

                <x-form-input name="seo_keywords" type="text" label="SEO Keywords" value="{{ $page->seo_keywords }}" />

                <x-form-textarea name="description" type="text" label="Description" value="{{ $page->description }}" size="12" />

                <x-form-textarea name="seo_description" type="text" label="SEO Description" value="{!! $page->seo_description !!}" id="editor" size="12" />

                @if ($page->image)
                <div class="form-group col-md-12">
                    <label>Preview Image</label><br>
                    <img src="{{ asset('storage/uploads/pages/' . $page->page_image) }}" alt="{{ $page->name }}" class="admin-preview img-thumbnail">
                </div>
                @endif

                <div class="form-group col-md-12">
                    <label>Image</label>
                    <input type="file" class="form-control" name="page_image">
                    @error('image')<p classs="text-danger">{{ $message  }}</p>@enderror
                </div>

                <div class="form-group col-md-6">
                    <label>Status</label>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-success" type="radio" id="statusActive" value="Active" {{ $page->status == "Active" ? 'checked' : '' }} name="status">
                            <label for="statusActive" class="custom-control-label">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input custom-control-input-danger" type="radio" id="statusInActive" value="InActive" {{ $page->status == "InActive" ? 'checked' : '' }} name="status">
                            <label for="statusInActive" class="custom-control-label">InActive</label>
                        </div>
                    </div>
                    @error('status')<p style="color: #dc3545;font-style: italic" classs="text-danger">{{ $message  }}</p>@enderror
                </div>

            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ $action }} Data</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
@stop