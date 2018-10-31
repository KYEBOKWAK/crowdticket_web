<input type="hidden" id="tickets_json" value="{{ $project->tickets }}"/>
<input type="hidden" id="ticket_old_selected_day_json" value="{{ $selectedTicket }}"/>
<input type="hidden" id="ticket_select_price" value=""/>
<input type="hidden" id="tickets_json_category_info" value="{{$categories_ticket}}"/>
<input type="hidden" id="isDetail" value="{{ $isDetail }}"/>
<input type="hidden" id="tickets_buy_count_info" value="{{ $ticketsCountInfoJson }}"/>
<input type="hidden" id="ticket_notice" value="{{ $project->ticket_notice }}"/>
<div class="app-container" ng-app="dateTimeApp" ng-controller="dateTimeCtrl as ctrl" ng-cloak>
	<div date-picker
		 datepicker-title="날짜 선택"
		 picktime="true"
		 pickdate="true"
		 pickpast="false"
		 mondayfirst="false"
		 custom-message=""
		 selecteddate="ctrl.selected_date"
		 updatefn="ctrl.updateDate(newdate)">

		<div class="datepicker"
			 ng-class="{
				'am': timeframe == 'am',
				'pm': timeframe == 'pm',
				'compact': compact
			}">
			<div class="datepicker-header">
				<div class="datepicker-title" ng-if="datepicker_title">날짜 선택 @if($isDetail == "FALSE")<span style="font-size:11px;"> | 티켓팅 가능날짜: {{ $project->getConcertDateFormatted() }} </span> @endif</div>
			</div>
			<div class="datepicker_calendar_container @if($isDetail == 'FALSE') flex_layer_mobile @endif">
				<div class="datepicker-calendar @if($isDetail == 'FALSE') detail_calendar_flex @endif">
					<div class="calendar-header">
						<div id="goback" class="goback" ng-click="moveBack()" ng-if="pickdate" data-ticket-year="@{{ currentViewDate.getFullYear() }}" data-ticket-month="@{{ day.month }}">
							<svg width="30" height="30">
								<path fill="none" stroke="#EF4D5D" stroke-width="3" d="M19,6 l-9,9 l9,9"/>
							</svg>
						</div>
						<div class="current-month-container">@{{ currentViewDate.getFullYear() }} @{{ currentMonthName() }}</div>
						<!-- <div class="current-month-container">@{{ currentViewDate.getFullYear() }} @{{ currentMonthName() }}</div> -->
						<div id="goforward" class="goforward" ng-click="moveForward()" ng-if="pickdate" data-ticket-year="@{{ currentViewDate.getFullYear() }}" data-ticket-month="@{{ day.month }}">
							<svg width="30" height="30">
								<path fill="none" stroke="#EF4D5D" stroke-width="3" d="M11,6 l9,9 l-9,9" />
							</svg>
						</div>
					</div>
					<div class="calendar-day-header">
						<span ng-repeat="day in days" class="day-label">@{{ day.short }}</span>
					</div>
					<div class="calendar-grid" ng-class="{false: 'no-hover'}[pickdate]">
						<div
							ng-class="{'no-hover': !day.showday}"
							ng-repeat="day in month"
							class="datecontainer"
							ng-style="{'margin-left': calcOffset(day, $index)}"
							track by $index>
							 <div id="dateSelect@{{ day.daydate }}" class="datenumber" data-ticket-year="@{{ currentViewDate.getFullYear() }}" data-ticket-month="@{{ day.month }}" data-ticket-day="@{{ day.daydate }}" ng-class="{'day-selected': day.selected }" ng-click="selectDate(day)">
	               <input type="hidden" id="tickets_year" value="@{{ currentViewDate.getFullYear() }}">
	               <input type="hidden" id="tickets_month" value="@{{ day.month }}">
								@{{ day.daydate }}
							 </div>
						</div>
					</div>
				</div>

				<div class="calendar_contant_wrapper"style="width: 100%">
					@if($project->ticket_notice)
						<div id="ticket_notice_container">
						</div>
					@endif
					@if($isDetail == 'FALSE')
					<div id="ticket_place_holder"><h4>날짜와 티켓을 선택해주세요.</h4></div>
					@endif
					<div id="timepicker-container-outer-container">
						<div class="timepicker-container-outer-container-flex">
							<div class="flex_layer" style="width:100%;">
								<div class="timepicker-time-container-inner @if($isDetail == 'FALSE') timepicker-time-container-inner-order @endif">
									<div id="timeTicketsList"></div>
								</div>
								<div class="timepicker-seat-container-inner @if($isDetail == 'FALSE') timepicker-seat-container-inner-order @endif">
									<div id="seatTicketsList"></div>
								</div>
							</div>
						</div>

						@if($isDetail == 'FALSE')
						<div id="ticket_count_input_wrapper" class="ticket_count_input_wrapper flex_layer">
							<span class="order_input_text">티켓 매수</span>
							<input id="ticket_count_input" ticket-data-id="" ticket-data-price="" ticket-buy-limit="" ticket-data-amount="" name="ticket_count" type="number" class="form-control ticket_count"
																														 value="1" min="0"/>
																														 <span class="order_input_text">매</span>
						</div>
						@endif
					</div>
				</div> <!-- calendar_contant_wrapper -->
			</div>
		</div>
	</div>
	<input id="ticket_select_id_input" name="ticket_select_id" type="hidden" value=''/>
	<!--<input id="ticket_amount_count_input" type="hidden" value=''/>-->
	<input id="request_price" name="request_price" type="hidden"  value=''/>
	@if($isDetail == 'TRUE')
		<button type="button" id="ticketing-btn-calendar" class="btn btn-primary btn-block ticketing-btn-calendar">선택하기</button>
	@endif
</div>
