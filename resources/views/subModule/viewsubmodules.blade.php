@extends('layouts.layout')
@section('pageTitle')
	 View Module
@endsection

@section('content')
<div class="box box-default" style="border-top: none;">


    <div class="row container-fluid">
      <div class="col-md-12"> <br>
        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Error!</strong> @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach </div>
        @endif                       
        
        @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Success!</strong> {{ session('message') }}</div>
        @endif
        @if(session('error_message'))
        <div class="alert alert-error alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Error!</strong> {{ session('error_message') }}</div>
        @endif
      </div>
    </div>

	<form action="" method="post">
	{{ csrf_field() }}
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
          <span class="pull-right" style="margin-right: 30px;">
          	 <div style="float: left;">
          	 	<div class="wrap">
    				   <div class="search"> 
               <button type="submit" class="btn btn-default" style="padding: 6px; float: right; border-radius: 0px;">
                <i class="fa fa-search"></i>
              </button>
				       <input type="text" id="autocomplete_central" name="q" class="form-control" placeholder="Search By Name or File No." style="padding: 5px; width: 300px;"><!--searchTerm-->
				       <input type="hidden" id="fileNo"  name="fileNo">
                <input type="hidden" id="monthDay"  name="monthDay" value="">
				      </div>
				      </div>
          	 </div>
          </span>
        </form>
        <form method="post" action="{{url('/manpower/view/central')}}">
          {{ csrf_field() }}
            <!--<span class="hidden-print">
                 <span class="pull-right" style="margin-left: 5px;">
                  <div style="float: left; width: 100%; margin-top: -20px;">
                     <button type="submit" class=" btn btn-default" style="padding: 6px; border-radius: 0px;">Staff Due for Increment Today</button>
                  </div>
                  <input type="hidden" id="monthDay"  name="monthDay" value="{{date('Y-m-d')}}">
                  <input type="hidden" id="fileNo"  name="fileNo" value="">
                  <input type="hidden" id="filterDivision"  name="filterDivision" value="">
                </span>
                <a href="{{url('/map-power/view/central')}}" title="Refresh" class="pull-right">
                  <i class="fa fa-refresh"></i> Refresh
                </a>
            </span>-->
        </form>
    </div>

    <div style="margin: 10px 20px;">
    	
    @if(session('err'))
  		<div class="col-sm-12 alert alert-warning alert-dismissible hidden-print" role="alert">
  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
  		</button>
  		<strong>Error!</strong> 
  		{{ session('err') }} 
  		</div>                        
	 @endif

	</div>

	<div class="box-body">
		<div class="row">
			{{ csrf_field() }}

			<div class="col-md-12">
				<table class="table table-striped table-condensed table-bordered input-sm">
					<thead>
          <tr class="input-sm">
  						<th>S/N</th>
  						<th>MODULE</th>
              <th>SUB MODULE</th>
              <th>URL (Route)</th>
  						<th>DATE CREATED</th>
  						<th colspan="2"></th>
              </tr>
					</thead>
					<tbody>
						@php $key = 1; @endphp
            @foreach($submodules as $list)
  						<tr>
                  <td>{{($submodules->currentpage()-1) * $submodules->perpage() + $key ++}}</td> 
                  <td>{{strtoupper($list->modulename)}}</td> 
                  <td>{{strtoupper($list->submodulename)}}</td>
                  <td>{{strtoupper($list->route)}}</td> 
                  <td>{{$list->created_at}}</td>
                  <td><a href="{{url('/sub-module/edit/'.$list->submoduleID)}}" title="Edit" class="btn btn-success fa fa-edit"></a></td>
                  <td> <button type="button" data-toggle="modal" data-target="#delete{{$list->submoduleID}}" class="btn btn-default btn-sm"> <i class="fa fa-trash"></i></button></td>        
              </tr>
            @endforeach
					</tbody>
				</table>
          <hr />
          <div align="right">
              Showing {{($submodules->currentpage()-1)*$submodules->perpage()+1}}
                      to {{$submodules->currentpage()*$submodules->perpage()}}
                      of  {{$submodules->total()}} entries
          </div>
          <div class="hidden-print">{{ $submodules->links() }}</div>
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>

<!--DELETE-->
 <form id="saveSelectForm" method="post" action="{{url('/sub-module/delete')}}">
    {{ csrf_field() }}
    <div class="modal fade" id="delete{{$list->submoduleID}}" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: red; color: white; border: 1px solid white;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"> DELETE SuB-MODULE !</h4>
                </div>
                <div class="modal-body col-sm-12" style="padding: 10px;">
                    Are you sure you want to DELETE this Submodule?
                    <hr />
                    <p>NOTE</p>
                    <p>YES: To Delete</p>
                    <p>Cancel: To Cancel</p>                                 
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="subModuleName" value="{{$list->submoduleID}}">
                    <button type="submit" class="btn btn-default btn-sm">Yes. Delete Now </button>
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
          </div>
    </div>
</form>
<!-- //DELETE Modal Dialog -->


@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
      $("#autocomplete_central").autocomplete({
        serviceUrl: murl + '/staff/search/json',
        minLength: 10,
        onSelect: function (suggestion) {
            $('#fileNo').val(suggestion.data);
            showAll();
        }
      });
  });

  $("#searchDate").datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1910:2090', // specifying a hard coded year range
    showOtherMonths: true,
    selectOtherMonths: true,
    dateFormat: "dd MM, yy",
    onSelect: function(dateText, inst){
      var theDate = new Date(Date.parse($(this).datepicker('getDate')));
      var dateFormatted = $.datepicker.formatDate('yy-mm-d', theDate);
       $('#fileNo').val($.datepicker.formatDate('yy-m-d', theDate));
    },
  });

</script>
@stop

@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@stop







