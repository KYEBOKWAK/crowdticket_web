@extends('app')

@section('css')
    <link href="{{ asset('/css/blueprint/project-form-create.css?version=2') }}" rel="stylesheet">
@endsection

@section('content')
<!-- 새로고침 코드 넣으려고 했으나 하나의 아이디로 여러 프로젝트가 있을 수 있기 때문에 바로바로 저장 하는 수 밖에 없음 -->
<div class="project-form-create-container">
    <div class="project-form-create-title-wrapper">
      <h1>
        @if($isProject == 'true')
          <span class="pointColor">프로젝트</span>
          <span> 개설신청</span>
        @else
          <span>제휴 문의</span>
        @endif
      </h1>
      <h5>
        @if($isProject == 'true')
          본 페이지는 운영진만이 열람할 수 있는 기본정보란 입니다. 간단하고 명확하게 입력해주세요!
        @else
          24시간 이내에 입력하신 이메일이나 전화번호로 연락 드리겠습니다.
        @endif
      </h5>
    </div>
  <div class="project-form-create-wrapper">
    @if($isProject == 'true')
      <form id="isProjectForm" action="{{ url('/blueprints') }}" method="post" data-toggle="validator" role="form">
    @else
      <form id="isContactForm" action="{{ url('/question/sendmail') }}" method="post" data-toggle="validator" role="form">
    @endif
        <div class="form-group">
            <p class="project_form_create_title">프로젝트 개설자</p>
            <input id="input-user-intro" name="user_introduction" type="text" class="project_form_create_input"
                   required/>
            <p class="help-block">
                공연기획자 ‘000’, 뮤지션 ‘000’, 먹방 BJ ‘000’, 게임 스트리머 ‘000’, 뷰티 콘텐츠크리에이터 ‘000’ 등
            </p>
        </div>
        <div class="form-group">
          @if($isProject == 'true')
            <p class="project_form_create_title">기획중인 프로젝트</p>
          @else
            <p class="project_form_create_title">문의 내용</p>
          @endif

          @if($isProject == 'true')
            <input id="input-project-intro" name="project_introduction" type="text" class="project_form_create_input"
                   required/>
                   <p class="help-block">
                       인디밴드 ‘000’의 단독콘서트, 극단 ‘000’의 정기공연, 팬미팅, 팬들과 함께하는 먹방 투어 등
                   </p>
           @else
            <textarea id="input-project-intro" class="form-control" style="height:100px" name="project_introduction"></textarea>
           @endif

        </div>
        <div class="form-group">
            <p class="project_form_create_title">이메일</p>
            <input id="input-email" name="contact" type="email" class="project_form_create_input" required/>
        </div>
        @include('helper.contact', [
            'label' => '전화번호',
            'name' => 'tel',
            'help' => '프로젝트 개설을 위한 연락 목적 외에는 절.대. 다른 용도로 사용되지 않습니다. 안심하세요',
            'required' => 'required'
        ])
        <div class="project-form-create-btn-submit-wrapper">
          @if($isProject == 'true')
            <input id="project_form_make_start" type="button" class="project-form-create-btn-submit" value="개설 시작 하기"/>
          @else
            <input id="project_form_contact_us_start" type="button" class="project-form-create-btn-submit" value="문의 하기"/>
          @endif
        </div>
        <!-- 기존 테이블로 인해서 코드 남겨둔다. 나중에 지워주기 -->
        <input type="hidden" name="type" value="sale"/>
        <input type="hidden" name="story" value="none"/>
        <input type="hidden" name="estimated_amount" value="none"/>
        @include('csrf_field')
    </form>
  </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function () {
      $('#project_form_make_start').click(function(){
        //if(!isCheckEmail($('#input-email').val()))
        {
          //return;
        }

        if(!isCheckPhoneNumber($('.concatable-target').val()))
        {
          return;
        }

        loadingProcess($(this));

        $('#isProjectForm').submit();
      });

      $('#project_form_contact_us_start').click(function(){
        //if(!isCheckEmail($('#input-email').val()))
        {
          //return;
        }

        if(!isCheckPhoneNumber($('.concatable-target').val()))
        {
          return;
        }

        loadingProcess($(this));

        $('#isContactForm').submit();
      });
    });
</script>
@endsection
