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
                            <li class="breadcrumb-item active">Transaction</li>
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
            <form method="post" id="delform" name="delform">

                {{ csrf_field() }}
            </form>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Journal Validation</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" id="transdetails" name="transdetails">
                                <input type="hidden" name="ref" id="refid">
                                {{ csrf_field() }}
                                <div class="panel-body">

                                    <div class="table-responsive" style="font-size: 12px;">
                                        <table class="table table-bordered table-striped table-highlight">
                                            <tr>
                                                <th>Transaction Type</th>
                                                <th>Account</th>
                                                <th>Debit </th>
                                                <th>Credit</th>
                                                <th>Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                            @php
                                                $totaldebit = 0;
                                                $totalcredit = 0;
                                            @endphp
                                            @foreach ($SelectedJournalPending as $data)
                                                @php
                                                    $totaldebit += $data->debit;
                                                    $totalcredit += $data->credit;
                                                @endphp
                                                <tr>
                                                    <td><input type="text" class="form-control"
                                                            value="{{ $data->transtype }}" readonly></td>
                                                    <td><input type="text" class="form-control"
                                                            value="{{ $data->accountdescription }}" readonly
                                                            title="{{ $data->accountdescription }}"></td>
                                                    <td><input type="text" class="form-control"
                                                            value="{{ number_format($data->debit, 2, '.', ',') }}" readonly
                                                            style="text-align: right; "></td>
                                                    <td><input type="text" class="form-control"
                                                            value="{{ number_format($data->credit, 2, '.', ',') }}"
                                                            readonly style="text-align: right; "></td>
                                                    <td><input type="text" class="form-control"
                                                            value="{{ $data->remarks }}" readonly></td>
                                                    <td>
                                                        <a onclick="editfunc('{{ $data->id }}','{{ $data->transtype }}','{{ $data->accountid }}','{{ $data->debit }}','{{ $data->credit }}','{{ $data->remarks }}')"
                                                            class="btn btn-success  fa fa-edit btn-xs" style="color: white"></a>&nbsp;

                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td>Total</td>
                                                <td>
                                                    @if (number_format($totalcredit, 2, '.', ',') == number_format($totaldebit, 2, '.', ',') && $totaldebit > 0)
                                                        <b>Transaction Date:<input type="date" name="ini_transdate"
                                                                value="{{ $data->transdate }}" class="form-control"
                                                                style="width:150px;"></b>
                                                    @endif
                                                </td>
                                                <td><input type="text" class="form-control"
                                                        value="{{ number_format($totaldebit, 2, '.', ',') }}" readonly
                                                        style="text-align: right; "></td>
                                                <td><input type="text" class="form-control"
                                                        value="{{ number_format($totalcredit, 2, '.', ',') }}" readonly
                                                        style="text-align: right; "></td>
                                                <td>
                                                    @if (number_format($totalcredit, 2, '.', ',') == number_format($totaldebit, 2, '.', ',') && $totaldebit > 0)
                                                        <b>Ref No: <input type="text" id="manual_ref" name="manual_ref"
                                                                value="{{ $data->manual_ref }}" class="form-control"
                                                                style="width:250px;" autocomplete="off"></b>
                                                    @endif
                                                </td>
                                                <?php $totalcredit = round($totalcredit, 2);
                                                $totaldebit = round($totaldebit, 2); ?>
                                                <td colspan=2>
                                                    @if ($totaldebit == $totalcredit && $totaldebit > 0)
                                                        <button type="submit" class="btn btn-primary"
                                                            name="post">Post</button>
                                                    @endif
                                                </td>
                                            </tr>


                                        </table>
                                    </div>
                                    <div class="table-responsive" style="font-size: 12px;">
                                        <table class="table table-bordered table-striped table-highlight">
                                            <tr>
                                                <th>Transaction Date</th>
                                                <th>Total Amount</th>
                                                <th>PV/JV </th>
                                                <th>Input by </th>
                                                <th>Action</th>
                                            </tr>
                                            @foreach ($UnpostedJournalPending as $data)
                                                <tr>
                                                    <td>{{ $data->transdate }}</td>
                                                    <td>{{ number_format($data->t_val, 2, '.', ',') }} </td>
                                                    <td>{{ $data->manual_ref }}</td>
                                                    <td>{{ $data->name }}</td>

                                                    <td><a onclick="TransactionDetail('{{ $data->ref }}')"
                                                            class="btn btn-success">View</a>
                                                        <a onclick="deletefunc('{{ $data->ref }}')"
                                                            class="btn btn-success">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach



                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div id="editModal" class="modal fade">
                <div class="modal-dialog box box-default" role="document" style="color:black;font-size:24px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Entry</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="form-horizontal" method="post" role="form">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group" style="margin: 0 10px;">

                                    <input type="hidden" class="form-control" id="id" name="id">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    <h5>Trans Type: </h5>
                                                </label>
                                                <select class="form-control" id="e-transtype"name="transactiontype"
                                                    onchange="E_TextBoxState()">
                                                    <option value="">--Select--</option>
                                                    @foreach ($AccountTransType as $list)
                                                        <option value="{{ $list->transtype }}">{{ $list->transtype }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    <h5>Account Ledger: </h5>
                                                </label>
                                                <select class="form-control" id="e-acctids"name="acctids">
                                                    <option value="">--Select--</option>
                                                    @foreach ($AccountList as $list)
                                                        <option value="{{ $list->id }}">
                                                            {{ $list->accountdescription }}({{ $list->accountno }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                <h5>Debit: </h5>
                                            </label>
                                            <input type="text" class="form-control" id="e-debitamount"
                                                name="debitamount">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                <h5>Credit: </h5>
                                            </label>
                                            <input type="text" class="form-control" id="e-creditamount"
                                                name="creditamount">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                <h5>Remarks: </h5>
                                            </label>
                                            <input type="text" class="form-control" id="e-remarks" name="remarks">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="update">Save</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <div id="deleteModal" class="modal fade">
                <div class="modal-dialog box box-default" role="document" style="color:black;font-size:24px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Entry</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="form-horizontal" method="post" role="form">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <h3> You are about to delete this record! Do you really want to continue?</h3>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="delupdate">Continue</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                            <input type="hidden" id="delid" name="delref">
                        </form>
                    </div>

                </div>
            </div>

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

        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
        <script>
            function editfunc(id, transtype, acctids, debitamount, creditamount, remarks) {
                document.getElementById('id').value = id;
                document.getElementById('e-transtype').value = transtype;
                if (transtype == "Debit") {
                    document.getElementById('e-debitamount').removeAttribute('disabled');
                    document.getElementById('e-creditamount').setAttribute('disabled', 'disabled');
                } else {
                    document.getElementById('e-creditamount').removeAttribute('disabled');
                    document.getElementById('e-debitamount').setAttribute('disabled', 'disabled');
                }
                document.getElementById('e-acctids').value = acctids;
                document.getElementById('e-debitamount').value = debitamount;
                document.getElementById('e-creditamount').value = creditamount;
                document.getElementById('e-remarks').value = remarks;

                $("#editModal").modal('show')
            }

            function deletefunc(id) {
                document.getElementById('delid').value = id;
                $("#deleteModal").modal('show')
                return;
            }

            function TransactionDetail(ref) {
                document.getElementById('refid').value = ref;
                document.forms["transdetails"].submit();

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
        </script>
    @stop
    <!-- /Page Wrapper -->
