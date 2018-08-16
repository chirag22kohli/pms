@extends('layouts.client')

@section('content')

<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center">QRCODE</h2>
<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">

    <!-- Error Page Info -->
    <div class="outer-w3-agile mt-3">
        <div class="text-center">
           <div class="visible-print text-center">
    {!! QrCode::encoding('UTF-8')->size(300)->generate('Make me a QrCode with special symbols ♠♥!!'); !!}
    <p>Scan me to return to the original page.</p>
   
    <a href="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('helloworld')) !!} " download>Download Image</a>
</div>
    
</div>
        </div>
    </div>
    <!--// Error Page Info -->

</div>
@endsection
