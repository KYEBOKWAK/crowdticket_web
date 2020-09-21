@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/lib/table/tabulator.css?version=1') }}">
    <style>
        
    </style>
@endsection

@section('content')

<div class="col-sm-12">
  <div class="row">
    <div class="col-sm-12">
      
      <p>
        <div class="form-group">
            <label>이름 조회 </label>
            <input id='form_name' class="form-control">
        </div>
      </p>

      <p>
        <div class="form-group">
            <label>전화번호 뒷자리</label>
            <input id='form_phone_number' class="form-control">
        </div>
        <!-- <button type="button" id="button_user_join_out_data" class="btn btn-default btn-outline" style="padding: 3px 10px;">조회</button> -->
      </p>

      <button type="button" id="button_user_join_out_name_data" class="btn btn-default btn-outline" style="padding: 3px 10px;">조회</button>
      
      <div id="table"></div>
    </div>

  </div>
</div>

@endsection

@section('js')

<script type="text/javascript" src="{{ asset('/js/lib/table/tabulator.min.js') }}"></script>

<script>
  $(document).ready(function () {
    
  });

</script>
@endsection
