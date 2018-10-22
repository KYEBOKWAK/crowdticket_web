<input type="hidden" id="goods_json" value="{{ $project->goods }}"/>
<input type="hidden" id="goods">
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
    <!--<button id="cancel_modify_goods" type="reset" class="btn btn-default">취소하기</button>-->
    <!--<button id="create_goods" class="btn btn-success" type="submit" name="creategoods">추가하기</button>-->
  </form>
</div>
