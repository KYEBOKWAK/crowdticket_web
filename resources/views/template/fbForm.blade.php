<script>
document.getElementById('BtnFBshare').onclick = function() {
  FB.ui({
    method: 'share',
    display: 'popup',
    href: 'https://crowdticket.kr/projects/{{ $project->id }}',
    hashtag: '#크라우드티켓'
  }, function(response){
    if(response) {
      swal("공유 성공!", "예술인에 한발짝 더 다가갔습니다!", "success");
    }
    else {
      //값이 있으면 error 혹은 닫기 버튼 누름
    }

  });
}
</script>
