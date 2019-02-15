@extends('app')

@section('css')
    <style>
        .ps-box {
            background-color: white;
            border: 1px #dad8cc solid;
            border-radius: 5px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .ps-text-detail {
            margin-top: 5em;
        }
        .ps-text-detail strong {
            font-size: 1.2em;
        }

        .ps-detail-comment-wrapper {
            padding-bottom: 0px;
        }

        .ps-detail-comment-wrapper button {
            margin-top: 10px;
        }

        .btn-facebook-Shar{
          color: white;
          background-color: #3a5795;
          margin-left:15px;
        }

        .btn-facebook-Shar span:hover{
          color: #eee;
        }

        .commentTitle{
          font-size: 25px;
          padding-bottom: 11px;
        }
    </style>
@endsection

@section('content')
    <div class="container first-container">
        <div class="row ps-box">
            <div class="col-md-12">
                <h2 class="text-center"><strong>결제 실패</strong></h2>
                    <h3 class="text-center">
                      <strong>
                        수량이 초과 되었습니다.
                      </strong>
                    </h3>
                    <p class="text-center ps-text-detail">
                        <strong>
                            ㅠ.ㅠ 안타깝게 티켓팅에 실패하셨네요...
                        </strong>
                    </p>
            </div>
        </div>

        <div class="row ps-box">
          <p class="text-left commentTitle">
            <strong>
                아쉽지만 ㅠ 한마디..
            </strong>
          </p>
            <form id="overcounter_addcomment" action="{{ url('/overcount') }}/{{ $project->id }}/comments" method="post"
                  data-toggle="validator" role="form" class="ps-detail-comment-wrapper">
                <textarea id="input_comment" name="contents" class="form-control" rows="3"
                          placeholder="프로젝트 진행자에게 궁금한 사항, 혹은 응원의 한마디를 남겨주세요!" required></textarea>
                <button id="overcounter_addcomment_button" type="button" class="btn btn-success pull-right">등록하기</button>
                <div class="clear"></div>
                @include('csrf_field')
            </form>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{ url() }}" class="btn btn-success ">더 둘러보기</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {

  var overCountAddCommentAjaxOption = {
		'beforeSerialize': function($form, options) {


		},
		'success': function(result) {
			//alert(result);
      swal("등록 성공!", "프로젝트 응원&후기 에서 확인 할 수 있습니다.", "success");
		},
		'error': function(data) {
			alert("저장에 실패하였습니다.");
		}
	};

  $("#overcounter_addcomment").ajaxForm(overCountAddCommentAjaxOption);

  $("#overcounter_addcomment_button").click(function(){
    $("#overcounter_addcomment").submit();
  });
});
</script>

@endsection
