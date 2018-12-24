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
                <form action="{{url('client/updateProfile')}}" method="post">
                    @csrf
                    
                    
                    
                    
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" value ="{{ Auth::user()->name}}" class="form-control" name ="name" placeholder="Enter username" required="">
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" value ="{{ Auth::user()->email}}" class="form-control" name ="email" placeholder="Enter email" required="" readonly>
                    </div>
                     <div class="form-group">
                        <label>Contact Number </label>
                        <input type="number" class="form-control" name ="phone" value ="{{ $userDetails->phone }}" placeholder="Enter contact number" required="">
                    </div>
                    <div class="form-group">
                        <label>Address </label>
                        <textarea class="form-control" name ="address" placeholder="Add Address">{{ $userDetails->address }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>City </label>
                        <input type="text" class="form-control" name ="city" value ="{{ $userDetails->city }}" placeholder="Enter City" required="">
                    </div>
                    
                      <div class="form-group">
                        <label>State </label>
                        <input type="text" class="form-control" name ="state" value ="{{ $userDetails->state }}" placeholder="Enter State" required="">
                    </div>
                    
                     <div class="form-group">
                        <label>Zip Code </label>
                        <input type="text" class="form-control" name ="zip_code" value ="{{ $userDetails->zip_code }}" placeholder="Enter Zip Code" required="">
                    </div>
                    
                    <button type="submit" class="btn btn-primary error-w3l-btn mt-sm-5 mt-3 px-4">Update</button>
                </form>
              
            </div>
</div>
@endsection
