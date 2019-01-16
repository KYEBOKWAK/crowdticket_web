<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <!-- sweetAlert JS -->
    <script src="{{ asset('/js/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-93377526-1', 'auto');
        ga('send', 'pageview');

    </script>

  </head>
  <body>
    <style>
    .swal-icon--success__ring{
      border: 4px solid hsla(358, 65%,69%,.2);
    }

    .swal-icon--success{
      border-color: #ea535a;
    }

    .swal-icon--success__line{
      background-color: #ea535a;
    }

    .swal-button{
      background-color: #ea535a !important;
    }
    </style>
    <script>
      swal("문의 완료!", "", "success").then((value) => {
        //var win = window.open("about:blank", "_self");
        //win.close();
        window.location = '/';
      });
    </script>
  </body>
</html>
