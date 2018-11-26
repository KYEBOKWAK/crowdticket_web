<input type="hidden" id="channels_json" value="{{ $user->channels }}"/>

<div class="form-body-default-container">
  <div class="project_form_title_wrapper">
    <h2 class="project_form_title"><span class="pointColor">개설자</span> 정보</h2>
  </div>

  <div class="project_form_content_container">
    <form id="creator_form" action="{{ url('/users/upload') }}/{{ $user->id }}" method="post" role="form">
      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">개설자 명</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <input id="name" name="name" type="text" class="project_form_input_base project_form_creator_name_input" value="{{ $user->name }}"/>
            </div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">대표전화</p>
          <div class="project-form-content">
              <input id="contact" name="contact" type="number" class="project_form_input_base project_form_creator_contact_input" maxlength="31" value="{{ $user->contact }}"/>
              <p style="margin-top: 5px; margin-bottom: 0px;"> '-' 없이 숫자만 입력</p>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">대표 이메일</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <input id="email" name="email" type="email" class="project_form_input_base project_form_creator_email_input" maxlength="31" value="{{ $user->email }}"/>
            </div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">프로필 사진</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <div id="user-photo" class="user-photo-middle bg-base pull-left" style="background-image: url('{{ $user->getPhotoUrl() }}');">
              </div>
              <div id="user-default-photo" class="user-photo-middle bg-base pull-left" style="display: none; background-image: url('{{ asset('/img/app/default-user-image.png') }}');">
              </div>

              <div style="margin-top: 82px;">
                <a href="javascript:void(0);" style="cursor:pointer" id="profile-upload-photo-fake"><img src="https://img.icons8.com/windows/50/333333/pencil.png" class="ticket_tickets_button_wrapper"/></a>
                <a href="javascript:void(0);" style="cursor:pointer" id="profile-delete-photo"><img src="https://img.icons8.com/windows/50/EF4D5D/trash.png" class="ticket_tickets_button_wrapper"/></a>
              </div>

              <input id="input-user-photo" type="file" name="photo" style="height: 0; visibility: hidden"/>
              <input id="isdeletephoto" type="hidden" name="isdeletephoto" value=""/>
            </div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">개설자 소개</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <input id="introduce" name="introduce" type="text" class="project_form_input_base" value="{{ $user->introduce }}"/>
            </div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">소셜미디어 채널</p>
          <div class="project-form-content">
            <div id="channel_list"></div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">정산 유의사항</p>
          <div class="project-form-content">
            <div class="project_form_calcul_notice">
              <p>1. 크라우드티켓 수수료는 5%이며, PG사 수수료는 3.5%입니다.(총 8.5%)</p>
              <p>2. 결제가 완료된 건에 한하여 총 결제 금액에서 수수료를 제외한 금액을 정산하여 드립니다.</p>
              <p>3. 모든 프로젝트는 티켓팅이 마감된 익일부터 업무일 7일 뒤에 정산됩니다.</p>
              <p>4. 프로젝트 진행자는 크라우드티켓 플랫폼에 올린 대로 프로젝트를 진행할 의무가 있습니다.
                정산을 받은 후 프로젝트를 진행하지 않거나 MD미지급 등, 구매자와의 문제 발생시 크라우드티켓에서는 책임지지 않습니다.</p>
              <p>5. 사업자일 경우 정산 받은 금액에 대한 세금 신고를 성실히 하셔야 합니다.</p>
            </div>
            <p class="project_form_calcul_notice_check_text">내용을 읽고 확인 했습니다.<input style="margin-left:5px;" id="calcul_notice_check" type="checkbox"/></p>
          </div>
        </div>
      </div>

      <div class='order_form_conform_title'>
        <h3>
          정산정보<span style="font-size: 12px; margin-left: 5px;"> | 입력하신 내용이 틀리지 않도록 반드시 확인해주세요!</span>
        </h3>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">은행</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <input id="bank" name="bank" type="text" class="project_form_input_base project_form_creator_bank_input" value="{{ $user->bank }}"/>
            </div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">계좌번호</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <input id="account" name="account" type="text" class="project_form_input_base project_form_creator_account_input" value="{{ $user->account }}"/>
            </div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">예금주</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <input id="account_holder" name="account_holder" type="text" class="project_form_input_base project_form_creator_account_holder_input" value="{{ $user->account_holder }}"/>
            </div>
          </div>
        </div>
      </div>

      <div class="project_form_button_wrapper" style="width: 110px; margin-right: 0px;">
        <div class="flex_layer">
          @include('form_method_spoofing', ['method' => 'put'])
          <button id="save_creator" type="button" class="btn btn-success center-block project_form_button pointBackgroundColor">저장</button>
        </div>
      </div>
    </form>
  </div>
</div>
