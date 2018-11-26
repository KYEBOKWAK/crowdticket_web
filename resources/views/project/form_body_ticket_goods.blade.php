<input type="hidden" id="goods_json" value="{{ $project->goods }}"/>
<input type="hidden" id="goods">

<div class="form-body-default-container">
  <div class="project_form_content_container project_form_content_container_ticket_resize">

    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">MD 정보 없음</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <input id="goods_checkbox" class="project_form_checkbox" type="checkbox"/>
          </div>
        </div>
      </div>
    </div>

    <div class="project_form_input_container">
      <div class="flex_layer_project">

          <div id="goods_list" style="margin-left: auto; margin-right: auto;"></div>

      </div>
    </div>

  <form id="goods_form" action="{{ url('projects/goods') }}/{{ $project->id }}" method="post" role="form">
    <!-- 상품명 -->
    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">상품명</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <input id="goods_title_input" name="title" type="text" class="project_form_input_base goods_title_input_wrapper"/>
          </div>
        </div>
      </div>
    </div>

    <!-- 가격 -->
    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">가격</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <input id="goods_price_input" name="price" type="number" class="project_form_input_base project_form_discount_value_wrapper" min="0" value="0"/>
            <p style="margin-bottom: 0px; font-size: 21px; font-weight: bold; margin-left: 5px; margin-top: 3px;">원</p>
          </div>
        </div>
      </div>
    </div>

    <!-- 상품 설명 -->
    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">상품 설명</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <input id="goods_content_input" name="content" type="text" class="project_form_input_base"/>
          </div>
        </div>
      </div>
    </div>

    <!-- 이미지 추가 -->
    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">이미지 추가</p>
        <div class="project-form-content">
            <a href="javascript:void(0);" id="goods_file_fake"><img style="margin-left: -5px;" src="https://img.icons8.com/windows/40/EF4D5D/plus-2-math.png"></a>
            <a href="javascript:void(0);" id="goods_file_sub" style="display: none;"><img style="margin-left: -5px;" src="https://img.icons8.com/windows/40/EF4D5D/minus-2-math.png"></a>
            <p>이미지 권장 사이즈는 500px X 300px 입니다.</p>
            <div id="goods_img_preview" style="display:none;">
            </div>
              <input id="goods_img_file" type="file" name="goods_img_file" style="height: 0; visibility: hidden"/>
        </div>
      </div>
    </div>

    <!-- 추가 할인 여부 -->
    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">추가 할인 여부</p>
        <div class="project-form-content">
          <div class="flex_layer">
            <p class="ticket_discount_explain">이 상품을 구매하면 티켓에서 추가로</p>
              <input id="ticket_discount_input" name="ticket_discount" type="number" class="project_form_input_base ticket_discount_input"/>
            <p class="ticket_discount_explain">원을 할인해줍니다.</p>

            <!-- 티켓 버튼들 -->
            <div class="project_form_ticket_button_wrapper goods_button_resize">
              <div class="flex_layer">
                <button id="cancel_modify_goods" type="button" class="btn btn-default ticket_button_resize">취소하기</button>
                <button id="update_goods" type="button" class="btn btn-success ticket_button_resize">수정하기</button>
                <button id="create_goods" type="button" class="btn btn-success ticket_button_resize">추가하기</button>
                <input type="hidden" id="goodsId" name="goodsId" value=""/>
                <input type="hidden" id="updatebutton" name="updatebutton" value=""/>

                @include('form_method_spoofing', ['method' => 'put'])
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="project_form_button_wrapper project_form_button_wrapper_ticket_resize">
      <div class="flex_layer">
        <button id="update_and_next" type="button" class="btn btn-success center-block project_form_button pointBackgroundColor">다음</button>
      </div>
    </div>
  </form>

  </div>
</div>
<!--
<div class="form-body-default-container">
  <div class="project-form-content-grid">
    <p class="project-form-content-title">MD 정보 없음</p>
    <input type="checkbox"/>
  </div>

  <div class="project-form-content-grid">
    <p class="project-form-content-title">등록된 MD 정보</p>

    <div id="goods_list"></div>
  </div>

  <form id="goods_form" action="{{ url('projects/goods') }}/{{ $project->id }}" method="post" role="form">
    <div class="project-form-content-grid">
      <p class="project-form-content-title">상품명</p>
      <input id="goods_title_input" name="title" type="text"/>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">상품 이미지</p>
      <div class="project-form-goods-img-preview-container">
        <div id="goods_img_preview" style="background-image: url('{{ $project->getDefaultImgUrl() }}');"
             class="bg-base">
            <div class="middle">
                <a href="#" id="goods_file_fake" class="btn btn-primary">찾아보기</a>
            </div>
        </div>
        <input id="goods_img_file" type="file" name="goods_img_file" style="height: 0; visibility: hidden"/>
      </div>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">가격</p>
      <input id="goods_price_input" name="price" type="number"/>
    </div>

    <div class="project-form-content-grid">
      <p class="project-form-content-title">설명</p>
        <input id="goods_content_input" name="content" type="text"/>
    </div>
    @include('form_method_spoofing', ['method' => 'put'])
    <input id="cancel_modify_goods" type="button" class="btn btn-success" name="cancelbutton" value="취소하기"/>
    <input id="update_goods" type="submit" class="btn btn-success" name="updatebutton" value="수정하기"/>
    <input id="create_goods" type="submit" class="btn btn-success" name="createbutton" value="추가하기"/>
    <input type="hidden" id="goodsId" name="goodsId" value=""/>
  </form>
</div>
-->
