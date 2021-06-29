<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>크티 : 다운로드 페이지</title>
</head>
<body>

<input id="g_app_type" type="hidden" value="{{env('APP_TYPE')}}"/>

<div id="react_app_file_download_temp_page">
</div>

<script type="text/javascript" src="{{ asset('/dist/App_File_Download_Temp_Page.js?version=0') }}"></script>

</body>
</html>


