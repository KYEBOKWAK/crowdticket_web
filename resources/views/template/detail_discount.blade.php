@if($project->alias === 'bjawards2019')
<h5>청소년 할인가 8000원</h5>
@else
<h5>{{ $discount->content }} {{ $discount->percent_value }}% 할인</h5>
@endif
<h5 style="font-weight:400; color:#656969;">{{ $discount->submit_check }}</h5>

<!-- <h5>중고등학생 2000원 할인</h5>
<h5 style="font-weight:400; color:#656969;">현장에서 학생증을 제시하셔야 합니다.확인이 안 될 시 차액을 지급해야 합니다.</h5> -->
