<?php
$isFirst = false;
if(!isset($_COOKIE['_ga']))
{
    $isFirst = true;
}
?>

<input id="isFirst" value="{{$isFirst}}" type="hidden"/>

<script>
$(document).ready(function() {
    if($("#isFirst").val())
    {
        //alert("asdf");
    }
});
</script>