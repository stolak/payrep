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
                            <li class="breadcrumb-item active">Setup</li>
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
                            <h4 class="card-title">Product Type Setup</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" name="mainform" id="mainform">
                                {{ csrf_field() }}
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label class="control-label">Product Type</label>
                                                <select class="form-control" name="particular">
                                                    <option value="">--Select--</option>
                                                    @foreach ($DefaultProduct as $list)
                                                        <option value="{{ $list->id }}"
                                                            {{ old('particular') == $list->id || $particular == $list->id ? 'selected' : '' }}>
                                                            {{ $list->description }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label class="control-label">Lookup Account</label>
                                                <select class="form-control select2" name="accountid">
                                                    <option value="">--Select--</option>
                                                    @foreach ($DefaultAccountSetUp as $list)
                                                        <option value="{{ $list->id }}"
                                                            {{ old('accountid') == $list->id || $accountid == $list->id ? 'selected' : '' }}>
                                                            {{ $list->accountdescription }}({{ $list->accountno }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label" style="visibility: hidden;">Hidden
                                                    Label</label>
                                                <button class="btn btn-success form-control" type="submit" name="update"
                                                    style="color: white">Update</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>
                            <br>
                            <div class="table-responsive" style="font-size: 11px; padding:10px;">
                                <table id="mytable" class="table table-bordered table-striped table-highlight">
                                    <thead>
                                        <tr bgcolor="#c7c7c7">
                                            <th>S/N</th>
                                            <th>Particular</th>
                                            <th>Lookup Account</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @php
                                            $i = 1;
                                        @endphp

                                        @foreach ($DefaultProduct as $list)
                                            <tr>
                                                <td>{{ $i++ }} </td>
                                                <td>{{ $list->description }} </td>
                                                <td>{{ $list->AccountName }}</td>
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
