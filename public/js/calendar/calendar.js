var ticketsJson = $('#tickets_json').val();
var tickets = '';
if (ticketsJson) {
   tickets = $.parseJSON(ticketsJson);
}

var ticketSelectDayJson = $('#ticket_old_selected_day_json').val();
var ticketSelectDay = '';
if(ticketSelectDayJson){
  ticketSelectDay = $.parseJSON(ticketSelectDayJson);
}

var isPlace = $('#isPlace').val();
if(isPlace == "FALSE")
{
  //장소 미정일 경우에는 좌석 종류만 나온다.
  //좌석 미정인데, 티켓 정보가 있다면 시간에 상관없이 모든 티켓이 다 나와야 한다
  //if(tickets)
  //{
  //  alert(tickets)
  //}
}

var app = angular.module('dateTimeApp', []);

app.controller('dateTimeCtrl', function ($scope) {
	var ctrl = this;

	ctrl.selected_date = new Date();
	ctrl.selected_date.setHours(10);
	ctrl.selected_date.setMinutes(0);

	ctrl.updateDate = function (newdate) {

		// Do something with the returned date here.

		console.log(newdate);
	};
});

// Date Picker
app.directive('datePicker', function ($timeout, $window) {
    return {
        restrict: 'AE',
        scope: {
            selecteddate: "=",
            updatefn: "&",
            open: "=",
            datepickerTitle: "@",
            customMessage: "@",
            picktime: "@",
            pickdate: "@",
            pickpast: '=',
			mondayfirst: '@'
        },
		transclude: true,
        link: function (scope, element, attrs, ctrl, transclude) {
			transclude(scope, function(clone, scope) {
				element.append(clone);
			});

            if (!scope.selecteddate) {
                scope.selecteddate = new Date();
            }

            if (attrs.datepickerTitle) {
                scope.datepicker_title = attrs.datepickerTitle;
            }

            scope.days = [
                { "long":"일요일","short":"일" },
                { "long":"월요일","short":"월" },
                { "long":"화요일","short":"화" },
                { "long":"수요일","short":"수" },
                { "long":"목요일","short":"목" },
                { "long":"금요일","short":"금" },
                { "long":"토요일","short":"토" },
            ];
			if (scope.mondayfirst == 'true') {
				var sunday = scope.days[0];
				scope.days.shift();
				scope.days.push(sunday);
			}

            scope.monthNames = [
                "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"
            ];

            function getSelected() {
              if (scope.currentViewDate.getMonth() == scope.localdate.getMonth()) {
                  if (scope.currentViewDate.getFullYear() == scope.localdate.getFullYear()) {
                    for (var number in scope.month) {
                        if (scope.month[number].daydate == scope.localdate.getDate()) {
                            scope.month[number].selected = true;
          								if (scope.mondayfirst == 'true') {
          									if (parseInt(number) === 0) {
          										number = 6;
          									} else {
          										number = number - 1;
          									}
          								}
        								scope.selectedDay = scope.days[scope.month[number].dayname].long;
        							}
                    }
                  }
              }
            }

            function getDaysInMonth(isInit) {
              if(tickets.length > 0)
              {
                //티켓이 한장 이상 있다는거

                var month = scope.currentViewDate.getMonth();
                if(isInit == "TRUE")
                {
                  //var ticketFirstDate = new Date(tickets[0].show_date);
                  //month = ticketFirstDate.getMonth();
                }

                var date = new Date(scope.currentViewDate.getFullYear(), month, 1);
                var days = [];
                var today = new Date();

                while (date.getMonth() === month) {
                  var day = new Date(date);
                  var dayname = day.getDay();
                  var daydate = day.getDate();

                  var showday = false;

                  for (var i = 0, l = tickets.length; i < l; i++) {
                    var rawDate = tickets[i].show_date.split(" ");
                    var d = rawDate[0].split("-");
                    var t = rawDate[1].split(":");

                    var ticketDate = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);

                    if (ticketDate.getDate() == date.getDate() &&
                        ticketDate.getYear() == date.getYear() &&
                        ticketDate.getMonth() == date.getMonth()) {
                        showday = true;
                        break;
                    }
                  }

                  days.push({ 'dayname': dayname, 'daydate': daydate, 'showday': showday, 'month': month+1 });
                  date.setDate(date.getDate() + 1);
                }

                  scope.month = days;
              }
              else
              {
                //티켓 정보가 없을땐 오늘 기준으로 달력이 나온다.(우선)
                var month = scope.currentViewDate.getMonth();
                var date = new Date(scope.currentViewDate.getFullYear(), month, 1);
                var days = [];
                var today = new Date();

                while (date.getMonth() === month) {
                  var showday = true;
                  if (!scope.pickpast && date < today) {
                      showday = false;
                  }
                  if (today.getDate() == date.getDate() &&
                      today.getYear() == date.getYear() &&
                      today.getMonth() == date.getMonth()) {
                      showday = true;
                  }
                  var day = new Date(date);
                  var dayname = day.getDay();
                  var daydate = day.getDate();
                  days.push({ 'dayname': dayname, 'daydate': daydate, 'showday': showday, 'month': month+1 });
                  date.setDate(date.getDate() + 1);
                }
                  scope.month = days;
              }
            }

            function initializeDate() {
              scope.currentViewDate = new Date(scope.localdate);
              if(tickets.length > 0)
              {
                //티켓이 있다면 초기화는 티켓 첫 정보를 셋팅한다.
                var ticketDate = tickets[0].show_date;
                if(ticketSelectDay)
                {
                  //만약 선택한 티켓 정보가 있다면 선택한 정보로 current 를 셋팅 한다.
                  ticketDate = ticketSelectDay.show_date;
                }
                var rawDate = ticketDate.split(" ");
                var d = rawDate[0].split("-");
                var t = rawDate[1].split(":");

                scope.currentViewDate = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
              }

              scope.currentMonthName = function () {
                  return scope.monthNames[scope.currentViewDate.getMonth()];
              };
              getDaysInMonth("TRUE");
              getSelected();
            }

            function reInitializeDate(){
              scope.currentViewDate = new Date(scope.localdate);

              /*
              if(tickets.length > 0)
              {
                //티켓이 있다면 초기화는 티켓 첫 정보를 셋팅한다.
                scope.currentViewDate = new Date(tickets[0].show_date);
              }
              */

              scope.currentMonthName = function () {
                  return scope.monthNames[scope.currentViewDate.getMonth()];
              };

              getDaysInMonth("FALSE");
              getSelected();
            }

            // Takes selected time and date and combines them into a date object
            function getDateAndTime(localdate) {
                var time = scope.time.split(':');
                if (scope.timeframe == 'am' && time[0] == '12') {
                    time[0] = 0;
                } else if (scope.timeframe == 'pm' && time[0] !== '12') {
                    time[0] = parseInt(time[0]) + 12;
                }
                return new Date(localdate.getFullYear(), localdate.getMonth(), localdate.getDate(), time[0], time[1]);
            }

            // Convert to UTC to account for different time zones
            function convertToUTC(localdate) {
                var date_obj = getDateAndTime(localdate);
                var utcdate = new Date(date_obj.getUTCFullYear(), date_obj.getUTCMonth(), date_obj.getUTCDate(), date_obj.getUTCHours(), date_obj.getUTCMinutes());
                return utcdate;
            }
            // Convert from UTC to account for different time zones
            function convertFromUTC(utcdate) {
                localdate = new Date(utcdate);
                return localdate;
            }

            // Returns the format of time desired for the scheduler, Also I set the am/pm
            function formatAMPM(date) {
                var hours = date.getHours();
                var minutes = date.getMinutes();
                hours >= 12 ? scope.changetime('pm') : scope.changetime('am');
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0' + minutes : minutes;
                var strTime = hours + ':' + minutes;
                return strTime;
            }

            scope.$watch('open', function() {
                if (scope.selecteddate !== undefined && scope.selecteddate !== null) {
                    scope.localdate = convertFromUTC(scope.selecteddate);
                } else {
                    scope.localdate = new Date();
                    scope.localdate.setMinutes(Math.round(scope.localdate.getMinutes() / 60) * 30);
                }
				scope.time = formatAMPM(scope.localdate);
				scope.setTimeBar(scope.localdate);
				initializeDate();
				scope.updateInputTime();
            });

            scope.selectDate = function (day) {
                if (scope.pickdate == "true" && day.showday) {
                    for (var number in scope.month) {
                        var item = scope.month[number];
                        if (item.selected === true) {
                            item.selected = false;
                        }
                    }
                    day.selected = true;
                    scope.selectedDay = scope.days[day.dayname].long;
                    scope.localdate = new Date(scope.currentViewDate.getFullYear(), scope.currentViewDate.getMonth(), day.daydate);

                    //initializeDate(scope.localdate);
                    reInitializeDate();
                    scope.updateDate();
                }
            };

            scope.updateDate = function () {
                if (scope.localdate) {
                    var newdate = getDateAndTime(scope.localdate);
                    scope.updatefn({newdate:newdate});
                }
            };

            scope.moveForward = function () {
                scope.currentViewDate.setDate(1);
                scope.currentViewDate.setMonth(scope.currentViewDate.getMonth() + 1);
                if (scope.currentViewDate.getMonth() == 12) {
                    scope.currentViewDate.setDate(scope.currentViewDate.getFullYear() + 1, 0, 1);
                }
                //alert(scope.currentViewDate.getMonth());
                getDaysInMonth("FALSE");
                getSelected();
            };

            scope.moveBack = function () {
                scope.currentViewDate.setDate(1);
                scope.currentViewDate.setMonth(scope.currentViewDate.getMonth() - 1);
                if (scope.currentViewDate.getMonth() == -1) {
                    scope.currentViewDate.setDate(scope.currentViewDate.getFullYear() - 1, 0, 1);
                }
                getDaysInMonth("FALSE");
                getSelected();
            };

            scope.calcOffset = function (day, index) {
                if (index === 0) {
                    var offset = (day.dayname * 14.2857142) + '%';
					if (scope.mondayfirst == 'true') {
						offset = ((day.dayname - 1) * 14.2857142) + '%';
					}
                    return offset;
                }
            };

			///////////////////////////////////////////////
			// Check size of parent element, apply class //
			///////////////////////////////////////////////
			scope.checkWidth = function (apply) {
				var parent_width = element.parent().width();
				if (parent_width < 620) {
					scope.compact = true;
				} else {
					scope.compact = false;
				}
				if (apply) {
					scope.$apply();
				}
			};
			scope.checkWidth(false);

            //////////////////////
            // Time Picker Code //
            //////////////////////
            if (scope.picktime) {
                var currenttime;
                var timeline;
                var timeline_width;
                var timeline_container;
                var sectionlength;

                scope.getHours = function () {
                    var hours = new Array(11);
                    return hours;
                };

                scope.time = "12:00";
                scope.hour = 12;
                scope.minutes = 0;
                scope.currentoffset = 0;

                scope.timeframe = 'am';

                scope.changetime = function(time) {
                  //alert("aaa");
                    scope.timeframe = time;
                    scope.updateDate();
					          scope.updateInputTime();
                };

				scope.edittime = {
					digits: []
				};

				scope.updateInputTime = function () {
					scope.edittime.input = scope.time + ' ' + scope.timeframe;
					scope.edittime.formatted = scope.edittime.input;
				};

				scope.updateInputTime();

				function checkValidTime (number) {
					validity = true;
					switch (scope.edittime.digits.length) {
						case 0:
							if (number === 0) {
								validity = false;
							}
							break;
						case 1:
							if (number > 5) {
								validity = false;
							} else {
								validity = true;
							}
							break;
						case 2:
							validity = true;
							break;
						case 3:
							if (scope.edittime.digits[0] > 1) {
								validity = false;
							} else if (scope.edittime.digits[1] > 2) {
								validity = false;
							} else if (scope.edittime.digits[2] > 5) {
								validity = false;
							}
							else {
								validity = true;
							}
							break;
						case 4:
							validity = false;
							break;
					}
					return validity;
				}

				function formatTime () {
					var time = "";
					if (scope.edittime.digits.length == 1) {
						time = "--:-" + scope.edittime.digits[0];
					} else if (scope.edittime.digits.length == 2) {
						time = "--:" + scope.edittime.digits[0] + scope.edittime.digits[1];
					} else if (scope.edittime.digits.length == 3) {
						time = "-" + scope.edittime.digits[0] + ':' + scope.edittime.digits[1] + scope.edittime.digits[2];
					} else if (scope.edittime.digits.length == 4) {
						time = scope.edittime.digits[0] + scope.edittime.digits[1].toString() + ':' + scope.edittime.digits[2] + scope.edittime.digits[3];
						console.log(time);
					}
					return time + ' ' + scope.timeframe;
				};

				scope.changeInputTime = function (event) {
					var numbers = {48:0,49:1,50:2,51:3,52:4,53:5,54:6,55:7,56:8,57:9};
					if (numbers[event.which] !== undefined) {
						if (checkValidTime(numbers[event.which])) {
							scope.edittime.digits.push(numbers[event.which]);
							console.log(scope.edittime.digits);
							scope.time_input = formatTime();
							scope.time = numbers[event.which] + ':00';
							scope.updateDate();
							scope.setTimeBar();
						}
					} else if (event.which == 65) {
						scope.timeframe = 'am';
						scope.time_input = scope.time + ' ' + scope.timeframe;
					} else if (event.which == 80) {
						scope.timeframe = 'pm';
						scope.time_input = scope.time + ' ' + scope.timeframe;
					} else if (event.which == 8) {
						scope.edittime.digits.pop();
						scope.time_input = formatTime();
						console.log(scope.edittime.digits);
					}
					scope.edittime.formatted = scope.time_input;
					// scope.edittime.input = formatted;
				};

                var pad2 = function (number) {
                    return (number < 10 ? '0' : '') + number;
                };

                scope.moving = false;
                scope.offsetx = 0;
                scope.totaloffset = 0;
                scope.initializeTimepicker = function () {
                    currenttime = $('.current-time');
                    timeline = $('.timeline');
                    if (timeline.length > 0) {
                        timeline_width = timeline[0].offsetWidth;
                    }
                    timeline_container = $('.timeline-container');
                    sectionlength = timeline_width / 24 / 6;
                };

                angular.element($window).on('resize', function () {
                    scope.initializeTimepicker();
                    if (timeline.length > 0) {
                        timeline_width = timeline[0].offsetWidth;
                    }
                    sectionlength = timeline_width / 24;
					scope.checkWidth(true);
                });

          scope.setTimeBar = function (date) {
            /*
					currenttime = $('.current-time');
					var timeline_width = $('.timeline')[0].offsetWidth;
          alert(timeline_width);
          var hours = scope.time.split(':')[0];
					if (hours == 12) {
						hours = 0;
					}
					var minutes = scope.time.split(':')[1];
					var minutes_offset = (minutes / 60) * (timeline_width / 12);
					var hours_offset = (hours / 12) * timeline_width;
					scope.currentoffset = parseInt(hours_offset + minutes_offset - 1);
                    currenttime.css({
						transition: 'transform 0.4s ease',
                        transform: 'translateX(' + scope.currentoffset + 'px)',
                    });
                    */
          };

        scope.getTime = function () {
                    // get hours
          var percenttime = (scope.currentoffset + 1) / timeline_width;
          var hour = Math.floor(percenttime * 12);
          var percentminutes = (percenttime * 12) - hour;
					var minutes = Math.round((percentminutes * 60) / 5) * 5;
                    if (hour === 0) {
                        hour = 12;
                    }
					if (minutes == 60) {
						hour += 1;
						minutes = 0;
					}

                    scope.time = hour + ":" + pad2(minutes);
					scope.updateInputTime();
                    scope.updateDate();
                };

                var initialized = false;

                element.on('touchstart', function() {
                    if (!initialized) {
                        element.find('.timeline-container').on('touchstart', function (event) {
                            scope.timeSelectStart(event);
                        });
                        initialized = true;
                    }
                });

                //timeSelectStart 타임라인 기능. 필요없음
                scope.timeSelectStart = function (event) {
                    scope.initializeTimepicker();
                    var timepicker_container = element.find('.timepicker-container-inner');
					          var timepicker_offset = timepicker_container.offset().left;

                    if (event.type == 'mousedown') {
                        scope.xinitial = event.clientX;
                    } else if (event.type == 'touchstart') {
                        scope.xinitial = event.originalEvent.touches[0].clientX;
                    }

                    scope.moving = true;
                    scope.currentoffset = scope.xinitial - timepicker_container.offset().left;
                    scope.totaloffset = scope.xinitial - timepicker_container.offset().left;

      					console.log(timepicker_container.width());
      					if (scope.currentoffset < 0) {
      						scope.currentoffset = 0;
      					} else if (scope.currentoffset > timepicker_container.width()) {
      						scope.currentoffset = timepicker_container.width();
      					}
      					currenttime.css({
                              transform: 'translateX(' + scope.currentoffset + 'px)',
                              transition: 'none',
                              cursor: 'ew-resize',
                          });
                          scope.getTime();
                      };

                angular.element($window).on('mousemove touchmove', function (event) {
                    if (scope.moving === true) {
                        event.preventDefault();
                        if (event.type == 'mousemove') {
                            scope.offsetx = event.clientX - scope.xinitial;
                        } else if (event.type == 'touchmove') {
                            scope.offsetx = event.originalEvent.touches[0].clientX - scope.xinitial;
                        }
                        var movex = scope.offsetx + scope.totaloffset;
                        if (movex >= 0 && movex <= timeline_width) {
                            currenttime.css({
                                transform: 'translateX(' + movex + 'px)',
                            });
                            scope.currentoffset = movex;
                        } else if (movex < 0) {
                            currenttime.css({
                                transform: 'translateX(0)',
                            });
                            scope.currentoffset = 0;
                        } else {
                            currenttime.css({
                                transform: 'translateX(' + timeline_width + 'px)',
                            });
                            scope.currentoffset = timeline_width;
                        }
                        scope.getTime();
                        scope.$apply();
                    }
                });

                angular.element($window).on('mouseup touchend', function (event) {
                    if (scope.moving) {
                        // var roundsection = Math.round(scope.currentoffset / sectionlength);
                        // var newoffset = roundsection * sectionlength;
                        // currenttime.css({
                        //     transition: 'transform 0.25s ease',
                        //     transform: 'translateX(' + (newoffset - 1) + 'px)',
                        //     cursor: 'pointer',
                        // });
                        // scope.currentoffset = newoffset;
                        // scope.totaloffset = scope.currentoffset;
                        // $timeout(function () {
                        //     scope.getTime();
                        // }, 250);
                    }
                    scope.moving = false;
                });

                scope.adjustTime = function (direction) {
                    event.preventDefault();
                    scope.initializeTimepicker();
                    var newoffset;
                    if (direction == 'decrease') {
                        newoffset = scope.currentoffset - sectionlength;
                    } else if (direction == 'increase') {
                        newoffset = scope.currentoffset + sectionlength;
                    }
                    if (newoffset < 0 || newoffset > timeline_width) {
                        if (newoffset < 0) {
                            newoffset = timeline_width - sectionlength;
                        } else if (newoffset > timeline_width) {
                            newoffset = 0 + sectionlength;
                        }
                        if (scope.timeframe == 'am') {
                            scope.timeframe = 'pm';
                        }
                        else if (scope.timeframe == 'pm') {
                            scope.timeframe = 'am';
                        }
                    }
                    currenttime.css({
                        transition: 'transform 0.4s ease',
                        transform: 'translateX(' + (newoffset - 1) + 'px)',
                    });
                    scope.currentoffset = newoffset;
                    scope.totaloffset = scope.currentoffset;
                    scope.getTime();
                };
            }

            // End Timepicker Code //

        }
    };
});


