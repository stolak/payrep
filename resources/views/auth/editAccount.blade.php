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
                    <h3 class="page-title">User Account</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">My Account Setting</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- include notification -->
        @include('_partialView.nofication')
        <!-- /include notification -->
        <div class="panel-body">

        <form method="post" >
        {{ csrf_field() }}

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Names</label>
                        <input type="text" class="form-control " value="{{ Auth::user()->name }}" readonly> 
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Username/Email</label>
                        <input type="text"class="form-control "value="{{ Auth::user()->email }}" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <input type="password" name="password" class="form-control " autocomplete="off" required autocomplete="off">
                    </div>
                </div>
            
                <div class="col-sm-6">
                    <div class="form-group">
                    <label class="control-label">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off">
                    </div>
                </div>

            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-success" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>

   
  </script>
@endsection

@section('styles')

@endsection
			<!-- /Page Wrapper -->