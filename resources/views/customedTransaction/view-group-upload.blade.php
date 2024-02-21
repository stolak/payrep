<!-- Page Wrapper -->
@extends('layouts.layout')
@section('pageTitle')
{{env('Page_Title')}}
@endsection
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Upload History</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Upload History</li>
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
                    <div class="card-body">
                        <form method="post" name="mainform" id="mainform">
                            {{ csrf_field() }}


                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- List of economic code -->
                <div class="card card-table">
                    <div class="card-header">
                        <h4 class="card-title">Record upload</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th rowspan="1">S/N</th>

                                        <th rowspan="1">Description</th>
                                        <th rowspan="1">Date Range</th>
                                        <th rowspan="1">Total Debit</th>
                                        <th rowspan="1">Total Credit</th>
                                        <th rowspan="1">Status</th>
                                        <th rowspan="1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $sn=1;

                                    @endphp
                                    @foreach($records as $list)

                                    <tr>
                                        <td>
                                            {{$sn++}}
                                        </td>
                                        <td>
                                            {{$list->descriptions}}
                                        </td>
                                        <td>
                                            {{$list->min_formatted_date}}- {{$list->max_formatted_date}}
                                        </td>
                                        <td style="text-align: right;">
                                            {{number_format($list->debits,2, '.', ',')}}

                                        </td>
                                        <td style="text-align: right;">
                                            {{number_format($list->credits,2, '.', ',')}}
                                        </td>

                                        <td>
                                            @if($list->max_process_status ===0 && $list->min_process_status===0 )
                                            Pending
                                            @endif
                                            @if($list->max_process_status ===1 && $list->min_process_status===0 )
                                            Progressive
                                            @endif
                                            @if($list->max_process_status ===1 && $list->min_process_status===1 )
                                            Complete
                                            @endif

                                        </td>

                                        <td>
                                            view
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /List of economic code -->

            </div>
        </div>
    </div>


    <!-- Delete Modal -->
    <div class="modal fade" id="delete_modal" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-content p-2">
                            <h4 class="modal-title">Delete</h4>
                            <p class="mb-4">Are you sure want to delete?</p>
                            <button type="submit" class="btn btn-primary" name="delete">Continue </button>
                            <input type="hidden" id="d-id" name="id">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Delete Modal -->



</div>


@endsection
@section('scripts')
<script>
    const ValidateInput = (id) => {
        document.getElementById(id).value = parseFloat(document.getElementById(id).value
            .toString().replace(/\,/g, '')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    const deleteRecord = (id) => {
        document.getElementById('d-id').value = id;
        $("#delete_modal").modal('show')
    }
    const Upload = () => {

        $("#upload").modal('show')
    }


    const Reload = (form) => document.forms[form].submit();

</script>
@endsection

@section('styles')

@endsection
<!-- /Page Wrapper -->
