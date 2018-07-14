<script>
document.getElementById('BtnFBshare').onclick = function() {
  FB.ui({
    method: 'share',
    display: 'popup',
    href: 'https://crowdticket.kr/projects/{{ $project->id }}',
    hashtag: '#크라우드티켓'
  }, function(response){
    if (response && !response.error_code) {
      if(response.error_code != 4201)//4201 code: 유저가 cancel 했을때
      {
        swal("공유 성공!", "예술인에 한발짝 더 다가갔습니다!", "success");
      }
    } else {
    }
  });
}
</script>
