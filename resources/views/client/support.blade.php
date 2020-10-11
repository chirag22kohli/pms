@extends('layouts.client')

@section('content')


<h2 class="main-title-w3layouts mb-2 text-center">Help and Support</h2>
<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">
    <div class="flash-message">
        </br>
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))

        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
        @endforeach
    </div>
    <!-- Error Page Info -->
    <div class="outer-w3-agile mt-3">
        <p class="paragraph-agileits-w3layouts">Please enter the following Support form to get 
            assistance from CHAP. We would love to help you out!
        </p>
    </div>
    <div class="outer-w3-agile col-xl mt-3">
        <h4 class="tittle-w3-agileits mb-4">Get Support</h4>
        <form action="createSupport" method="post">
            {!! Form::token() !!}
            <div class="form-group">
                <label for="exampleFormControlInput1">Email address</label>
                <input type="email" name ="email" value = "{{ Auth::user()->email }}" class="form-control" id="exampleFormControlInput1" placeholder="{{ Auth::user()->email }}" required="" readonly> 
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Reason</label>
                <select name ="reason"   class="form-control" id="exampleFormControlSelect1">
                    <option value = "ar">AR Experience</option>
                    <option value = "payment" >Payment</option>
                    <option value = "other">Other</option>

                </select>
            </div>

            <div class="form-group">
                <label for="issue">Please elaborate the Issue so we could assist you better.</label>
                <textarea  name ="description" class="form-control" id="exampleFormControlTextarea1" rows="3" required=""></textarea>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <!--// Error Page Info -->

</div>
@endsection
