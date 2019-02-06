@extends('layouts.client')

@section('content')

<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center">My Profile</h2>
<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
    <!-- Error Page Info -->
   <div class="form-body-w3-agile text-center w-lg-50 w-sm-75 w-100 mx-auto mt-5">
                <form  class="form-horizontal " style ="    margin-left: 16%;" action="{{url('client/updateProfile')}}" method="post">
                    @csrf
                    
                    
                    
                    
                    <div class="form-group row">
                        <label class="control-label col-sm-2">Name</label>
                        <input type="text" value ="{{ Auth::user()->name}}" class="form-control col-sm-6" name ="name" placeholder="Enter username" required="">
                    </div>
                    <div class="form-group row">
                        <label  class="control-label col-sm-2" >Email address</label>
                        <input type="email" value ="{{ Auth::user()->email}}" class="form-control col-sm-6" name ="email" placeholder="Enter email" required="" readonly>
                    </div>
                     <div class="form-group row">
                        <label  class="control-label col-sm-2">Contact Number </label>
                        <input type="number" class="form-control col-sm-6" name ="phone" value ="{{ $userDetails->phone }}" placeholder="Enter contact number" required="">
                    </div>
                    <div class="form-group row">
                        <label  class="control-label col-sm-2">Address </label>
                        <input type="text" class="form-control col-sm-6" name ="address" value ="{{ $userDetails->address }}" placeholder="Enter Address" required="">
                    </div>
                    
                    <div class="form-group row">
                        <label  class="control-label col-sm-2">City </label>
                        <input type="text" class="form-control col-sm-6" name ="city" value ="{{ $userDetails->city }}" placeholder="Enter City" required="">
                    </div>
                    
                      <div class="form-group row ">
                        <label  class="control-label col-sm-2" >State </label>
                        <input type="text" class="form-control col-sm-6" name ="state" value ="{{ $userDetails->state }}" placeholder="Enter State" required="">
                    </div>
                    
                     <div class="form-group row">
                        <label  class="control-label col-sm-2">Zip Code </label>
                        <input type="text" class="form-control col-sm-6" name ="zip_code" value ="{{ $userDetails->zip_code }}" placeholder="Enter Zip Code" required="">
                    </div>
                    
                    <button style = " margin-right: 16%;"type="submit" class="btn btn-primary error-w3l-btn mt-sm-5 mt-3 px-4">Update</button>
                </form>
              
            </div>
</div>
@endsection
