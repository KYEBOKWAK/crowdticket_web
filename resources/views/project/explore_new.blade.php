@extends('app')

@section('meta')
  <meta property="og:title" content="이벤트 둘러보기 | 크티"/>
  <meta property="og:description" content="다양한 크리에이터 이벤트를 만나보세요!"/>
  <meta property="og:image" content="{{ asset('/img/app/og_image_3.png') }}"/>
  <meta name="description" content="다양한 크리에이터 이벤트를 만나보세요!"/>
@endsection

@section('title')
    <title>이벤트 | 크티</title>
@endsection



@section('css')
    <style>
    @keyframes blink {
        /**
        * At the start of the animation the dot
        * has an opacity of .2
        */
        0% {
          opacity: .2;
        }
        /**
        * At 20% the dot is fully visible and
        * then fades out slowly
        */
        20% {
          opacity: 1;
        }
        /**
        * Until it reaches an opacity of .2 and
        * the animation can start again
        */
        100% {
          opacity: .2;
        }
    }
    

    .searching span {
        animation-name: blink;
        animation-duration: 1.4s;
        animation-iteration-count: infinite;
        animation-fill-mode: both;
    }

    .searching span:nth-child(2) {
        animation-delay: .2s;
    }

    .searching span:nth-child(3) {
        animation-delay: .4s;
    }
    .searching span:nth-child(4) {
        animation-delay: .6s;
    }

    .mannayo_list_more_wrapper{
      display: none;
      text-align: center;
      margin-bottom: 20px;
    }

    .mannayo_list_more_button{
      width: 140px;
      height: 56px;
      border: 0;
      border-radius: 28px;
      background-color: #f7f7f7;
      font-size: 20px;
      font-weight: 500;
      color: #808080;
    }

    .mannayo_list_loading_container{
      text-align: center;
      font-size: 40px;
    }

    .mannayo_meetup_list_container{
      padding: 0px 0px;
      padding-top: 64px;
    }

    .mannayo_creator_pop_list_title{
      font-size: 24px;
    }

    /*썸네일 CSS START*/
    .welcome_thumb_img_wrapper{
      width: 100%;

      position: relative;
      overflow: hidden;

      border-radius: 10px;
    }

    .welcome_thumb_img_resize{
      position: relative;
      width: 100%;
      /* padding-top: 64%; */
      padding-top: 100%;
      overflow: hidden;
      border-radius: 10px;
    }

    .project-img {
        position:absolute;
        top:0;
        left:0;
        right:0;
        bottom:0;
        max-width:100%;
        margin: auto;
        border-radius: 10px;
    }
    /*썸네일 CSS END*/

    /* 새로운 썸네일 bg START */
    .project-img-bg-blur {
      /* width: 100%; */
      width: 160%;
      /* height: 100%; */
      height: 105%;
      position: absolute;
      top: 50%;
      left: 50%;
      transform:translateX(-50%);
      /*bottom: 0px;*/
      bottom: 50%;
      right: 0px;
      margin: auto;
      background-color: #37343A;
      border-radius: 10px;

      -webkit-filter:blur(5px);
      -moz-filter:blur(5px);
      -o-filter:blur(5px);
      -ms-filter:blur(5px);
      filter:blur(5px);
    }
    /* 새로운 썸네일 bg END */


    .welcome_thumb_container{
      width: 250px;
      margin-bottom: 40px;
    }

    .thumb_container_right_is_mobile{
      margin-right: 20px;
    }

    .welcome_thumb_content_disc{
      height: 13px;
      font-size: 12px;
      color: #808080;
      margin-top: 0px;
      margin-bottom: 8px;
      font-weight: normal;
    }

    .welcome_thumb_content_container{
      margin-top: 20px;
    }

    .welcome_thumb_content_title{
      margin-top: 0px;
      margin-bottom: 6px;
      font-size: 16px;
      font-weight: bold;
      color: black;
      line-height: 1.4;
    }

    .welcome_thumb_content_date_place{
      font-size: 12px;
      line-height: 1.42;
      color: #808080;
    }

    .welcome_thumb_content_type_wrapper{
      width: 65px;
      height: 28px;
      border-radius: 14px;
      border: solid 1px #b3b3b3;
      text-align: center;
    }

    .welcome_thumb_content_type{
      margin-top: 3px;
      margin-bottom: auto;
      color: #808080;
      font-size: 12px;
    }

    .mannayo_flex_second_object{
      margin-left: 20px;
    }

    .mannayo_thumb_object_container_in_main{
      margin-bottom: 40px;
    }

    .isMobileDisable{
      display: block;
    }

    @media (max-width:1060px) {
      .welcome_thumb_container{
        width: 145px;
        /*flex: 1;*/
        flex-basis: 50%;
      }

      .thumb_container_right_is_mobile{
        margin-right: 10px;
      }

      .welcome_thumb_content_title{
        font-size: 14px;
        line-height: 1.29;
        margin-bottom: 3px;
      }

      .welcome_thumb_content_container{
        margin-top: 12px;
      }

      .welcome_thumb_content_disc{
        margin-bottom: 5px;
      }

      .mannayo_flex_second_object{
        margin-left: 0px;
      }

      .isMobileDisable{
        display: none;
      }

      .mannayo_thumb_object_container_in_main{
        flex-basis: 50%;
        /*margin: 0px 5px;*/
      }
    }

    @media (max-width:650px) {
      .mannayo_list_more_button{
        font-size: 16px;
        font-weight: normal;
        color: #808080;
      }
    }
    </style>
    <link href="{{ asset('/css/welcome.css?version=14') }}" rel="stylesheet">
