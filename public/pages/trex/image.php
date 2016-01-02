<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>이미지 첨부</title>
<script src="../../js/easy_daum_editor.js"></script> 
<script src="../../js/popup.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="../../css/popup.css" type="text/css"  charset="utf-8"/>
</head>
<body>
<div class="wrapper">
	<div class="header">
		<h1>사진 첨부</h1>
	</div>	
	<form id="image_form" class="body" method="post" action="<?php echo $_GET['url']; ?>">
		<input id="image" type="file" name="image" accept="image/*" />
		<img id="image_preview" width="600" height="400" />
		<input type="hidden" name="_method" value="PUT">
		<input type="hidden" name="_token" value="<?php echo $_GET['csrf_token']; ?>" />
		<div class="footer">
			<p><a href="#" onclick="closeWindow();" title="닫기" class="close">닫기</a></p>
			<ul>
				<li class="submit"><input href="#" type="submit" class="btnlink" value="등록" /></li>
				<li class="cancel"><a href="#" onclick="closeWindow();" title="취소" class="btnlink">취소</a></li>
			</ul>
		</div>
	</form>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="../../js/jquery.form.min.js"></script>
<script src="../../js/editor_image_uploader.js"></script>
</body>
</html>