<div class="row">
    <div class="col-md-12">
        
         @if(session('message'))
    	        <div class="alert alert-success alert-dismissible" role="alert">
    	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
    	          <strong>Successful!</strong> {{ session('message') }}</div>
	        @endif
	        
	        @if(session('error_message'))
    	        <div class="alert alert-danger alert-dismissible" role="alert">
    	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
    	          <strong>Error!</strong> {{ session('error_message') }}
    	         </div>
	        @endif
	        
	    	@if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Error!</strong> 
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
	        @endif
    </div>
</div>
           