@endsection

@section('content')
<input type='hidden' id='company' value='{{$company}}'>
<div class="welcome_content_container">
    <div class='mannayo_list_container'>
      <div class='mannayo_meetup_list_container'>
      </div>
    </div>

    <div class='mannayo_meetup_list_end_fake_offset'>
    </div>

    <div class="mannayo_list_loading_container mannayo_list_loading_container_main">
      <p class="searching"><span>.</span><span>.</span><span>.</span><span>.</span></p>
    </div>
    <div class="mannayo_list_more_wrapper">
      <button id="mannayo_list_more_button" class="mannayo_list_more_button">
        더보기
      </button>
    </div>
</div>
@endsection

@section('js')
<script>
const INPUT_KEY_TYPE_NORMAL = 'key_type_normal';
const INPUT_KEY_TYPE_ENTER = 'key_type_enter';
const INPUT_KEY_TYPE_MORE = 'key_type_more_button';

const MAIN_FIND_STATE_NORMAL = 0;
const MAIN_FIND_STATE_FIND_API = 1;
const MAIN_FIND_STATE_NO_LIST = 2;
const MAIN_FIND_STATE_NO_LIST_IN_API = 3;
const MAIN_FIND_STATE_NO_MORE = 4;

const CALL_MANNAYO_ONCE_MAX_COUNT = 12;
const CALL_SANDBOX_ONCE_MAX_COUNT = 100;

const MANNAYO_COLUM_COUNT = 4;

var g_mannayoCounter = 0;

//서버와 동일
const SORT_TYPE_NEW = 0;
const SORT_TYPE_EVENT_SANDBOX = 1;
//const SORT_TYPE_MY_MEETUP = 2;

var g_sortType = SORT_TYPE_NEW;

