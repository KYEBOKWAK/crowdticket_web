<div class="row order-header" style="margin-left:0px; margin-right:0px;">
    <div class="col-md-12">
        <h2 class="text-center">{{ $project->title }}</h2>
    </div>
    @if ($step > 0)
        <div class="col-md-10 col-md-offset-1" style="display:none;">
          @if ($step === 1)
          <div class="col-md-4">
              <img src="{{ asset('img/app/ico_step_progress01.png') }}" class="center-block"/>
              <h3 class="text-center @if ($step === 1) text-primary @endif text-important">
                <strong>STEP 1</strong><br/>티켓 및 md선택</h3>
          </div>
          @elseif($step === 2)
          <div class="col-md-4">
              <img src="{{ asset('img/app/ico_step_progress02.png') }}" class="center-block"/>
              <h3 class="text-center @if ($step === 2) text-primary @endif text-important"><strong>STEP 2</strong>
                  <br/>
                  @if( $project->project_target == "people" )
                    정보입력 및 예약
                  @else
                    정보입력 및 결제
                  @endif
                </h3>
          </div>
          @elseif($step === 3)
          <div class="col-md-4">
              <img src="{{ asset('img/app/ico_step_progress03.png') }}" class="center-block"/>
              <h3 class="text-center @if ($step === 3) text-primary @endif text-important"><strong>STEP 3</strong>
                  <br/>
                  확 인</h3>
          </div>
          @endif
        </div>
    @endif
</div>
