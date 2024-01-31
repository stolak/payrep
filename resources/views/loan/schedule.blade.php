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
								<h3 class="page-title">Loan Schedule</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Loan Schedule</li>
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
										
										<div class="row">
										    <div class="col-md-2">
												<div class="form-group">
													<label>Principal</label>
													<div class="input-group">
                                                        <input type="text" id="amount" name="amount"
														value="{{$amount}}" class="form-control"
														style="text-align: right;"  autocomplete="off"
														onblur='ValidateInput("amount");'
														>
                                                    </div>
												</div>
											</div>
											<div class="col-md-2">
											    <div class="form-group">
													<label>Repayment Period</label>
													<select class="select2 form-control" name="period" id="period"
													>
														<option value="" >--Select--</option>
														@for ($i = 1; $i <= 24; $i++)
														<option value="{{$i}}" {{ ($period==$i)? 'selected':''}}>{{$i}} month{{$i>1? 's':''}}</option>
														@endfor
													</select>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>Rate%</label>
													<div class="input-group">
                                                        <input type="text" id="rate" name="rate"
														value="{{$rate}}" class="form-control" >
												</div>
											</div>
										</div>
										
										<div class="text-right">
											<button type="submit" class="btn btn-primary" name="addnew">Submit</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					
				<div class="row">
						<div class="col-md-12">
						
						
							<div class="card card-table">
								<div class="card-header">
									<h4 class="card-title"> Schedule</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th rowspan="1">S/N</th>
													<th rowspan="1">Opening Balance</th>
													<th rowspan="1">Interest</th>
													<th rowspan="1">Repayment</th>
													<th rowspan="1">Balance</th>
												</tr>
											</thead>
											<tbody>
											    @php $sn=1;@endphp
											   @foreach($Loans as $list)
												<tr>
													<td >
														Month {{$sn++}}
													</td>
													<td >
													{{number_format($list->opening_balance,2, '.', ',')}}
													</td>
													<td >
													{{number_format($list->interest,2, '.', ',')}}
													</td>
													<td >
													{{number_format($list->repayment,2, '.', ',')}}
													</td>
													<td >
													{{number_format($list->balance,2, '.', ',')}}
													</td>
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
		
			
			
		
			</div>
			
@endsection
@section('scripts')
<script>

	const ValidateInput=(id)=>{
    document.getElementById(id).value = formatValue(document.getElementById(id).value);
   }

   const formatValue=(val)=>{
    return parseFloat(val
		.toString().replace(/\,/g,'')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   }
	</script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->