@extends('app')

@section('css')
    <style>
        .ps-section-title {
            font-weight: bold;
            font-size: 19px;
            margin-top: 30px;
        }

        .ps-section-title span {
            font-size: 14px;
            color: #777;
            margin-left: 2em;
        }

        .ps-section-title:first-child {
            margin-top: 0px;
        }

        .ps-box {
            background-color: #FFFFFF;
            border: 1px #DAD8CC solid;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            padding: 25px 0px 25px 0px;
        }

        .ps-form-control-like {
            padding: 6px 12px 6px 0px;
            font-size: 13px;
            margin-bottom: 0px;
        }

        #order-account-name {
            width: 16.667%;
        }

        form .btn-success,
        form .btn-danger,
        form .btn-muted {
            margin-top: 50px;
        }

        label.commission-label {
            text-align: left !important;
        }

        .total-price input,
        .total-price .input-group-addon {
            border: 1px solid #CC0000;
            font-weight: bold;
        }

        .total-price .input-group-addon {
            border-left: 0
        }

        .prevent-autocomplete {
            width: 1px;
            height: 1px;
            float: right;
            border: none;
        }

        .ps-tooltip {
            margin-top: 1em;
        }
    </style>
@endsection

@section('content')
    <div class="container first-container">
        @include ('order.header', ['project' => $project, 'step' => $order ? 0 : 2])

        <form class="row form-horizontal" data-toggle="validator" role="form"
              action="{{ $form_url }}/" method="post">
            @include('form_method_spoofing', ['method' => $order ? 'delete' : 'post'])

            @if ($project->type === 'funding')
                <h4 class="col-md-12 ps-section-title">선택한 보상</h4>
            @else
                <h4 class="col-md-12 ps-section-title">선택한 티켓</h4>
            @endif
            <div class="ticket order col-md-12">
                <div class="ticket-wrapper">
                    <div class="ticket-body row display-table">
                        @if ($project->type === 'funding')
                            <div class="col-md-3 display-cell text-right">
                                <span>
                                    <strong class="text-primary ticket-price">{{ $ticket->price }}</strong> 원 이상
                                </span>
                            </div>
                            <div class="col-md-9 display-cell">
                                <p class="ticket-reward">{{ $ticket->reward }}</p>
                                @if ($ticket->real_ticket_count > 0)
                                    <span class="ticket-real-count">
                                        <img src="{{ asset('/img/app/ico_ticket2.png') }}"/>
                                        {{ $ticket->real_ticket_count }}매
                                    </span>
                                @endif
                                <span class="ticket-delivery-date">예상 실행일 : {{ date('Y년 m월 d일', strtotime($ticket->delivery_date)) }}</span>
                            </div>
                        @else
                            <div class="col-md-3 display-cell">
                                <span>
                                    <span class="text-primary">공연일시</span><br/>
                                    <strong class="ps-strong-small">{{ date('Y.m.d H:i', strtotime($ticket->delivery_date)) }}</strong>
                                    <span class="pull-right">{{ $ticket->price }} 원</span>
                                </span>
                            </div>
                            <div class="col-md-9 display-cell">
                                <p class="ticket-reward ps-no-margin">{{ $ticket->reward }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($request_price > 0)
                <h4 class="col-md-12 ps-section-title">결제금액</h4>
                <div class="col-md-12">
                    <?php
                    $orderPrice = $request_price * $ticket_count;
                    $commission = $ticket->real_ticket_count * $ticket_count * 500;
                    $totalPrice = $orderPrice + $commission;
                    ?>
                    <div class="ps-box">
                        <div class="form-group">
                            <label for="order-price" class="col-sm-2 control-label">상품금액</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="hidden" name="ticket_count" value="{{ $ticket_count }}"/>
                                    <input type="hidden" name="request_price" value="{{ $request_price }}"/>
                                    <input id="order-price" type="text" readonly="readonly"
                                           class="form-control text-right" value="{{ $orderPrice }}"/>
                                    <div class="input-group-addon">
                                        원
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">티켓 수수료</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" readonly="readonly" class="form-control text-right"
                                           value="{{ $commission }}"/>
                                    <div class="input-group-addon">
                                        원
                                    </div>
                                </div>
                                <p class="help-block text-right">
                                    1매 500원 X {{ $ticket->real_ticket_count * $ticket_count }}매
                                    = {{ $commission }}원
                                </p>
                            </div>
                            <div class="col-sm-4">
                                *티켓 발급 및 알림, 플랫폼 유지를 위해<br/>필요한 최소한의 수수료만을 받고 있습니다.
                            </div>
                        </div>
                        <div class="form-group total-price">
                            <label class="col-sm-2 control-label">결제금액</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" readonly="readonly" class="form-control text-right"
                                           value="{{ $totalPrice }}"/>
                                    <div class="input-group-addon">
                                        원
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group answer" @if( !$ticket->require_question) style="display:none;" @endif> -->
                        <div class="form-group answer">
                            <label class="col-sm-2 control-label">추가질문</label>
                            <label class="col-sm-9">{{ $ticket->question }}</label>
                            <div class="col-sm-offset-2 col-sm-9">
                                <textarea id="order-answer" name="answer" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($project->type === 'funding')
                    <h4 class="col-md-12 ps-section-title">결제 예약 정보</h4>
                @else
                    <h4 class="col-md-12 ps-section-title">결제 정보</h4>
                @endif
                <div class="col-md-12">
                    <div class="ps-box">
                        @if (!$order)
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-8">
                                    <p class="ps-form-control-like">
                                        @if ($project->type === 'funding')
                                            <strong>※ "결제예약" 에 관하여</strong><br/><br/>
                                            펀딩에 성공했을 경우, <strong>완료 익일 오후 1시</strong>에 후원금이 일괄적으로 결제됩니다.<br/>
                                            (갑자기 결제완료가 됐다는 카드사의 문자를 받아도 놀라지 마세요 ^^) <br/><br/>
                                            카드분실, 잔액부족으로 인하여 예약된 결제가 제대로 처리되지 않을 수 있습니다.<br/>
                                            펀딩이 실패하면 결제 되지 않습니다.<br/>
                                        @else
                                            <strong>※ 알려드립니다.</strong><br/><br/>
                                            크라우드티켓에서는 이용자의 편의를 위하여 비인증 결제방식을 제공하고 있습니다.<br/>
                                            공인인증서 없이 아래 정보만 입력하면 바로 결제가 가능합니다. (카드결제만을 지원하고 있습니다.)<br/><br/>
                                            여러분이 입력하는 정보는 철저히 암호화되며, 안전하게 보호됩니다. 안심하시고 사용하세요!<br/>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="order-name" class="col-sm-2 control-label">성명</label>
                            <div class="col-sm-2">
                                @if ($order)
                                    <input id="order-name" name="name" type="text"
                                           class="form-control" value="{{ $order->name }}"
                                           readonly="readonly"/>
                                @else
                                    <input id="order-name" name="name" type="text"
                                           class="form-control" value="{{ \Auth::user()->name }}"
                                           required="required"/>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="order-contact" class="col-sm-2 control-label">휴대폰번호</label>
                            <div class="col-sm-2">
                                @if ($order)
                                    <input id="order-contact" name="contact" maxlength="11" type="text"
                                           class="form-control" value="{{ $order->contact }}"
                                           readonly="readonly"/>
                                @else
                                    <input id="order-contact" name="contact" maxlength="11" type="text"
                                           class="form-control" value="{{ \Auth::user()->contact }}"
                                           required="required" placeholder="-없이 숫자만 입력"/>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="order-email" class="col-sm-2 control-label">이메일</label>
                            <div class="col-sm-4">
                                @if ($order)
                                    <input id="order-email" name="email" type="email" class="form-control"
                                           value="{{ $order->email }}" readonly="readonly"/>
                                @else
                                    <input id="order-email" name="email" type="email" class="form-control"
                                           value="{{ \Auth::user()->email }}" required="required"/>
                                @endif
                            </div>
                        </div>
                        @if (!$order)
                            <div class="form-group">
                                <label for="order-card-number" class="col-sm-2 control-label">카드번호</label>
                                <div class="col-sm-4">
                                    <input id="order-card-number" name="card_number" type="text"
                                           class="form-control" autocomplete="off" required="required"
                                           maxlength="16" placeholder="-없이 숫자만 입력"/>
                                </div>
                                <div class="col-sm-4">
                                    *체크카드, 신용카드 모두 가능합니다.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="order-expiry" class="col-sm-2 control-label">유효기간</label>
                                <div class="col-sm-2">
                                    <select name="expiry_month" class="form-control" required="required">
                                        <option selected disabled>mm</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select name="expiry_year" class="form-control" required="required">
                                        <option selected disabled>yyyy</option>
                                        @for ($i = 2016; $i <= 2026; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="order-birth" class="col-sm-2 control-label">생년월일</label>
                                <div class="col-sm-2">
                                    <input id="order-birth" name="birth" type="text"
                                           class="form-control" autocomplete="off" required="required"
                                           maxlength="6" placeholder="주민번호 앞6자리"/>
                                </div>
                            </div>
                            <input class="prevent-autocomplete" type="text"/>
                            <div class="form-group">
                                <label for="order-card-password" class="col-sm-2 control-label">
                                    카드비밀번호
                                </label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input id="order-card-password" name="card_password" type="password"
                                               class="form-control" autocomplete="off" required="required"
                                               maxlength="2"/>
                                        <span class="input-group-addon">**</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <input type="hidden" name="ticket_count" value="{{ $ticket_count }}"/>
                <input id="order-price" name="request_price" type="hidden" readonly="readonly"
                       class="form-control" value="{{ $request_price }}"/>
                <div class="col-md-12">
                    <div class="ps-box">
                        <div class="form-group">
                            <label for="order-name" class="col-sm-2 control-label">성명</label>
                            <div class="col-sm-2">
                                @if ($order)
                                    <input id="order-name" name="name" type="text"
                                           class="form-control" value="{{ $order->name }}"
                                           readonly="readonly"/>
                                @else
                                    <input id="order-name" name="name" type="text"
                                           class="form-control" value="{{ \Auth::user()->name }}"
                                           required="required"/>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="order-contact" class="col-sm-2 control-label">휴대폰번호</label>
                            <div class="col-sm-2">
                                @if ($order)
                                    <input id="order-contact" name="contact" maxlength="11" type="text"
                                           class="form-control" value="{{ $order->contact }}"
                                           readonly="readonly"/>
                                @else
                                    <input id="order-contact" name="contact" maxlength="11" type="text"
                                           class="form-control" value="{{ \Auth::user()->contact }}"
                                           required="required" placeholder="-없이 숫자만 입력"/>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="order-email" class="col-sm-2 control-label">이메일</label>
                            <div class="col-sm-4">
                                @if ($order)
                                    <input id="order-email" name="email" type="email" class="form-control"
                                           value="{{ $order->email }}" readonly="readonly"/>
                                @else
                                    <input id="order-email" name="email" type="email" class="form-control"
                                           value="{{ \Auth::user()->email }}" required="required"/>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($ticket->require_shipping)
                <h4 class="col-md-12 ps-section-title">수령정보</h4>
                <div class="col-md-12">
                    <div class="ps-box">
                        <div class="form-group">
                            <label for="order-address" class="col-sm-2 control-label">주소</label>
                            <div class="col-sm-2">
                                @if ($order)
                                    <input id="order-address" name="postcode" type="text"
                                           class="form-control postcodify_postcode5" readonly="readonly"
                                           placeholder="우편번호" value="{{ $order->postcode }}"/>
                                @else
                                    <input id="order-address" name="postcode" type="text"
                                           class="form-control postcodify_postcode5" required="required"
                                           readonly="readonly" placeholder="우편번호"/>
                                @endif
                            </div>
                            <div class="col-sm-2">
                                @if (!$order)
                                    <a href="#" id="postcodify_search_button" style="display: none;">검색</a>
                                    <a href="#" class="btn btn-default" id="postcodify_search_button_fake">검색</a>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-2">
                                @if ($order)
                                    <input type="text" name="address_main"
                                           class="form-control postcodify_address" readonly="readonly"
                                           value="{{ $order->address_main }}"/>
                                @else
                                    <input type="text" name="address_main"
                                           class="form-control postcodify_address" required="required"
                                           readonly="readonly" placeholder="주소를 검색해주세요"/>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-2">
                                @if ($order)
                                    <input type="text" name="address_detail"
                                           class="form-control postcodify_details" readonly="readonly"
                                           value="{{ $order->address_detail }}"/>
                                @else
                                    <input type="text" name="address_detail"
                                           class="form-control postcodify_details" required="required"
                                           placeholder="상세주소를 입력해주세요"/>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="order-comment" class="col-sm-2 control-label">비고</label>
                            <div class="col-sm-8">
                                @if ($order)
                                    <input id="order-comment" name="requirement" type="text"
                                           class="form-control" readonly="readonly"
                                           value="{{ $order->requirement }}"/>
                                @else
                                    <input id="order-comment" name="requirement" type="text"
                                           class="form-control" placeholder="보상품 세부사항 및 기타 요청 사항"/>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <p class="ps-form-control-like text-danger">
                                    입력하신 개인 정보는 결제 확인 알림 및 현재 참여하고 있는 공연 정보 발송 외의 용도로는 절대 사용하지 않으니 걱정하지 마세요!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (!$order)
                <h4 class="col-md-12 ps-section-title">약관 동의</h4>
                <div class="col-md-12">
                    <div class="ps-box">
                        <div class="form-group">
                            <label class="col-sm-10 col-sm-offset-1">크라우드티켓 이용약관</label>
                            <div class="col-sm-10 col-sm-offset-1">
                                <p class="scroll-box">@include ('helper.terms_content')</p>
                                <div class="checkbox pull-right">
                                    <label>
                                        <input type="checkbox" name="approval1" required="required"/>동의합니다
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-10 col-sm-offset-1">배송 및 결제 관련 제3자 정보제공 동의</label>
                            <div class="col-sm-10 col-sm-offset-1">
                                <p class="scroll-box">@include ('helper.privacy_content')</p>
                                <div class="checkbox pull-right">
                                    <label>
                                        <input type="checkbox" name="approval2" required="required"/>동의합니다
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-10 col-sm-offset-1">
                                @if ($project->type === 'funding')
                                    펀딩 결제예약 환불규정
                                @else
                                    티켓 환불규정
                                @endif
                            </label>
                            <div class="col-sm-10 col-sm-offset-1">
                                <p class="scroll-box">@include ('helper.refund_terms_content', ['type' => $project->type])</p>
                                <div class="checkbox pull-right">
                                    <label>
                                        <input type="checkbox" name="approval3" required="required"/>동의합니다
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-12 text-center">
                @if ($order)
                    @if ($order->deleted_at)
                        @if ($project->type === 'funding')
                            <button class="btn btn-muted">취소됨</button>
                        @else
                            <button class="btn btn-muted">환불됨</button>
                        @endif
                    @else
                        @if ($order->canCancel())
                            @if ($project->type === 'funding')
                                <button class="btn btn-danger">취소하기</button>
                            @else
                                <button class="btn btn-danger">환불하기</button>
                                @if ($order->hasCancellationFees())
                                    <p class="ps-tooltip text-danger">
                                        환불 정책에 따라 취소 수수료 {{ $order->getCancellationFees() }}원이 차감된 {{ $order->getRefundAmount() }}원이 환불됩니다.<br/>
                                        환불은 2~3일 정도 소요될 수 있습니다.
                                    </p>
                                @endif
                            @endif
                        @else
                            @if ($project->type === 'funding')
                                <button class="btn btn-muted">취소불가</button>
                                <p class="ps-tooltip text-danger">취소 가능 일자가 만료되었습니다.</p>
                            @else
                                <button class="btn btn-muted">환불불가</button>
                                <p class="ps-tooltip text-danger">환불 가능 일자가 만료되었습니다.</p>
                            @endif
                        @endif
                    @endif
                @else
                    <button class="btn btn-success">결제하기</button>
                @endif
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="//d1p7wdleee1q2z.cloudfront.net/post/search.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#postcodify_search_button").postcodifyPopUp();
            $('#postcodify_search_button_fake').bind('click', function () {
                $('#postcodify_search_button').trigger('click');
                return false;
            });
            $('.btn-muted').each(function () {
                $(this).bind('click', function () {
                    return false;
                });
            });
            $('.btn-danger').each(function () {
                $(this).bind('click', function () {
                    var form = $(this).closest('form');
                    return confirm('정말 취소하시겠습니까?');
                });
            });

            $('form').preventDoubleSubmission();
            $('form').validate({
                rules: {
                    "contact": {
                        minlength: 10,
                        digits: true
                    }
                },
                messages: {
                    "contact": {
                        minlength: "올바른 휴대폰 번호를 입력해주세요",
                        digits: "-를 제외한 숫자만 입력해주세요",
                        required: "휴대폰 번호를 입력해주세요"
                    }
                }
            });
        });
    </script>
@endsection
