@extends('adminlte::page')
@section('title', 'Promocode')
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<h1>Promocode Module</h1>
@stop

@section('content')
<div class="card">
    <form action="{{route('admin.promocode.index')}}">
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
                <a href="{{ route('admin.promocode.index') }}" class="btn btn-default filter-search"><i class="fas fa-undo"></i> Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <div class="float-right">
            <a href="{{ route('admin.promocode.create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add Data</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr>
                    <th>Promocode</th>
                    <th>Discount</th>
                    <th>Validity</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                @forelse($pageData as $data)
                <tr>
                    <td>{{ $data->promocode }}</td>
                    <td>{{ $data->value }}{{ ($data->discount_type == "Percentage") ? "%" : " Flat" }} </td>
                    <td>{{ $data->validity }}</td>
                    <td>{{ ($data->start_date && $data->validity == "Dynamic") ? formatDate($data->start_date) : 'N/A' }}</td>
                    <td>{{ ($data->end_date && $data->validity == "Dynamic") ? formatDate($data->end_date) : 'N/A' }}</td>
                    <td>{{ generate_badge($data->status) }}</td>
                    <td>
                        <a href="{{ route('admin.promocode.edit', $data->id) }}" class="edit btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <button onclick="removeData('{{ $data->id }}')" class="edit btn btn-default btn-sm"><i class="fa fa-trash"></i>Remove</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <th colspan="7">No Data Found!</th>
                </tr>
                @endforelse
            </tfoot>
        </table>
    </div>
</div>
@stop

@section('js')
<x-alert-msg />

<script>
function removeData(id) {
    removeDataFromDatabase('{{route("admin.promocode.index")}}', id, false);
}
</script>
@stop
