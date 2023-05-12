@extends('adminlte::page')
@section('title', 'Service')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<h1>Service Module</h1>
@stop

@section('content')
<!-- <div class="card">
    <form action="{{route('admin.products.services.index', $product)}}">
        <div class="card-body row">
            <div class="form-group col-md-3">
                <label>Filter By Category</label>
                <select name="category" id="filter_category" class="form-control select2">
                    <option value="">Select Category</option>
                    @foreach ($categoryData as $cat)
                    <option {{ request()->query('category') == $cat->id ? 'selected' : '' }} value="{{ $cat->id }}">{{
                        $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <button class="btn btn-default filter-search"><i class="fa fa-search"></i> Search</button>
                <a href="{{ route('admin.products.services.index', $product) }}" class="btn btn-default filter-search"><i
                        class="fas fa-undo"></i> Reset</a>
            </div>
        </div>
    </form>
</div> -->

<div class="card">
    <div class="card-header">
        <div class="float-left">
            <p>Manage Services for <span class="badge badge-info">{{ $product->title }}</span></p>
        </div>
        <div class="float-right">
            <a href="{{ route('admin.products.index', $product) }}" class="btn btn-default"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
            <a href="{{ route('admin.products.services.create', $product) }}" class="btn btn-default"><i class="fa fa-plus"></i> Add Data</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Commission</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<x-alert-msg />

<script>
    $(document).ready(function() {
    generateDataTable('{{ route("admin.products.services.index", $product) }}', [
        {data: 'title', name: 'title'},
        {data: 'price', name: 'price'},
        {data: 'commission', name: 'commission'},
        {data: 'status', name: 'status'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ], {
        'category' : $("#filter_category").val(),
    },
    [
        0, 1, 2, 3
    ]);
});

function removeData(id) {
    removeDataFromDatabase('{{route("admin.products.services.index", [$product])}}', id);
}
</script>
@stop