$(document).ready(function () {
  var setSwitchMoreLoading = function(loading, keyType, state){
    if(loading)
    {
      $(".mannayo_list_loading_container").show();
      $(".mannayo_list_more_wrapper").hide();

      if(keyType === INPUT_KEY_TYPE_MORE)
      {
        $(".mannayo_list_container").show();
      }
      else
      {
        $(".mannayo_list_container").hide();
      }
    }
    else
    {
      $(".mannayo_list_loading_container").hide();
      $(".mannayo_list_more_wrapper").show();
      $(".mannayo_list_container").show();
      $('.mannayo_creator_pop_list_title').show();
    }

    if(state === MAIN_FIND_STATE_NO_MORE)
    {
      $(".mannayo_list_more_wrapper").hide();
    }
  };

  var removeMannayoListInMain = function(){
    var mannayoListElement = $(".mannayo_meetup_list_container");
    mannayoListElement.children().remove();
  };

  var addMannayoObject = function(project, parentElement, index){
    var containerClassName = '';
    var firstDiv = '';
    if(index === 0 )
    {
      firstDiv = "<div class='welcome_thumb_container thumb_container_right_is_mobile'>";
      containerClassName = 'welcome_thumb_container thumb_container_right_is_mobile';
    }
    else
    {
      firstDiv = "<div class='welcome_thumb_container'>";
      containerClassName = 'welcome_thumb_container';
    }

    var projectLink = project.link;

    var projectTypeWidth = '';
    if(!project.project_type)
    {
      project.project_type = 'artist';
    }
    
    if(project.project_type === 'artist')
    {
      projectTypeWidth = 'width:54px'
    }

    var projectImgClass = 'img_project_id_' + project.id;

    var mannayoObject = document.createElement("div");
    mannayoObject.className = containerClassName;
    mannayoObject.innerHTML = "<a href='"+projectLink+"'>" +
        "<div class='welcome_thumb_img_wrapper'>" +
          "<img src='"+project.poster_url+"' class='project-img-bg-blur'/>" +
            "<div class='welcome_thumb_img_resize'>" +
                //"<img src='"+project.poster_url+"' onload='imageResize_new($('.welcome_thumb_img_resize')[0], this);' class='project-img'/>" +
                "<img class='"+projectImgClass+" project-img' src='"+project.poster_url+"'/>" +
            "</div>" +
        "</div>" +
        "<div class='welcome_thumb_content_container'>" +
        
            "<h5 class='text-ellipsize welcome_thumb_content_disc'>" +
                project.description +
            "</h5>" +

            "<h4 class='text-ellipsize-2 welcome_thumb_content_title'>" +
                project.title +
            "</h4>" +

            "<p class='welcome_thumb_content_date_place'>" +
              project.ticket_data_slash + ' · ' + project.city_name +
            "</p>" +

            "<div class='welcome_thumb_content_type_wrapper isMobileDisable' style='"+projectTypeWidth+"'>" +
                "<p class='welcome_thumb_content_type'>" +
                    project.project_type +
                "</p>" +
            "</div>" +
            
        "</div>" +
    "</a>" +
    "</div>";

    parentElement.appendChild(mannayoObject);      
    
    $('.'+projectImgClass).on('load', function() {
      //alert("image is loaded");
      imageResize_new($('.welcome_thumb_img_resize')[0], $('.'+projectImgClass)[0]);
    });
  };


  //원본 START
  var setMannayoList = function(projects, requestKeyType){
    var mannayoListElement = $(".mannayo_meetup_list_container");
    if(requestKeyType !== INPUT_KEY_TYPE_MORE)
    {
      removeMannayoListInMain();
    }
    
    var rowCount = Math.ceil((projects.length + 1) / MANNAYO_COLUM_COUNT);
    
    var index = 0;
    for(var i = 0 ; i < rowCount ; i++)
    {
      var mannayoFlexLayer = document.createElement("div");
      mannayoFlexLayer.className = 'mannayo_object_container flex_layer_thumb';
      mannayoListElement.append(mannayoFlexLayer);

      var isEnd = false;

      //2칸씩 flex_layer 해줘야함
      for(var j = 0 ; j < 2 ; j++)
      {
        var objectFlexLayer = document.createElement("div");
        if(j === 1)
        {
          objectFlexLayer.className = 'flex_layer mannayo_flex_second_object';
        }
        else
        {
          objectFlexLayer.className = 'flex_layer';
        }

        mannayoFlexLayer.appendChild(objectFlexLayer);

        for(var k = 0 ; k < 2 ; k++)
        {
          var project = projects[index];
          if(project)
          {
            addMannayoObject(project, objectFlexLayer, k);
          }
          index++;
          
          if(index >= projects.length)
          {
            isEnd = true;
            break;
          }
        }

        if(isEnd)
        {
          break;
        }
      }

      if(isEnd)
      {
        break;
      }
    }
  };
  //원본END
  var requestMannayoList = function(keyType){
    
    setSwitchMoreLoading(true, keyType, MAIN_FIND_STATE_NORMAL);

    var callMannayoOnceMaxCounter = CALL_MANNAYO_ONCE_MAX_COUNT;

    var company = '';
    if($('#company').val())
    {
      company = $('#company').val();
      callMannayoOnceMaxCounter = CALL_SANDBOX_ONCE_MAX_COUNT;
    }
    

    var url="/object/projects";
    var method = 'get';
    var data =
    {
      "sort_type" : g_sortType,
      "call_once_max_counter" : callMannayoOnceMaxCounter,
      "call_skip_counter" : g_mannayoCounter,
      'keytype' : keyType,
      'company' : company
      //'searchvalue': $("#input_mannayo_search").val()
    }
    var success = function(request) {
      if(request.state === 'success')
      {        
        if(request.projects.length < callMannayoOnceMaxCounter)
        {
          //length보다 호출된 개수가 작으면 더보기가 없다
          setSwitchMoreLoading(false, request.keytype, MAIN_FIND_STATE_NO_MORE);
        }
        else
        {
          setSwitchMoreLoading(false, request.keytype, MAIN_FIND_STATE_NORMAL);
        }

        setMannayoList(request.projects, request.keytype);
        g_mannayoCounter += request.projects.length;

        if(request.message)
        {
          swal('해당 MCN 이벤트가 없습니다.', '', 'error');
        }
      }
    };
    
    var error = function(request) {
      setSwitchMoreLoading(false, INPUT_KEY_TYPE_NORMAL, MAIN_FIND_STATE_NORMAL);
      alert('프로젝트 정보 가져오기 실패. 다시 시도해주세요.');
    };
    
    $.ajax({
    'url': url,
    'method': method,
    'data' : data,
    'success': success,
    'error': error
    });
  };

  requestMannayoList(INPUT_KEY_TYPE_NORMAL);

  var isTouchMoreButton = false;  //더보기 처음 터치하면 그 이후부턴 자동 더보기가 된다.

  $("#mannayo_list_more_button").click(function(){
    //requestMannayoList(INPUT_KEY_TYPE_NORMAL);
    requestMannayoList(INPUT_KEY_TYPE_MORE);
    isTouchMoreButton = true;
  });

  $(window).bind('scroll', function(){
    if(isTouchMoreButton && $('.mannayo_list_more_button').is(':visible'))
    {
      var lastObjectName = '.mannayo_meetup_list_end_fake_offset';
      var lastObjectTop = $(lastObjectName).offset().top;
      var targetObjectTop = $(window).scrollTop() + $(window).height();

      if(lastObjectTop < targetObjectTop)
      {
        requestMannayoList(INPUT_KEY_TYPE_MORE);
      }
    }
  });
});
</script>
@endsection
