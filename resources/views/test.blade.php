@extends('app')
@section('meta')
@endsection
@section('css')
@endsection

@section('content')
<?php
//$project = json_decode($project);
?>
{{ var_dump($project) }}
<!-- <input type="hidden" id="test_json" value="{{ $project }}"/> -->
@endsection

@section('js')
<script>
$(document).ready(function() {
  /*
  var ticketsJson = $('#test_json').val();
  //var tickets = $.parseJSON(ticketsJson.select_ticket_info);
  alert(JSON.stringify(ticketsJson.ticket_count));
  */
});
</script>
@endsection
