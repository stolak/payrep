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
								<h3 class="page-title">Submodule</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Home</a></li>
									<li class="breadcrumb-item active">Submodule</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<!-- include notification -->
        			 @include('_partialView.nofication')
        			 <!-- /include notification -->
					<div class="row">
					    	<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Submodule form</h4>
								</div>
								<div class="card-body">
				<form method="post" action="{{ url('/sub-module/add') }}" class="form-horizontal">
            {{ csrf_field() }}

                      <div class="form-group">
                        <label for="section" class="col-md-3 control-label">Select Module</label>
                        <div class="col-md-9">
                          <select name="module" id="module" class="form-control">
                            <option value="">Select</option>

                          @foreach($modules as $list)
                          @if($list->id == session('moduleId'))
                            <option value="{{$list->id}}" selected="selected">{{$list->module}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->module}}</option>
                            @endif
                            @endforeach
                          </select>
                        </div>
                      </div>

                        <div class="form-group">
                        <label for="section" class="col-md-3 control-label">Sub Module Name</label>
                        <div class="col-md-9">
                          <input  type="text" class="form-control" name="subModule" value="{{ old('subModule') }}" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="section" class="col-md-3 control-label">Route</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" name="route" value="{{ old('route') }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="section" class="col-md-3 control-label">Rank order</label>
                        <div class="col-md-2">
                          <input type="text" class="form-control" name="ranks" value="{{ old('ranks') }}" required>
                        </div>
                      </div>
                      

                     <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                          <button type="submit" class="btn btn-success btn-sm pull-right">Add</button>
                        </div>
                      </div>                      
                    
                       </form>
                       </div>
                       </div>
                       </div>
                 </div>      
				<div class="row">
				
				<div class="col-md-12">
        <table class="table table-striped table-condensed table-bordered input-sm">
          <thead>
          <tr class="input-sm">
              <th>S/N</th>
              <th>Module</th>
              <th>Submodule</th>
              <th>Link</th>
              <th>Rank Order</th>
              <th></th>
              </tr>
          </thead>
          <tbody>
            @php $key = 1; @endphp
            @foreach($submodules as $list)
              <tr>
                  <td>{{$key++}}</td> 
                  <td>{{strtoupper($list->module)}}</td> 
                  <td>{{strtoupper($list->submodule)}}</td> 
                  <td>{{strtoupper($list->links)}}</td>
                  <td>{{strtoupper($list->rank)}}</td>
                  <td><a href="#" title="Edit" onclick="EditSubmodule('{{$list->id}}','{{$list->moduleid}}','{{$list->submodule}}','{{$list->rank}}','{{$list->links}}')" class="btn btn-success fa fa-edit edit"></a></td>          
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
				</div>
				</div>
		
			
			<!-- modal bootstrap -->
<form action="{{url('/sub-module/update')}}" method="post">
{{ csrf_field() }} 
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Update Sub Module</h4>
            </div>
            <div class="modal-body">
           
            <div class="row"> 
             <div class="col-md-12">
          <div class="form-group">
            <label>Select Module</label>
              <select name="modules" class="form-control" id="mos" >
              @foreach($modules as $list)
              <option value="{{$list->id}}" >{{$list->module}}</option>
              @endforeach
              </select>
            </div>
          </div>
        </div>

          <div class="row"> 
           <div class="col-md-12">
          <div class="form-group">
            <label >Sub Module Name</label>
           
              <input id="subModule" type="text" class="form-control" name="subModules" value="" required>
              <input id="subModuleID" type="hidden" class="form-control" name="subModuleID" value="" required>
            </div>
          </div>
        </div>

           <div class="row">
                <div class="col-md-12"> 
          <div class="form-group">
            <label for="section" class="col-md-3 control-label">Route</label>
           
              <input id="routes" type="text" class="form-control" name="routes" value="" required>
            </div>
          </div>
        </div>

      <div class="row"> 
       <div class="col-md-12">
       <div class="form-group">
         <label for="section" class="col-md-3 control-label">Rank</label>
         
            <input id="rank" type="number" class="form-control" name="ranks"  required>
            
          </div>
        </div>
      </div>       



            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
</div>
</form>
<!--// modal Bootstrap -->

			</div>
@endsection
@section('scripts')
<script>

   function EditSubmodule(id,moduleid,submodulename,rank,route)
    {
    $('#mos').val(moduleid);
    $('#subModule').val(submodulename);
   $('#subModuleID').val(id);
    $('#routes').val(route);

   $('#rank').val(rank);
   $("#myModal").modal('show');
   }

    
  </script>      
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->