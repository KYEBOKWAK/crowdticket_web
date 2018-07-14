function checkLoginState() {
  FB.login(function(response) {
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      var url = '/me?fields=id,name,email';
      FB.api(url, function(responseMe) {
        var encodeName = encodeURI(responseMe.name);
        var encodeEmail = encodeURI(responseMe.email);
        var encodePreviousURL = encodeURIComponent(document.referrer);
        //var parameter = responseMe.id+"/"+encodeName+"/"+encodeEmail;
        var parameter = responseMe.id+"/"+encodeName+"/"+encodeEmail+"/"+encodePreviousURL;

        var baseUrl = $('#base_url').val();

        window.location.assign(baseUrl+'/facebook/callback/'+parameter);
      });

    } else {
      // The person is not logged into your app or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
  });
}
