<!-- Page Wrapper -->
@extends('layouts.layout')
@section('pageTitle')
{{ env('Page_Title') }}
@endsection
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">

                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Report</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- include notoifcation -->
        @include('_partialView.nofication')
        <!-- /include notoifcation -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Transaction</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" id="mainform" name="mainform">
                            {{ csrf_field() }}
                            <div class="panel-body">

                                <div class="row">
                                    {{-- <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Ref No/JV</label>

                                                <select class="select2 form-control" id="ref"
                                                    data-live-search="true" name="ref" onchange="Reload();">
                                                    <option value="">--Select--</option>
                                                    @foreach ($RefBatch as $list)
                                                        <option value="{{ $list->ref }}"
                                    {{ old('ref') == $list->ref || $ref == $list->ref ? 'selected' : '' }}>
                                    {{ $list->manual_ref }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Ref No/JV</label>
                                    <select class="form-control select2" name="ref" onchange="Reload();" id="ref">
                                        <option value="">--Select--</option>
                                        @foreach ($RefBatch as $list)
                                        <option value="{{ $list->ref }}"
                                            {{ old('ref') == $list->ref || $ref == $list->ref ? 'selected' : '' }}>
                                            {{ $list->manual_ref }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                    </div>
                    <div class="table-responsive" style="font-size: 12px;" id="tableData">
                        <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    <th>Transaction Date</th>
                                    <th>Accout Description</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Ref No</th>
                                    <th>Auto-Ref No</th>
                                    <th>Remarks</th>
                                    <th>System Date</th>
                                </tr>
                            </thead>

                            @foreach ($RefTrans as $data)
                            <tr>
                                <td>{{ $data->transdate }}</td>
                                <td>{{ $data->accountName }}
                                    <a onclick="editfunc('{{ $data->id }}','{{ $data->accountid }}')"
                                        class="btn-success "> edit</a>&nbsp;

                                </td>
                                <td style="text-align: right; ">
                                    {{ number_format(abs($data->debit), 2, '.', ',') }}</td>
                                <td style="text-align: right; ">
                                    {{ number_format(abs($data->credit), 2, '.', ',') }} </td>
                                <td>{{ $data->manual_ref }} </td>
                                <td>&nbsp;{{ $data->ref }} </td>
                                <td>{{ $data->remarks }} </td>
                                <td>{{ $data->createdat }}</td>
                            </tr>
                            @endforeach



                        </table>
                    </div>
                </div>
                </form>

                <br> <br>
                <input type="button" class="hidden-print" id="btnExport" value="Export to Excel" onclick="Export()" />
                <!--===================================================-->
                <!-- End Inline Form  -->
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="modal fade">
    <div class="modal-dialog box box-default" role="document" style="color:black;font-size:24px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Swap Account</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="post" role="form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group" style="margin: 0 10px;">
                        <input type="hidden" class="form-control" id="id" name="id">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">
                                    <h5>Account: </h5>
                                </label>
                                <select class="select2 form-control" id="account" data-live-search="true"
                                    name="account">
                                    <option value="">--Select--</option>
                                    @foreach ($AccountList as $list)
                                    <option value="{{ $list->id }}">
                                        {{ $list->accountdescription }}({{ $list->accountno }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="update">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>

    </div>
</div>

</div>

<!-- /Edit Details Modal -->
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<style>
    label {
        color: black text-shadow: 1px 1px 2px #fff;
    }

</style>
@stop

@section('scripts')
<script src="/assets/js/table2excel.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

<script>
    $('.select2').selectpicker({
        style: 'btn-default',
        size: 4
    });

    function Reload() {
        document.forms["mainform"].submit();
    }

    function deletefunc(id) {
        document.getElementById('deleteid').value = id;

        $("#deleteModal").modal('show')
    }

    function fetchMain() {
        var txv = document.getElementById('refaccountid').value;
        var tx = txv.split(':');
        var id = tx[0];
        //var id = document.getElementById('refaccountid').value;

        document.getElementById('acctid').value = id;

        document.getElementById('refaccountname').value = document.getElementById('desc' + id).value + " " + document
            .getElementById('acct' + id).value;
    }

    function fetchMains() {
        var txv = document.getElementById('refaccountids').value;
        var tx = txv.split(':');
        var id = tx[0];
        //alert(id);
        //var id = document.getElementById('refaccountids').value;
        document.getElementById('acctids').value = id;
        document.getElementById("refaccountids").style.display = "none";
        document.getElementById('refaccountnames').value = document.getElementById('desc' + id).value + " " + document
            .getElementById('acct' + id).value;
        // document.getElementById("hiddenid").style.display="block";
    }

    function UnfetchMains() {

        document.getElementById('acctids').value = '';
        document.getElementById('refaccountids').value = '';
        document.getElementById("refaccountids").style.display = "block";
        document.getElementById('refaccountnames').value = '';

    }

    function Export() {
        $("#tableData").table2excel({
            filename: "group_posting.xls"
        });
    }

    function editfunc(id, acctids) {
        document.getElementById('id').value = id;
        document.getElementById('account').value = acctids;


        $("#editModal").modal('show')
    }

</script>




@stop
