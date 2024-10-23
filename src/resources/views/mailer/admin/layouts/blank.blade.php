@extends('mailer::app')
@section('body_class', '')

@section('page')

<div class="wrapper">
  <div class="container-fluid">
    @yield('content')
  </div><!--. container -->
</div>
@stop

@section('styles')
@endsection


@section('scripts')
<script src="/pondol/mailer/admin.js"></script>
@endsection
