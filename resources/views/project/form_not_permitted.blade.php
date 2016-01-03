@extends('app')

@section('css')
<style>
	.first-container h1 {
		text-align: center;
	    margin-top: 150px;
	    font-size: 25px;
	    font-weight: bold;
	    color: #666;
	    line-height: 1.5em;
	}
</style>
@endsection

@section('content')
<div class="first-container">
	<h1>
		제출하신 프로젝트를 검토하고 있습니다 <br/>
		빠른 시일 내에  {{ \Auth::user()->email }} 로 답변 드리겠습니다.
	</h1>
</div>
@endsection