$(document).ready(function() {

  var ticketsCategoryJson = $('#tickets_json_category_info').val();
	var ticketsCategory = '';
	if (ticketsCategoryJson) {
		//alert(ticketsCategoryJson);
		 ticketsCategory = $.parseJSON(ticketsCategoryJson);
	}

  var g_isDetail = $('#isDetail').val();

  $('#timepicker-container-outer-container').hide();

  if(isMobile() == true)
  {
    $('#ticket_place_holder').hide();
  }
  else {
    $('#ticket_place_holder').show();
  }

  var dateSelect = function(){
    var ticketYear = $(this).attr('data-ticket-year');
    var ticketMonth = $(this).attr('data-ticket-month');
    var ticketday = $(this).attr('data-ticket-day');

    setTicketDateSelectBind();
    listTimeTickets(ticketYear, ticketMonth, ticketday);
  };

  var setTicketDateSelectBind = function(){
    var lastDay = getLastDay();
    for (var i = 1; i <= lastDay; i++)
    {
        var dateSelectName = "#dateSelect"+i;
        $(dateSelectName).bind('click', dateSelect);
    }
  };

  var getLastDay = function(){
    var ticket_year = $('#tickets_year').val();
    var ticket_month = $('#tickets_month').val();
    var lastDay = ( new Date( ticket_year, ticket_month, 0) ).getDate();

    return lastDay;
  };

  var listTimeTickets = function(year, month, day) {
    $('#timeTicketsList').children().remove();

    resetCalendar();

    /*
    $('#seatTicketsList').children().remove();
    $('#ticketing-btn-calendar').hide();
    $("#ticket_count_input_wrapper").hide();
    $("#ticket_count_input").val(1);
    */

		var ticketsJson = $('#tickets_json').val();
		if (ticketsJson) {
			var tickets = $.parseJSON(ticketsJson);
      if(!tickets)
      {
        return;
      }
			if (tickets.length > 0) {
        $('#timepicker-container-outer-container').show();
        $('#ticket_place_holder').hide();
        //var ticketArray = new Array();
        var ticketArrayTemp = new Array();

				for (var i = 0, l = tickets.length; i < l; i++) {
          var ticket = tickets[i];
          var rawDate = ticket.show_date.split(" ");
          var d = rawDate[0].split("-");
          var t = rawDate[1].split(":");
          var date = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
          var yyyy = date.getFullYear();
          var mm = date.getMonth() + 1;
          var dd = date.getDate();

          if(d[0] == 0000)
          {
            //0000년도면 티켓이 미정이다.
            yyyy = 0000;
            mm = 00;
            dd = 00;
          }

          if(year == yyyy &&
            month == mm &&
            day == dd)
            {
              var H = date.getHours();
	    				var min = date.getMinutes();
              if(H < 10){
                H = "0" + H;
              }
        			if (min < 10) {
        				min = "0" + min;
        			}

      				//var formatted = H + ":" + min;

              //ticketArrayTemp

              var ticketInfo = new Object();
              ticketInfo.ticket = ticket;
              ticketInfo.hour = H;
              ticketInfo.min = min;
              //ticketInfo.time = formatted;

              ticketArrayTemp.push(ticketInfo);
              //addTicketTimeRow(formatted);
            }
				}

        ////////
        var ticketTimeArray = new Array();
        for (var i = 0, l = ticketArrayTemp.length; i < l; i++) {
          var hour = ticketArrayTemp[i].hour;
          var min = ticketArrayTemp[i].min;
          //var ticketID = ticketArrayTemp[i].ticket.id;

          var isSaved = false;
          for (var j = 0, lj = ticketTimeArray.length; j < lj; j++) {
            //var ticketInfo = new Object();
            if(hour == ticketTimeArray[j].hour
              && min == ticketTimeArray[j].min)
              {
                isSaved = true;
              }
          }
          //ticketDayArray.
          if(isSaved == false)
          {
            var timeInfo = new Object();
            timeInfo.hour = hour;
            timeInfo.min = min;

            ticketTimeArray.push(timeInfo);
          }
        }

        //seat 데이터 셋팅
        var ticketArray = new Array();
        for (var i = 0, l = ticketTimeArray.length; i < l; i++) {
          var hour = ticketTimeArray[i].hour;
          var min = ticketTimeArray[i].min;

          var ticketInfoArray = new Array();
          for (var j = 0, lj = ticketArrayTemp.length; j < lj; j++) {
            if(hour == ticketArrayTemp[j].hour
              && min == ticketArrayTemp[j].min)
              {
                var ticketInfo = new Object();
                ticketInfo.ticket = ticketArrayTemp[j].ticket;
                ticketInfoArray.push(ticketInfo);
              }
          }

          var ticketData = new Object();
          ticketData.hour = hour;
          ticketData.min = min;
          ticketData.ticketArray = ticketInfoArray;

          ticketArray.push(ticketData);
        }

        for (var i = 0, l = ticketArray.length; i < l; i++) {

          var H = ticketArray[i].hour;
          var min = ticketArray[i].min;
          var tickets = ticketArray[i].ticketArray;

          //var formatted = H + ":" + min;
          //var time = H + ":" + min;

          //addTicketTimeRow(time, tickets);
          //alert(H + " | " + min);
          addTicketTimeRow(H, min, tickets);
        }
			}
		}
	};

  var setTotalPrice = function(){
    //
    var ticketPrice = $('#ticket_select_price').val();
    var ticketCount = $('#ticket_count_input').val();

    var ticketTotalPrice = ticketPrice * ticketCount;
    var goodsTotalPrice = 0;

    $('#request_price').val(ticketPrice);
    $('#ticket_count').val(ticketCount);

    //할인율 적용
    var discountValue = $('#discount_select_value').val();
    if(discountValue)
    {
      //alert("discount value : " + discountValue);
      var discoutPrice = ticketTotalPrice * (discountValue/100);
      ticketTotalPrice = ticketTotalPrice - discoutPrice;
    }

    //추가된 md가 있는지 확인

    var goodsArray = new Array();
    $(".ticket_goods_count_input").each(function () {
      var goodsCount = $(this).val();

      if(goodsCount == 0)
      {
        return true;//for문의 continue와 같음.
      }

      var goodsPrice = $(this).attr('goods-price');
      var goodsTicketDiscountPrice = $(this).attr('goods-ticket-discount-price');
      goodsTicketDiscountPrice = goodsTicketDiscountPrice * goodsCount;
      var goodsTotalPrice = goodsPrice * goodsCount;

      var goodsInfo = new Object();
      goodsInfo.totalPrice = goodsTotalPrice;
      goodsInfo.ticketDiscount = goodsTicketDiscountPrice;

      goodsArray.push(goodsInfo);
    });

    //ticketTotalPrice
    //실제 MD 계산
    var goodsTotalPrice = 0;
    var goodsTicketDiscountPrice = 0;
    for(var i = 0 ; i < goodsArray.length ; i++)
    {
      goodsTotalPrice = goodsTotalPrice + goodsArray[i].totalPrice;
      goodsTicketDiscountPrice = goodsTicketDiscountPrice + goodsArray[i].ticketDiscount
    }

    ticketTotalPrice = ticketTotalPrice - goodsTicketDiscountPrice;
    if(ticketTotalPrice < 0)
    {
      ticketTotalPrice = 0;
    }

    //추가 후원이 있는지 확인
    var supportPrice = Number($('#order_support_price_input').val());

    var totalPrice = ticketTotalPrice + goodsTotalPrice + supportPrice;

    //최종 구매 금액
    if(totalPrice < 0)
    {
      totalPrice = 0;
    }

    $('#order_price_text').text( addComma(totalPrice));
  };

  var ticketTimeSelect = function(){
    var ticketTimeItem = $(this).closest('.ticket_time_item');
		var ticketData = ticketTimeItem.data('ticketsData');

    var ticketTimeBtn = ticketTimeItem.children('.ticket_time_btn');
    $("#timeTicketsList button").removeClass("ticket_time_btn_on");

    ticketTimeBtn.addClass("ticket_time_btn_on");

    resetCalendar();

    for (var i = 0; i < ticketData.length; i++) {
      addTicketSeatRow(ticketData[i].ticket);
    }
  };

  var ticketSeatSelect = function(){
    var ticketSeatItem = $(this).closest('.ticket_seat_item');
		var ticketData = ticketSeatItem.data('ticketData');

    var ticketSeatBtn = ticketSeatItem.children('.ticket_seat_btn');
    $("#seatTicketsList button").removeClass("ticket_seat_btn_on");

    ticketSeatBtn.addClass("ticket_seat_btn_on");

    var ticketingBtnCalendar = $('#ticketing-btn-calendar');

    //ticketingBtnCalendar.attr('data-ticket-id', ticketData.id);
    $("#ticket_select_id_input").val(ticketData.id);

    ticketingBtnCalendar.show();

    //매수 선택
    $("#ticket_count_input_wrapper").show();
    $("#ticket_select_price").val(ticketData.price);

    //새로운 코드
    $("#ticket_count_input").val(1);
    $("#ticket_count_input").attr("ticket-data-id", ticketData.id);
    $("#ticket_count_input").attr("ticket-data-price", ticketData.price);
    $("#ticket_count_input").attr("ticket-data-amount", getAmountTicket(ticketData));
    $("#ticket_count_input").attr("ticket-buy-limit", ticketData.buy_limit);
    //$("#ticket_count_input").trigger('change');
    //$("#ticket_count_input").trigger('click');

    setTicketCount();
  };

  $('.ticket_count_up').click(function(){
    addTicketCount();
    ticketLimitCheck();
    setTicketCount();
  });

  $('.ticket_count_down').click(function(){
    subTicketCount();
    ticketLimitCheck();
    setTicketCount();
  });

  var addTicketCount = function(){
    var ticketCount = Number($("#ticket_count_input").val());
    ticketCount++;
    $("#ticket_count_input").val(ticketCount);
  };

  var subTicketCount = function(){
    var ticketCount = Number($("#ticket_count_input").val());
    ticketCount--;
    if(ticketCount <= 0)
    {
      ticketCount = 0;
    }

    $("#ticket_count_input").val(ticketCount);
  };

  var ticketLimitCheck = function(){
    var ticketAmount = Number($("#ticket_count_input").attr("ticket-data-amount"));
    var limitBuyCount = Number($("#ticket_count_input").attr("ticket-buy-limit"));
    var ticketCount = Number($("#ticket_count_input").val());

    if( ticketCount > ticketAmount )
    {
      alert("티켓 수량을 초과하였습니다.");
      $( "#ticket_count_input" ).val(ticketAmount);
    }

    if(limitBuyCount > 0 && ticketCount > limitBuyCount)
    {
      alert("1회 구매 수량을 초과하였습니다.");
      $( "#ticket_count_input" ).val(limitBuyCount);
    }
  };

  var setTicketCount = function(){
    var ticketCount = $("#ticket_count_input").val();
    $('.ticket_count_text').text(ticketCount+"매");

    setTotalPrice();
  };

  //var addTicketTimeRow = function(time, tickets) {
  var addTicketTimeRow = function(hour, min, tickets) {
    var template = $('#template_ticket_time').html();
    var compiled = _.template(template);
    var time = hour + ":" + min;
    //var isMobile = 'aa';

    var row = compiled({ 'time': time, 'hour': hour, 'min': min, 'isMobile':isMobile(), 'isDetail': g_isDetail });
    var $row = $($.parseHTML(row));
    $row.data('ticketsData', tickets);
    $('#timeTicketsList').append($row);

    var selectTimeId = "#ticket_time_btn"+hour+"_"+min;
    //$row.find('.ticket_time_btn').bind('click', ticketTimeSelect);
    //alert(selectTimeId);
    $row.find(selectTimeId).bind('click', ticketTimeSelect);

    //console.error(isMobile());
  };

  var addTicketSeatRow = function(ticket){
    if (!ticket.audiences_count) {
			ticket.audiences_count = 0;
		}

		var ticketCategoryTemp = ticket.category;
		if(ticketsCategory.length > 0){
			var categoryNum = Number(ticket.category);
			for (var i = 0; i < ticketsCategory.length; i++) {
				if(Number(ticketsCategory[i].id) === categoryNum){
					ticketCategoryTemp = ticketsCategory[i].title;
					break;
				}
			}
		}

    //티켓 남은 수량
    var amountTicketCount = getAmountTicket(ticket);
    var ticketBuyCountInfoList = $('#tickets_buy_count_info').val();
    if(ticketBuyCountInfoList)
    {
      var ticketsInfoList = $.parseJSON(ticketBuyCountInfoList);

      for(var i = 0 ; i < ticketsInfoList.length ; i++)
      {
        if(ticket.id == ticketsInfoList[i].id)
        {
          amountTicketCount = Number(ticket.audiences_limit) - Number(ticketsInfoList[i].buycount);
        }
      }
    }

		var template = $('#template_ticket_seat').html();
		var compiled = _.template(template);
		var row = compiled({ 'ticket': ticket, 'type': $('#project_saleType').val(), 'style': 'modifyable',  'ticketCategory': ticketCategoryTemp, 'isMobile': isMobile(), 'isDetail': g_isDetail, 'amountTicketCount':amountTicketCount});
		var $row = $($.parseHTML(row));
		$row.data('ticketData', ticket);
		$('#seatTicketsList').append($row);

    var selectSeatId = "#ticket_seat_btn"+ticket.id;

    if(amountTicketCount > 0){
      $row.find(selectSeatId).bind('click', ticketSeatSelect);
    }
  };

  var getAmountTicket = function(ticket)
  {
    var amountTicketCount = ticket.audiences_limit;
    var ticketBuyCountInfoList = $('#tickets_buy_count_info').val();
    if(ticketBuyCountInfoList)
    {
      var ticketsInfoList = $.parseJSON(ticketBuyCountInfoList);

      for(var i = 0 ; i < ticketsInfoList.length ; i++)
      {
        if(ticket.id == ticketsInfoList[i].id)
        {
          amountTicketCount = Number(ticket.audiences_limit) - Number(ticketsInfoList[i].buycount);
        }
      }
    }

    return amountTicketCount;
  }

  var moveForwardJS = function(){
    var year = $(this).attr('data-ticket-year');
    var month = $(this).attr('data-ticket-month');
    //var ticketday = $(this).attr('data-ticket-day');

    var nextMonth = month + 1;
    var nextYear = year;
    if(nextMonth == 13)
    {
      nextMonth = 1;
      nextYear+=1;
    }

    $('#tickets_year').val(nextYear);
    $('#tickets_month').val(nextMonth);

    setTicketDateSelectBind();
  };

  var moveBackS = function(){
    var year = $(this).attr('data-ticket-year');
    var month = $(this).attr('data-ticket-month');
    //var ticketday = $(this).attr('data-ticket-day');

    var beforeMonth = month - 1;
    var beforeYear = year;
    if(beforeMonth < 0)
    {
      beforeMonth = 12;
      beforeYear-=1;
    }

    $('#tickets_year').val(beforeYear);
    $('#tickets_month').val(beforeMonth);

    setTicketDateSelectBind();
  };

  var selectCalendarTicket = function(){
    if($("#isWaitSaleTime").val() == true)
    {
      var waitTimeWord = $("#isWaitSaleTime").attr("time-value") + " 에 오픈 예정입니다.";//오픈예정 진짜코드
      //var waitTimeWord = "COMING SOON";//오픈예정 임시
      swal(waitTimeWord, "", "info");
      return;
    }
    if($("#isFinished").val() == true)
    {
      if($("#isPickType").val())
      {
        if($("#isPickingFinished").val())
        {
          swal("이벤트 종료", "추첨이 완료되었습니다.", "info");
        }
        else
        {
          swal("추첨중 입니다.", "", "info");
        }
      }
      else
      {
        swal("이미 끝난 프로젝트 입니다.", "", "info");
      }
      return;
    }
    var baseUrl = $('#base_url').val();
    var ticketID = $('#ticket_select_id_input').val();
    var projectId = $('#project_id').val();

    var projecttest = $('#projecttest').val();
    var url = baseUrl + '/projects/' + projectId + '/tickets';
    if(ticketID){
      url = baseUrl + '/projects/' + projectId + '/tickets/' + ticketID;
    }
    //{{ url('/projects/') }}/{{ $project->id }}/tickets
    window.location.href = url;
  };

  var resetCalendar = function(){
    $('#seatTicketsList').children().remove();
    $('#ticketing-btn-calendar').hide();
    $("#ticket_count_input_wrapper").hide();
    $("#ticket_count_input").val(1);
    $('#ticket_select_id_input').val('');

    $("#ticket_count_input").val(0);
    $("#ticket_count_input").attr("ticket-data-id", '');
    $("#ticket_count_input").attr("ticket-data-price", '');
    $("#ticket_count_input").attr("ticket-data-amount", '');
    $("#ticket_count_input").attr("ticket-buy-limit", '');
    //$("#ticket_count_input").trigger('click');

    setTicketCount();
  };

  $('#goforward').bind('click', moveForwardJS);
  $('#goback').bind('click', moveBackS);
  $('#ticketing-btn-calendar').bind('click', selectCalendarTicket);

  $('#detail_main_cw_btn').bind('click', selectCalendarTicket);
  $('#detail_tab_cw_btn_mobile').bind('click', selectCalendarTicket);
  $('#detail_tab_cw_btn').bind('click', selectCalendarTicket);

  setTicketDateSelectBind();

  //장소가 미정이면, 모든 티켓에 대한 정보가 다 나온다.
  if(isPlace == "FALSE")
  {
    if(tickets.length > 0)
    {
      listTimeTickets(0000, 00, 00);

      var selectTimeId = '#ticket_time_btn00_00';
      $(selectTimeId).trigger('click');

      var selectSeatId = '#ticket_seat_btn'+tickets[0].id;
      $(selectSeatId).trigger('click');
      /*
      if(ticketSelectDay)
      {
        var selectSeatId = '#ticket_seat_btn'+ticketSelectDay.id;
        $(selectSeatId).trigger('click');
      }
      */
    }
  }

  //선택된 날이 있다면 해당 날로 select 해준다.
  if(isPlace == "TRUE" && ticketSelectDay)
  {
    var rawDate = ticketSelectDay.show_date.split(" ");
    var d = rawDate[0].split("-");
    var t = rawDate[1].split(":");

    var showDate = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
    //var showDate = new Date(ticketSelectDay.show_date);
    var hour = showDate.getHours();
    var min = showDate.getMinutes()
    if(hour < 10)
    {
      hour = "0"+hour;
    }

    if(min < 10)
    {
      min = "0"+min;
    }

    var selectDateId = '#dateSelect' + showDate.getDate();
    var selectTimeId = '#ticket_time_btn'+hour+'_'+min;
    var selectSeatId = '#ticket_seat_btn'+ticketSelectDay.id;

    $(selectDateId).trigger('click');
    $(selectTimeId).trigger('click');
    $(selectSeatId).trigger('click');
  }

  var setTicketNotice = function(){
    if($('#isEventTypeCrawlingEvent').val())
		{
			return;
		}

    var ticketNotice = $('#ticket_notice').val();
    //ticketNotice = ticketNotice.replace(/\r?\n/g, '<br />');
    ticketNotice = getConverterEnterString(ticketNotice);
    $('#ticket_notice_container').append(ticketNotice);
  };

  setTicketNotice();

  //날짜 선택시 젤 하단에 있을경우 자동 스크롤 할지 체크 해주는 함수
  var scrollBottomCheck = function(){

  };
});
