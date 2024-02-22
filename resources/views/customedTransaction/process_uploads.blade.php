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
                    <h3 class="page-title">Transaction upload</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Transaction upload</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- include notoifcation -->
        @include('_partialView.nofication')
        <!-- /include notoifcation -->
        <form method="post" name="mainform" id="mainform">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            {{ csrf_field() }}
                            <div class="text-right">

                            </div>
                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Transaction Type </label>

                                        <select class="select2 form-control" name="transactionType" id="transactionType"
                                            onchange='Reload("mainform");'>
                                            <option value="All">--All--</option>
                                            @foreach($transactionTypes as $list)
                                            <option value="{{$list->id}}"
                                                {{$transactionType == (string) $list->id? 'selected':''}}>
                                                {{$list->description}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>From</label>
                                        <input type="date" value="{{$fromDate}}" name="fromDate" class="form-control"
                                            autocomplete="off">

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>To</label>
                                        <input type="date" value="{{$toDate}}" name="toDate" class="form-control"
                                            autocomplete="off">

                                    </div>
                                </div>

                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>

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
                                            <th rowspan="1">Date</th>
                                            <th rowspan="1">Account Name</th>
                                            <th rowspan="1">Account Number</th>
                                            <th rowspan="1">Trans. Type</th>

                                            <th rowspan="1">Debit </th>
                                            <th rowspan="1">Credit</th>
                                            <th rowspan="1">Fees</th>
                                            <th rowspan="1">Bank Charges</th>
                                            <th rowspan="1">Agent Commission</th>
                                            <th rowspan="1">Bonus</th>
                                            <th rowspan="1">Aggregator Commission</th>
                                            <th rowspan="1">Aggregator Referral</th>
                                            <th rowspan="1">Company Commission</th>
                                            <th rowspan="1">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $sn=1;
                                        $sum_debits=0;
                                        $sum_credits=0;
                                        $sum_fees=0;
                                        $sum_bank_charges=0;
                                        $sum_agent_commission=0;
                                        $sum_bonus=0;
                                        $sum_aggregator_commission=0;
                                        $sum_aggregator_referral=0;
                                        $sum_company_commission=0;


                                        @endphp
                                        @foreach($records as $list)
                                        @php
                                        $sum_debits +=$list->debits;
                                        $sum_credits +=$list->credits;
                                        $sum_fees +=$list->fees;
                                        $sum_bank_charges +=$list->bank_charges;
                                        $sum_agent_commission +=$list->agent_commission;
                                        $sum_bonus +=$list->bonus;
                                        $sum_aggregator_commission +=$list->aggregator_commission;
                                        $sum_aggregator_referral +=$list->aggregator_referral;
                                        $sum_company_commission +=$list->company_commission;
                                        @endphp
                                        <tr>
                                            <td>
                                                {{$sn++}}
                                            </td>
                                            <td>
                                                {{$list->formatted_date}}
                                            </td>
                                            <td>
                                                {{$list->account_name}}
                                            </td>
                                            <td>
                                                {{$list->account_number}}

                                            </td>
                                            <td>
                                                {{$list->transaction_type}}
                                            </td>


                                            <td style="text-align: right;">
                                                {{number_format($list->debits,2, '.', ',')}}

                                            </td>
                                            <td style="text-align: right;">
                                                {{number_format($list->credits,2, '.', ',')}}
                                            </td>
                                            <td style="text-align: right;">
                                                {{number_format($list->fees,2, '.', ',')}}
                                            </td>


                                            <td>
                                                {{number_format($list->bank_charges,2, '.', ',')}}
                                            </td>
                                            <td style="text-align: right;">
                                                {{number_format($list->agent_commission,2, '.', ',')}}
                                            </td>
                                            <td style="text-align: right;">
                                                {{number_format($list->bonus,2, '.', ',')}}
                                            </td>

                                            <td style="text-align: right;">
                                                {{number_format($list->aggregator_commission,2, '.', ',')}}
                                            </td>
                                            <td>
                                                {{number_format($list->aggregator_referral,2, '.', ',')}}
                                            </td>
                                            <td style="text-align: right;">
                                                {{number_format($list->company_commission,2, '.', ',')}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                                Total
                                            </td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                            <td>


                                            </td>
                                            <td>

                                            </td>


                                            <td style="text-align: right;">
                                                {{number_format($sum_debits,2, '.', ',')}}

                                            </td>
                                            <td style="text-align: right;">
                                                {{number_format($sum_credits,2, '.', ',')}}
                                            </td>
                                            <td style="text-align: right;">
                                                {{number_format($sum_fees,2, '.', ',')}}
                                            </td>


                                            <td>
                                                {{number_format($sum_bank_charges,2, '.', ',')}}
                                            </td>
                                            <td style="text-align: right;">
                                                {{number_format($sum_agent_commission,2, '.', ',')}}
                                            </td>
                                            <td style="text-align: right;">
                                                {{number_format($sum_bonus,2, '.', ',')}}
                                            </td>

                                            <td style="text-align: right;">
                                                {{number_format($sum_aggregator_commission,2, '.', ',')}}
                                            </td>
                                            <td>
                                                {{number_format($sum_aggregator_referral,2, '.', ',')}}
                                            </td>
                                            <td style="text-align: right;">
                                                {{number_format($sum_company_commission,2, '.', ',')}}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <!-- /List of economic code -->
                    <div class="text-right">
                        <button type="submit" name="process" class="btn btn-primary">Process</button>
                    </div>
                </div>
            </div>
        </form>
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
