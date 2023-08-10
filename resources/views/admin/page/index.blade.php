@extends('adminlte::page')
@section('title', 'Page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<h1>Page Module</h1>
@stop

@section('content')
<div class="card">
    <!-- --->
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Updated On</th>
                    <th style="width: 5%;">Action</th>
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
        generateDataTable('{{ route("admin.pages.index") }}', [
            {data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false},
            {data: 'title',name: 'title'},
            {data: 'status',name: 'status'},
            {data: 'updated_at',name: 'updated_at'},
            {data: 'action',name: 'action',orderable: false,searchable: false},
        ], {
            'status': $("#filter_status").val()
        },[
            0,1,2,3
        ]);

    });

    function removeData(id) {
        removeDataFromDatabase('{{route("admin.pages.index")}}', id);
    }
</script>
@stop
