<input type="hidden" id="channels_json" value="{{ $user->channels }}"/>
<div class="form-body-default-container">
  <img src="{{ asset('/img/app/img_update_project_creator.png') }}" class="center-block"/>
  <h2>개설자소개</h2>
  <div class="project-form-subtitle">
      <h5>이 프로젝트를 개설하고자 하는 당신은 누구신가요?
          <br/>
          본인에 대해 명확히 할수록 펀딩에 대한 신뢰도가 올라가고 성공확률이 높아집니다.</h5>
  </div>
  <form id="creator_form" action="{{ url('/users/upload') }}/{{ $user->id }}" method="post" role="form">
    <div class="project-form-content-grid">
      <p class="project-form-content-title">개설자 명</p>
      <div class="project-form-content">
          <input id="name" name="name" maxlength="30" type="text" class="project-form-input"
                 value="{{ $user->name }}"/>
      </div>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">대표전화</p>
      <div class="project-form-content">
          <input id="contact" name="contact" maxlength="30" type="text" class="project-form-input"
                 value="{{ $user->contact }}"/>
      </div>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">대표 이메일</p>
      <div class="project-form-content">
          <input id="email" name="email" maxlength="30" type="text" class="project-form-input"
                 value="{{ $user->email }}"/>
      </div>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">프로필 사진</p>
      <div class="project-form-content">
        <div>
            <div id="user-photo" class="user-photo-middle bg-base pull-left"
                 style="background-image: url('{{ $user->getPhotoUrl() }}');"></div>
            <input id="input-user-photo" type="file" name="photo"
                   style="height: 0; visibility: hidden"/>
            <a href="#" id="profile-upload-photo-fake" class="btn btn-default">변경하기</a>
        </div>
      </div>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">소개</p>
      <div class="project-form-content">
          <input id="introduce" name="introduce" maxlength="30" type="text" class="project-form-input"
                 value="{{ $user->introduce }}"/>
      </div>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">소셜 미디어 채널</p>
      <div id="channel_list"></div>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">정산 유의사항</p>
      <div class="project-form-content">
          <p>1. 크라우드티켓 수수료는 5%이며, PG사 수수료는 3.5%입니다.(총 8.5%)</p>
          <p>2. 결제가 완료된 건에 한하여 총 결제 금액에서 수수료를 제외한 금액을 정산하여 드립니다.</p>
          <p>3. 모든 프로젝트는 티켓팅이 마감된 익일부터 업무일 7일 뒤에 정산됩니다.</p>
          <p>4. 프로젝트 진행자는 크라우드티켓 플랫폼에 올린 대로 프로젝트를 진행할 의무가 있습니다.
            정산을 받은 후 프로젝트를 진행하지 않거나 MD미지급 등, 구매자와의 문제 발생시 크라우드티켓에서는 책임지지 않습니다.</p>
          <p>5. 사업자일 경우 정산 받은 금액에 대한 세금 신고를 성실히 하셔야 합니다.</p>
      </div>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">정산 정보</p>
      <div class="project-form-content">
        <div class="project-form-account-container-grid">
          <p class="project-form-account-title">은행</p>
          <input id="bank" name="bank" type="text" class="project-form-input"
                 value="{{ $user->bank }}"/>
        </div>
        <div class="project-form-account-container-grid">
          <p class="project-form-account-title">계좌번호</p>
          <input id="account" name="account" type="number" class="project-form-input"
                 value="{{ $user->account }}"/>
        </div>
        <div class="project-form-account-container-grid">
          <p class="project-form-account-title">예금주</p>
          <input id="account_holder" name="account_holder" type="text" class="project-form-input"
                 value="{{ $user->account_holder }}"/>
        </div>
      </div>
    </div>

    @include('form_method_spoofing', ['method' => 'put'])
    <button id="save_creator" type="submit" class="btn btn-success center-block">저장하기</button>
  </form>
</div>
<!--
<div class="row ps-update-creator">
    <img src="{{ asset('/img/app/img_update_project_creator.png') }}" class="center-block"/>
    <h2>개설자소개</h2>
    <div class="col-md-12">
        <h5 class="bg-info">이 프로젝트를 개설하고자 하는 당신은 누구신가요?
            <br/>
            본인에 대해 명확히 할수록 펀딩에 대한 신뢰도가 올라가고 성공확률이 높아집니다.</h5>
    </div>
    <div class="col-md-12">
        <h3>프로젝트 개설자 박스가 완성되지 않았나요?
            <br/>
            마이페이지 <strong>'내 정보 수정'</strong>에서 프로필을 완성하세요</h3>
        <div class="text-center link-user-form">
            <a href="{{ url('/users') }}/{{ $user->id }}/form" target="_blank" class="btn btn-primary">개인정보 수정하러 가기</a>
        </div>
        <h5 class="text-center"><strong>수정된 프로필박스는 이렇게 보여요!</strong></h5>
        <div class="col-md-4 col-md-offset-4">
            @include('template.creator_profile', ['user' => $user])
        </div>
    </div>
</div>
-->
