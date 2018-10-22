<input type="hidden" id="discounts_json" value="{{ $project->discounts }}"/>
<div class="form-body-default-container">
  <div class="project-form-content-grid">
    <p class="project-form-content-title">할인 정보 없음</p>
    <input type="checkbox"/>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">등록된 할인 정보</p>
    <div id="discount_list"></div>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">할인 조건</p>
    <input id="discount_content_input" type="text"/>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">할인률</p>
    <input id="discount_percent_value_input" type="number"/>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">할인 제한 매수</p>
    <div>
      <input id="discount_limite_input" type="number"/>
      <p>제한 없을시 0매 입력</p>
    </div>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">할인 조건 확인 절차</p>
    <input id="discount_submit_input" type="text"/>
  </div>

  <button id="cancel_modify_discount" class="btn btn-default">취소하기</button>
  <button id="update_discount" class="btn btn-success">수정하기</button>
  <button id="create_discount" class="btn btn-success">추가하기</button>
</div>
