<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <link href='https://fonts.googleapis.com/earlyaccess/notosanskr.css' rel='stylesheet' type='text/css'/>
    <link href="{{ asset('/css/terms.css') }}" rel="stylesheet"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>
<body>
    <div class='agreement_container_app'>
        <div class='terms_version_container'>
            <div class='terms_version_selector'>
                <div class='terms_version_selector_content'>
                    <p id='terms_version_text' style='margin: 16px auto 16px 16px'>2020-09-01</p>
                    <img src="../img/icons/svg/icon-box.svg" style='margin-right: 16px;'>
                </div>
                <select id='terms_version_select' name='terms_version_select' onchange='termsVersionChange()'>
                    <option value = "2020-09-01">2020-09-01 v2.0</option>
                    <option value = "2016-01-01">2016-01-01 v1.0</option>
                </select>
            </div>
        </div>
        <div class='privacyterms_v2'>
            @include ('helper.privacy_content_v2')
        </div>
        <div class='privacyterms_v1' style = "display:none;">
            @include ('helper.privacy_content_v1')
        </div>
    </div>
    
    <script type="text/javascript">
        function termsVersionChange(){
            var selectedVersion = document.getElementById('terms_version_select').value;
            if(selectedVersion == '2016-01-01'){
                $('.privacyterms_v2').hide();
                $('.privacyterms_v1').show();
                document.getElementById('terms_version_text').innerHTML = "2016-01-01";
            }
            else{
                $('.privacyterms_v1').hide();
                $('.privacyterms_v2').show();
                document.getElementById('terms_version_text').innerHTML = "2020-09-01";
            } 
        };
    </script>
</body>
</html>