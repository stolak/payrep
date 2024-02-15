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
                            <h4 class="card-title">Account Statement</h4>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                {{ csrf_field() }}
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">From:</label>
                                                <input type="date" name="fromdate" value="{{ $fromdate }}"
                                                    class="form-control" style="width:150px;">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>To:</label>
                                                <input type="date" name="todate" value="{{ $todate }}"
                                                    class="form-control" style="width:150px;">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">Ref No/JV</label>
                                                <select class="form-control select2" name="ref" id="ref">
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
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><br></label>
                                                <br>
                                                <button type="submit" class="btn btn-primary" name="post">Go</button>
                                            </div>
                                        </div>
                                    </div>

                                    <br><br>
                                    <div class="table-responsive" style="font-size: 12px;" id="tableData">
                                        <table class="table table-bordered table-striped table-highlight">
                                            <thead>
                                                <tr bgcolor="#c7c7c7">
                                                    <th>Transaction Date</th>
                                                    <th>Amount</th>
                                                    <th>Ref No</th>
                                                    <th>Auto-Ref No</th>
                                                    <th>Remarks</th>
                                                    <th>System Date</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>

                                            @foreach ($Trans_Summary as $data)
                                                <tr>
                                                    <td>{{ $data->transdate }}</td>

                                                    <td style="text-align: right; ">
                                                        {{ number_format(abs($data->sum_total), 2, '.', ',') }} </td>
                                                    <td>{{ $data->manual_ref }} </td>
                                                    <td>&nbsp;{{ $data->ref }} </td>
                                                    <td>&nbsp;{{ $data->remarks }} </td>
                                                    <td>{{ $data->createdat }}</td>
                                                    <td><a onclick="TransactionDetail('{{ $data->ref }}')"
                                                            class="btn btn-success">View</a>
                                                        <a onclick="deletefunc('{{ $data->ref }}')"
                                                            class="btn btn-danger fa fa-trash btn-xs"
                                                            style="color: white"></a>
                                                    </td>

                                                </tr>
                                            @endforeach



                                        </table>
                                    </div>
                                </div>
                            </form>
                            <form method="post" target="_blank" action="/trans-ref" id ="transdetails" name="transdetails">
                                {{ csrf_field() }}
                                <input type="hidden" name="ref" id="refid">

                            </form>

                            <br><br>
                            {{-- <input type="button" class="hidden-print" id="btnExport" value="Export to Excel"
                                onclick="Export()" />
                            <input type="button" class="hidden-print" id="btnExport" value="Download PDF"
                                onclick="ExportPDF()" /> --}}


                            <button class="hidden-print btn btn-success" id="btnExport1" onclick="Export()">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                Export to Excel
                            </button>

                            <button type="button" class="hidden-print btn btn-danger" id="btnExport" onclick="ExportPDF()">
                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                Download PDF
                            </button>
                            <!--===================================================-->
                            <!-- End Inline Form  -->
                        </div>
                    </div>
                </div>
            </div>

            <div id="deleteModal" class="modal fade">
                <div class="modal-dialog box box-default" role="document" style="color:black;font-size:24px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Batch Record</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="form-horizontal" method="post" role="form">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group" style="margin: 0 10px;">

                                    <input type="hidden" class="form-control" id="deleteid" name="deleteid"
                                        value="">

                                    <div class="col-sm-12">
                                        <center>
                                            <h1 style="color:black;">Are you sure?</h1>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="del" class="btn btn-success">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

            <form method="post" target="_blank" action="/trans-summary-pdf" id ="pdf" name="pdf">
                {{ csrf_field() }}
                <input type="hidden" name="fromdate" value="{{ $fromdate }}">
                <input type="hidden" name="todate" value="{{ $todate }}">
                <input type="hidden" name="ref" value="{{ $ref }}">
            </form>

        </div>

        <!-- /Edit Details Modal -->
    @endsection

    @section('styles')
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
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

            function ExportPDF() {
                document.forms["pdf"].submit();
            }

            function TransactionDetail(ref) {
                document.getElementById('refid').value = ref;
                document.forms["transdetails"].submit();

            }

            function editfunc(id, manu, brand) {
                document.getElementById('id').value = id;
                document.getElementById('manu').value = manu;
                document.getElementById('brand').value = brand;

                $("#editModal").modal('show')
            }

            function deletefunc(id) {
                document.getElementById('deleteid').value = id;

                $("#deleteModal").modal('show')
            }

            // function fetchMain() {
            //     var txv = document.getElementById('refaccountid').value;
            //     var tx = txv.split(':');
            //     var id = tx[0];
            //     //var id = document.getElementById('refaccountid').value;

            //     document.getElementById('acctid').value = id;

            //     document.getElementById('refaccountname').value = document.getElementById('desc' + id).value + " " + document
            //         .getElementById('acct' + id).value;
            // }

            // function fetchMains() {
            //     var txv = document.getElementById('refaccountids').value;
            //     var tx = txv.split(':');
            //     var id = tx[0];
            //     //alert(id);
            //     //var id = document.getElementById('refaccountids').value;
            //     document.getElementById('acctids').value = id;
            //     document.getElementById("refaccountids").style.display = "none";
            //     document.getElementById('refaccountnames').value = document.getElementById('desc' + id).value + " " + document
            //         .getElementById('acct' + id).value;
            //     // document.getElementById("hiddenid").style.display="block";
            // }

            // function UnfetchMains() {

            //     document.getElementById('acctids').value = '';
            //     document.getElementById('refaccountids').value = '';
            //     document.getElementById("refaccountids").style.display = "block";
            //     document.getElementById('refaccountnames').value = '';

            // }

            function Export() {
                $("#tableData").table2excel({
                    filename: "transaction_summary.xls"
                });
            }
        </script>




    @stop
