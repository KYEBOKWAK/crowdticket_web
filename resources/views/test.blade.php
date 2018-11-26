@extends('app')
@section('meta')
@endsection
@section('css')
@endsection

@section('content')
<?php
//$projects = json_decode($projecta, true);
?>
{{ var_dump($project) }}

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
