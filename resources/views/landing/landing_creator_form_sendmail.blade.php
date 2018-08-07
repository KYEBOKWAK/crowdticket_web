<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
      swal("신청 완료!", "", "success").then((value) => {
        var win = window.open("about:blank", "_self");
        win.close();
      });
    </script>
  </body>
</html>
