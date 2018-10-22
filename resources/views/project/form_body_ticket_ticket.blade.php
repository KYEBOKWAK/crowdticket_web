<div class="form-body-default-container">
  <div class="project-form-content-grid">
    <p class="project-form-content-title">티켓 관련 공지</p>
    <div class="project-form-ticket-notice-content-grid">
      <div>
        <textarea id="ticket_notice_textarea" type="text" style="width: 100%;">{{ $project->ticket_notice }}</textarea>
        <p>티켓을 구매하는 관객들에게 전달해야 하는 메시지를 적어주세요.</p>
      </div>
      <button id="ticket_notice_save" class="btn btn-success center-block">저장하기</button>
    </div>
  </div>
  <!-- 티켓 추가 리스트 코드 -->
  <input type="hidden" id="tickets_json" value="{{ $project->tickets }}"/>
  <input type="hidden" id="tickets_json_category_info" value="{{$categories_ticket}}"/>
  <div class="project-form-content-grid">
    <p class="project-form-content-title">등록된 티켓</p>
    <div id="ticket_list" class="row"></div>
  </div>
  <!-- 티켓 추가 리스트 코드 end -->
  <div class="project-form-content-grid">
    <p class="project-form-content-title">공연일시</p>
    <div class="project-form-ticket-date-container-grid">
        <input id="ticket_delivery_date" name="delivery_date" type="text" class="form-control"
               value="{{ date('Y-m-d', time()) }}"/>

         <select id="ticket_delivery_hour" class="form-control">
             @for ($i = 1; $i < 25; $i++)
                 <option value="{{ $i }}">{{ $i }} 시</option>
             @endfor
         </select>

         <select id="ticket_delivery_min" class="form-control">
             @for ($i = 0; $i < 60; $i = $i + 5)
                 <option value="{{ $i }}">{{ $i }} 분</option>
             @endfor
         </select>
    </div>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">가격</p>
    <div class="project-form-ticket-price-container-grid">
      <input id="ticket_price" name="price" type="number" class="project-form-input" min="0" value="0"/>
      <div class="project-form-input-addon project-form-input-addon-right">
          원
      </div>
    </div>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">티켓 매수</p>
    <div class="project-form-ticket-price-container-grid">
      <input id="ticket_count" name="ticket_count" type="number" class="project-form-input" min="0" value="0"/>
      <div class="project-form-input-addon project-form-input-addon-right">
          매
      </div>
    </div>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">티켓 종류</p>
    <div class="project-form-ticket-category-container-grid">
      <select id="ticket_category" name="ticket_category" class="form-control">
        @foreach ($categories_ticket as $category_ticket)
            @if ($category_ticket->id === $project->category_ticket_id)
                <option value="{{ $category_ticket->id }}" selected>{{ $category_ticket->title }}</option>
            @else
                <option value="{{ $category_ticket->id }}">{{ $category_ticket->title }}</option>
            @endif
        @endforeach
      </select>
      <input id="ticket_category_etc_input" type="text" style="width: 100%;"/>
    </div>
  </div>

  <button id="cancel_modify_ticket" class="btn btn-default">취소하기</button>
  <button id="update_ticket" class="btn btn-success">수정하기</button>
  <button id="create_ticket" class="btn btn-success">추가하기</button>
</div>
