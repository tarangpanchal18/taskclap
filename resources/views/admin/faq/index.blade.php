@extends('adminlte::page')
@section('title', 'Faq')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<h1>FAQ Module</h1>
@stop

@section('content')
<div class="card">
    <form action="{{route('admin.faq.index')}}">
        <div class="card-body row">
            <div class="form-group col-md-3">
                <label>Filter By Status</label>
                <select name="status" id="filter_status" class="form-control select2">
                    <option value="">Select Status</option>
                    <option {{ request()->query('status') == "Active" ? 'selected' : '' }} value="Active">Filter By Active</option>
                    <option {{ request()->query('status') == "InActive" ? 'selected' : '' }} value="InActive">Filter By InActive</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <button class="btn btn-default filter-search"><i class="fa fa-search"></i> Search</button>
                <a href="{{ route('admin.faq.index') }}" class="btn btn-default filter-search"><i class="fas fa-undo"></i> Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <div class="float-right">
            <a href="{{ route('admin.faq.create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add Data</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Created Date</th>
                    <th>Updated Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Created Date</th>
                    <th>Updated Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@stop

@section('js')
<x-alert-msg />

<script>
    $(document).ready(function() {
        generateDataTable('{{ route("admin.faq.index") }}', [{
                data: 'question',
                name: 'question'
            },
            {
                data: 'answer',
                name: 'answer'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'updated_at',
                name: 'updated_at'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ], {
            'status': $("#filter_status").val()
        }, [
            0, 1, 2, 3, 4
        ]);

    });

    function removeData(id) {
        removeDataFromDatabase('{{route("admin.faq.index")}}', id);
    }
</script>
@stop