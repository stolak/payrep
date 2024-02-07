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

            @foreach ($AccountList as $list)
                <input type="hidden" id="id{{ $list->id }}" value="{{ $list->id }}">
                <input type="hidden" id="acct{{ $list->id }}" value="({{ $list->accountno }})">
                <input type="hidden" id="desc{{ $list->id }}" value="{{ $list->accountdescription }}">
            @endforeach

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
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label class="control-label">Reference Account:</label>
                                                <input type="hidden" id="acctid" name="acctid"
                                                    value="{{ $acctid }}">
                                                <input type="text" list="refaccount" name="refaccount" id="refaccountid"
                                                    class="form-control" autocomplete="off" placeholder="Select Account"
                                                    onchange="fetchMain()">
                                                <datalist id="refaccount">
                                                    @foreach ($AccountList as $list)
                                                        <option
                                                            value="{{ $list->id }}:{{ $list->accountdescription }}({{ $list->accountno }})">
                                                            {{ $list->accountdescription }}({{ $list->accountno }})
                                                        </option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <label>Account Name:</label>
                                                <input type="text" value="{{ $accountname }}" class="form-control"
                                                    id="refaccountname" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label class="control-label">From:</label>
                                                <input type="date" name="fromdate" value="{{ $fromdate }}"
                                                    class="form-control" style="">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>To:</label>
                                                <input type="date" name="todate" value="{{ $todate }}"
                                                    class="form-control" style="">
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
                                    <div class="table-responsive" style="font-size: 12px;" id="tableData">

                                        <table class="table table-bordered table-striped table-highlight">
                                            <thead>

                                                <tr bgcolor="#c7c7c7" style='visibility:collapse'>
                                                    <th colspan=7>
                                                        <center>
                                                            <h3>{{ env('Coy_Name') }} </h3>
                                                        </center>
                                                    </th>
                                                </tr>
                                                <tr bgcolor="#c7c7c7" style='visibility:collapse'>
                                                    <th colspan=7>
                                                        <h3>Ledger: <span id="headerid">{{ $accountname }}
                                                                {{ date('d/m/Y', strtotime($fromdate)) }} to
                                                                {{ date('d/m/Y', strtotime($todate)) }}</span></h3>
                                                    </th>
                                                </tr>
                                                <tr bgcolor="#c7c7c7">
                                                    <th>Transaction Date</th> <!--<th >Prev Balance</th>-->
                                                    <th>Debit</th>
                                                    <th>credit</th>
                                                    <th>Balance</th>
                                                    <th>Ref No</th>
                                                    <th>Auto-Ref No</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>

                                            @foreach ($AccountStatementRunningTotal as $data)
                                                <tr>
                                                    <td>{{ $data->transdate }}</td>

                                                    <td style="text-align: right; ">
                                                        {{ number_format(abs($data->debit), 2, '.', ',') }}</td>
                                                    <td style="text-align: right; ">
                                                        {{ number_format(abs($data->credit), 2, '.', ',') }} </td>
                                                    <td style="text-align: right; ">
                                                        @if ($data->current < 0)
                                                            ({{ number_format(abs($data->current), 2, '.', ',') }})
                                                            @else{{ number_format(abs($data->current), 2, '.', ',') }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->manual_ref }} </td>
                                                    <td> &nbsp;{{ $data->ref }} </td>
                                                    <td>{{ $data->remarks }}</td>


                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </form>

                            <br><br>

                            <button class="hidden-print btn btn-success" id="export">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                Export to Excel
                            </button>

                            <button type="button" class="hidden-print btn btn-danger" id="btnExport" onclick="ExportPDF()">
                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                Download PDF
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <form method="post" target="_blank" action="/account-statement-pdf" id ="pdf" name="pdf">
                {{ csrf_field() }}
                <input type="hidden" name="acctid" value="{{ $acctid }}">
                <input type="hidden" name="fromdate" value="{{ $fromdate }}">
                <input type="hidden" name="todate" value="{{ $todate }}">
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

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

    @stop
    @section('scripts')

        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
        <script>
            var filenane = "{{ $accountname }}.xls";

            function ExportPDF() {
                document.forms["pdf"].submit();
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

            $(function() {
                $("#export").click(function(event) {
                    console.log("Exporting XLS");
                    $("#tableData").table2excel({
                        exclude: ".hidden-print",
                        name: $("#tableData").data("tableName"),
                        filename: "ledger_transaction.xls",
                        preserveColors: false
                    });
                });
            });
        </script>
    @stop
    <!-- /Page Wrapper -->
