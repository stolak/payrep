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


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Petty Cash Handling</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" name="mainform" id="mainform">
                                {{ csrf_field() }}
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">Project Type</label>
                                                <select class="form-control" name="particular">
                                                    <option value="">--Select--</option>
                                                    @foreach ($ProjectAccount as $list)
                                                        <option value="{{ $list->id }}"
                                                            {{ old('particular') == $list->id || $particular == $list->id ? 'selected' : '' }}>
                                                            {{ $list->particular }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label">Amount</label>
                                                <?php if ($amount == '') {
                                                    $amount = old('amount');
                                                } ?>
                                                <input type="text" class="form-control" value="{{ $amount }}"
                                                    required name="amount">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label">Transaction Date</label>
                                                <?php if ($transdate == '') {
                                                    $remark = old('transdate');
                                                } ?>
                                                <input type="date" name="transdate" value="{{ $transdate }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label">Ref No</label>
                                                <?php if ($manual_ref == '') {
                                                    $remark = old('manual_ref');
                                                } ?>
                                                <input type="text" class="form-control" value="{{ $manual_ref }}"
                                                    required name="manual_ref">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">Remarks</label>
                                                <?php if ($remark == '') {
                                                    $remark = old('remark');
                                                } ?>
                                                <input type="text" class="form-control" value="{{ $remark }}"
                                                    required name="remark">
                                            </div>
                                        </div>



                                    </div>

                                </div>
                                <div class="panel-footer text-right">
                                    <button class="btn btn-success" type="submit" name="post">Post</button>
                                </div>
                            </form>

                            <h5>Recent Transactions on petty cash handling</h1>
                                <div class="table-responsive" style="font-size: 11px; padding:10px;">
                                    <table id="mytable" class="table table-bordered table-striped table-highlight">
                                        <thead>
                                            <tr bgcolor="#c7c7c7">
                                                <th>S/N</th>
                                                <th>Transaction Date</th>
                                                <th>Project Type</th>
                                                <th>Project Description</th>
                                                <th>Account</th>
                                                <th>Amount</th>
                                                <th>Posted by</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @php
                                                $i = 1;
                                            @endphp

                                            @foreach ($PettyTransaction as $list)
                                                <tr>
                                                    <td>{{ $i++ }} </td>
                                                    <td>{{ $list->transdate }} </td>
                                                    <td>{{ $list->Particular }}</td>
                                                    <td>{{ $list->remark }} </td>
                                                    <td>{{ $list->AccountName }}</td>
                                                    <td>{{ $list->amount }} </td>
                                                    <td>{{ $list->Postedby }} </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                        </div>
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

            function Reload() {

                document.forms["mainform"].submit();
                return;
            }
        </script>




    @stop

    <!-- /Page Wrapper -->
