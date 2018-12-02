<div class="form-body-default-container">
  <div class="project_form_content_container project_form_content_container_ticket_resize">

    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">티켓 관련 공지</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <div class="project_form_ticket_notice_textarea_wrapper">
              <textarea id="ticket_notice_textarea" type="text"
              placeholder="예) 00세 이상 관람이 가능한 공연입니다.&#13;&#10;   티켓수령은 공연 00분전 부터 가능합니다.&#13;&#10;   입장은 공연 00전 부터 가능합니다.&#13;&#10;   전석 자유석이며 선착순 입장입니다.&#13;&#10;   스탠딩으로 이루어져 있습니다.">{{$project->ticket_notice}}</textarea>
              <p style="text-align: right;">티켓을 구매하는 관객들에게 전달해야 하는 메시지를 적어주세요.</p>
            </div>
            <button id="ticket_notice_save" class="btn btn-success center-block">저장하기</button>
          </div>
        </div>
      </div>
    </div>

    <!-- 티켓 추가 리스트 코드 -->
    <input type="hidden" id="tickets_json" value="{{ $project->tickets }}"/>
    <input type="hidden" id="tickets_json_category_info" value="{{$categories_ticket}}"/>
    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">등록된 티켓</p>
        <div class="project-form-content">
            <div id="ticket_list" class="project_form_no_ticket"></div>
            <div id="ticket_no_ticket" style="display: none;" class="project_form_no_ticket">티켓없음</div>
        </div>
      </div>
    </div>

    @if($project->isPlace == "TRUE")
      <!-- 티켓 추가란 -->
      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">이벤트 일시</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <input id="ticket_delivery_date" name="delivery_date" type="text" class="project_form_input_base project_form_delivery_date_wrapper"
                 value="{{ date('Y-m-d', time()) }}"/>

               <select id="ticket_delivery_hour" class="project_form_input_base project_form_delivery_time_wrapper">
                   @for ($i = 1; $i < 25; $i++)
                       <option value="{{ $i }}">{{ $i }} 시</option>
                   @endfor
               </select>

               <select id="ticket_delivery_min" class="project_form_input_base project_form_delivery_time_wrapper">
                   @for ($i = 0; $i < 60; $i = $i + 5)
                       <option value="{{ $i }}">{{ $i }} 분</option>
                   @endfor
               </select>
            </div>
          </div>
        </div>
      </div>
    @else
      <input id="ticket_delivery_date" type="hidden" name="delivery_date" type="text" class="project_form_input_base"
         value="0000-00-00"/>
       <input id="ticket_delivery_hour" type="hidden" class="project_form_input_base" value="0"/>
       <input id="ticket_delivery_min" type="hidden" class="project_form_input_base" value="0"/>
    @endif

    <!-- 티켓 가격 -->
    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">가격</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <input id="ticket_price" name="price" type="number" class="project_form_input_base project_form_ticket_price_wrapper" min="0" value="0"/>
            <p style="margin-bottom: 0px; font-size: 21px; font-weight: bold; margin-left: 5px; margin-top: 3px;">원</p>
          </div>
        </div>
      </div>
    </div>

    <!-- 티켓 매수 -->
    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">티켓 판매 수량</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <input id="ticket_count" name="ticket_count" type="number" class="project_form_input_base project_form_ticket_price_wrapper" min="0" value="0"/>
            <p style="margin-bottom: 0px; font-size: 21px; font-weight: bold; margin-left: 5px; margin-top: 3px;">매
              <span style="font-size: 13px;">(무제한으로 판매를 원하시면 수량을 0매로 설정해주세요)</span>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- 티켓 종류 -->
    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">티켓 종류</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <select id="ticket_category" name="ticket_category" class="project_form_input_base project_form_ticket_category_wrapper">
              @foreach ($categories_ticket as $category_ticket)
                  @if ($category_ticket->id === $project->category_ticket_id)
                      <option value="{{ $category_ticket->id }}" selected>{{ $category_ticket->title }}</option>
                  @else
                      <option value="{{ $category_ticket->id }}">{{ $category_ticket->title }}</option>
                  @endif
              @endforeach
            </select>
            <input id="ticket_category_etc_input" placeholder="예)무료관람권, VIP 티켓 등" type="text" class="project_form_input_base project_form_ticket_category_etc_wrapper"/>

            <!-- 티켓 버튼들 -->
            <div class="project_form_ticket_button_wrapper">
              <div class="flex_layer">
                <button id="cancel_modify_ticket" class="btn btn-default center-block ticket_button_resize">취소하기</button>
                <button id="update_ticket" class="btn btn-success center-block ticket_button_resize">수정하기</button>
                <button id="create_ticket" class="btn btn-success center-block ticket_button_resize">추가하기</button>
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
