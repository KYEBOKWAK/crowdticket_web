function checkLoginState() {
  FB.login(function(response) {
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      var url = '/me?fields=id,name,email';
      FB.api(url, function(responseMe) {

        var baseUrl = $('#base_url').val();
        var encodeName = responseMe.name;
        var encodeEmail = responseMe.email;
        var encodePreviousURL = document.referrer;


        if(baseUrl == "http://localhost:8000") {
          //로컬 서버일 경우 encode 해서 넘겨준다. 아파치 서버는 자체 encode decode 기능이 있다.
          //mod_rewrite 관련 정보
          encodeName = encodeURI(responseMe.name);
          encodeEmail = encodeURI(responseMe.email);
          encodePreviousURL = encodeURIComponent(document.referrer);
        }

        var parameter = responseMe.id+"/"+encodeName+"/"+encodeEmail+"/"+encodePreviousURL;

        window.location.assign(baseUrl+'/facebook/callback/'+parameter);
      });

    } else {
      // The person is not logged into your app or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
  });
}
