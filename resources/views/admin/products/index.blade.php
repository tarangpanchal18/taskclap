@extends('adminlte::page')
@section('title', 'Products')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
    <h1>Products Module</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{route('admin.products.index')}}">
            <div class="card-body row">
                <div class="form-group col-md-3">
                    <label>Filter By Category</label>
                    <select name="category" id="filter_category" class="form-control select2">
                        <option value="">Select Category</option>
                        @foreach ($categoryData as $cat)
                        <option {{ request()->query('category') == $cat->id ? 'selected' : '' }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <button class="btn btn-default filter-search"><i class="fa fa-search"></i> Search</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-default filter-search"><i class="fas fa-undo"></i> Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="float-right">
                <a href="{{ route('admin.products.create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add Data</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Commission</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Commission</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
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
    generateDataTable('{{ route("admin.products.index") }}', [
            {data: 'category', name: 'category', orderable: false, searchable: false},
            {data: 'subcategory', name: 'subcategory'},
            {data: 'title', name: 'title'},
            {data: 'price', name: 'price'},
            {data: 'commission', name: 'commission'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
    ], {
        'category' : $("#filter_category").val(),
    },
    [
        0, 1, 2, 3, 4, 5
    ]);
});

function removeData(id) {
    removeDataFromDatabase('{{route("admin.products.index")}}', id);
}
</script>
@stop
