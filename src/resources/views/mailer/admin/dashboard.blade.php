@extends('mailer::admin.layouts.main')
@section('title', '회원정보')
@section('content')
@include('mailer::admin.layouts.main-top', ['path'=>['대쉬보드']])



<div class="row">
  <div class="col-6">
    <div class="card">
      <div class="card-header">
        최근발송내역
      </div><!-- .card-header -->
      <div class="card-body">
        <table class="table">
          <col width="*">
          <col width="120px">

          @forelse ($items as $item)
          <tr>
            <td>{{ $item->title }}</td>  
            <td>{{ date('m-d H:m', strtotime($item->created_at)) }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="2">최근 발송된 내역이 존재 하지 않습니다.</td>
          </tr>
          @endforelse

        </table>
      </div><!-- .card-body -->
      <div class="card-footer text-end">
        <a href="{{ route('mailer.admin.index') }}" class="btn btn-primary btn-sm">더 보기</a>
      </div><!-- .card-footer -->
    </div><!-- .card -->
  </div>

</div><!-- .row -->
<div class="line"></div>




@endsection
@section('styles')
    @parent


        
@endsection
@section('scripts')
    @parent

    @endsection
