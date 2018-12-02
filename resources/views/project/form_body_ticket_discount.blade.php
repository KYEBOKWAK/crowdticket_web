<input type="hidden" id="discounts_json" value="{{ $project->discounts }}"/>
<input type="hidden" id="isDiscount" value="{{ $project->isDiscount }}" >

<div class="form-body-default-container">
  <div class="project_form_content_container project_form_content_container_ticket_resize">

    <div class="project_form_input_container">
      <div class="flex_layer">
        <p class="project-form-content-title project_flex_discount_title_resize">할인 정보 없음</p>
        <div class="project-form-content">
            <input id="discount_checkbox" class="project_form_checkbox" type="checkbox"/>
        </div>
      </div>
    </div>

    <div class="project_form_discount_content_container">
      <!-- 티켓 추가 리스트 코드 -->
      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">등록된 할인 정보</p>
          <div class="project-form-content">
              <div id="discount_list" class="project_form_no_ticket"></div>
              <div id="discount_no_list" style="display: none;" class="project_form_no_ticket">할인없음</div>
          </div>
        </div>
      </div>

      <!-- 할인 조건 등록 -->
      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">할인 조건</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <input id="discount_content_input" name="discount_content_input" type="text" class="project_form_input_base project_form_discount_need_wrapper" placeholder="예)청소년 할인, 재관람 할인, 장애인 할인"/>
            </div>
          </div>
        </div>
      </div>

      <!-- 할인율 -->
      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">할인율</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <input id="discount_percent_value_input" name="discount_percent_value_input" type="number" class="project_form_input_base project_form_discount_value_wrapper"/>
              <p style="margin-bottom: 0px; font-size: 21px; font-weight: bold; margin-left: 5px; margin-top: 3px;">%</p>
            </div>
          </div>
        </div>
      </div>

      <!-- 할인 조건 등록 -->
      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">할인 조건 확인 절차</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <input id="discount_submit_input" name="discount_submit_input" type="text" class="project_form_input_base discount_submit_input_wrapper" placeholder="예)관련 증명서를 현장에서 제시해야 합니다."/>

              <!-- 티켓 버튼들 -->
              <div class="project_form_ticket_button_wrapper">
                <div class="flex_layer">
                  <button id="cancel_modify_discount" class="btn btn-default ticket_button_resize">취소하기</button>
                  <button id="update_discount" class="btn btn-success ticket_button_resize">수정하기</button>
                  <button id="create_discount" class="btn btn-success ticket_button_resize">추가하기</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="project_form_button_wrapper project_form_button_wrapper_ticket_resize">
      <div class="flex_layer">
        <button class="ticket_go_next btn btn-success center-block project_form_button pointBackgroundColor">다음</button>
      </div>
    </div>

  </div>
</div>
