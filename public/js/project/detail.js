$(document).ready(function() {
	if(!!window.performance && window.performance.navigation.type === 2)
	{
    window.location.reload();
	}

	var swiper = new Swiper('.swiper-container', {
		 centeredSlides: true,
		 loop: true,
		 speed: 800,
		 autoplay: {
			 delay: 5000,
			 disableOnInteraction: false,
		 },
		 pagination: {
			 el: '.swiper-pagination',
			 clickable: true,
		 }
	 });

	var projectId = $('#project_id').val();

	var commentsLoader = new Loader('/projects/' + projectId + '/comments', 20);
	//var commentsLoader = new Loader('/projects/' + projectId + '/comments', 100);
	commentsLoader.setTemplate("#template-comments");
	commentsLoader.setContainer("#comments-container");
	commentsLoader.setCompleteListener(function() {
		$(".toggle-reply").each(function() {
			$(this).bind('click', function() {
				if(isLogin() == false)
				{
					alert("로그인을 해야 댓글을 달 수 있습니다.");
					return;
				}

				var list = $(this).closest('.comment-list');
				list.find("form").toggle();
			});
		});

		$(".delete-comment").each(function() {
			$(this).bind('click', function() {
				var commentId = $(this).attr('data-comment-id');

				swal("댓글을 삭제 하시겠습니까?", {
						  buttons: {
						    cancel: "취소",
						    catch: {
						      text: "삭제",
						      value: "delete",
						    },

						  },
							icon: "warning",
						})
						.then(function(value){
							switch (value) {
						    case "delete":
						      deleteComment(commentId);
						      break;
						  }
						});
				/*
				swal("댓글을 삭제 하시겠습니까?", {
						  buttons: {
						    cancel: "취소",
						    catch: {
						      text: "삭제",
						      value: "delete",
						    },

						  },
							icon: "warning",
						})
						.then((value) => {
						  switch (value) {
						    case "delete":
						      deleteComment(commentId);
						      break;
						  }
						});
						*/

			});
		});
	});

	var newsLoader = new Loader('/projects/' + projectId + '/news', 8);
	newsLoader.setTemplate('#template-news');
	newsLoader.setContainer('#news-container');

	var supportersLoader = new Loader('/projects/' + projectId + '/supporters', 20);
	supportersLoader.setTemplate('#template-supporter');
	supportersLoader.setContainer('#supporters-container');

	$('#tab-comments').data('loader', commentsLoader);
	$('#tab-news').data('loader', newsLoader);
	$('#tab-supporters').data('loader', supportersLoader);

	//isMaster

	var loadContents = function(e) {
		var href = $(e.target).attr('href');

		if(href == "#tab-comments")
		{
			//$('#detail_ticket_md').hide();
		}
		else
		{
			//$('#detail_ticket_md').show();
		}

		var target = $(href);
		if (target.hasClass('loadable')) {
			var loader = target.data('loader');
			if (loader) {
				loader.load();
			}
			target.removeClass('loadable');
		}

		//listGoods();
	};

	$('.detail_comment_add_btn').click(function(){
		if(isLogin() == false)
		{
			alert("로그인을 해야 댓글을 달 수 있습니다.");
			return;
		}

		$('#addComment').submit();
	});

	var deleteComment = function(commentId) {
		if(!commentId)
		{
			alert("코멘트 삭제 에러");
			return;
		}

		var url = '/comments/' + commentId;
		var method = 'delete';

		var success = function(result) {
			swal("삭제 성공!", "", "success");
			window.location.reload();
		};
		var error = function(request) {
			alert('댓글 삭제에 실패하였습니다.');
		};

		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
	};

	var listGoods = function(){
		var goodsJson = $('#goods_json').val();
		if (goodsJson) {
			var goods = $.parseJSON(goodsJson);
			if (goods.length > 0) {
				for (var i = 0, l = goods.length; i < l; i++) {
					addGoodsRow(goods[i]);
				}
			}
		}
	};

	var addGoodsRow = function(goods){
		var lineItemMax = 3;
		var containerClassName = '.goodsListContainer';
		var goodsList = $('#detail_goods_list');

		var templateGoodsItem = $('#template_goods_list_item').html();
		var compiledGoodsItem = _.template(templateGoodsItem);

		//goods설명 한줄띄우기 컨버터
		goods.content = getConverterEnterString(goods.content);

		var rowGoodsItem = compiledGoodsItem({ 'goods': goods });
		var $rowGoodsItem = $($.parseHTML(rowGoodsItem));
		$rowGoodsItem.data('goodsData', goods);

		var listContainerCount = goodsList.children(containerClassName).size();
		var lineImteCount = goodsList.children(containerClassName).children().size();
		//아이템 개수가 한줄에 몇개 표현되는지 확인하는 계산식
		var calCount = lineImteCount % lineItemMax;

		if(calCount == 0)
		{
			var templateGoodsContainer = $('#template_goods_list_container').html();
			var compiledGoodsContainer = _.template(templateGoodsContainer);
			var rowGoodsContainer = compiledGoodsContainer({ 'listNumber': listContainerCount+1 });
			var $rowGoodsContainer = $($.parseHTML(rowGoodsContainer));
			goodsList.append($rowGoodsContainer);
		}

		var newListContainerCount = goodsList.children(containerClassName).size();
		$('#goodsList_'+newListContainerCount).append($rowGoodsItem);
	};

	listGoods();

	$('a[data-toggle="tab"]').on('shown.bs.tab', loadContents);

	//$('[data-toggle="popover"]').popover();

	$('[data-toggle="popover"]').popover({
        placement : 'top',
        html : true,
        //content : '<ul style="text-align:left; padding-left:0px; margin-bottom:0px;"><li class="share-thumb"><a href=""><img src="{{ asset(\'/img/app/facebook_logo.png\') }}"></a></li><li class="share-thumb"><a href=""><img src="kakaotalk_logo.png"></a></li><li class="share-thumb" style="margin-right:0px;"><a href=""><img src="link_logo.png"></a></li></ul>'
				content : $('#template_shareForm').html()
    });
  $(document).on("click", ".popover .close" , function(){
      $(this).parents(".popover").popover('hide');
  });

	//var navpos = $('#sticky').offset();
	var navpos = $('#stickoffset').offset();
	var navBarCheck = function(){
		if ($(window).scrollTop() > navpos.top) {
     		$('#sticky').addClass('navbar-fixed-top');

				if(isMobile()) {
					$('.nav-ticketing-btn-mobile').show();
					$('.nav-ticketing-btn-mobile').addClass('navbar-fixed-bottom');
					$('.nav-ticketing-btn').hide();
				}
				else {
					$('.nav-ticketing-btn').show();
					$('.nav-ticketing-btn-mobile').hide();
				}
     }
     else {
       $('#sticky').removeClass('navbar-fixed-top');
			 $('.nav-ticketing-btn').hide();
			 $('.nav-ticketing-btn-mobile').hide();
			 $('.nav-ticketing-btn-mobile').removeClass('navbar-fixed-bottom');
     }
	};

	var tabTicketMDCheck = function(){
		if(isMobile()) {
			$('#tabTicketMD').show();
		}
		else {
			$('#tabTicketMD').hide();

			if($('.active').children().attr('href') == '#tab-md'){
				//$('.active').removeClass('active');
				$('a[href="#tab-story"]').click();
			}
		}
	};

	$(window).scroll(function() {
		navBarCheck();
  });

	$(window).resize(function() {
		navpos = $('#stickoffset').offset();
		tabTicketMDCheck();
		//navpos = $('#sticky').offset();
  });

/*
  $(window).bind('scroll', function() {
		navBarCheck();
  });
*/
	navBarCheck();
	tabTicketMDCheck();


	var oldListTickets = function() {
		var tickets = $('#old_ticket_list').data('tickets');
		if(tickets)
		{
			if (tickets.length > 0) {
				for (var i = 0, l = tickets.length; i < l; i++) {
					addOldTicketRow(tickets[i]);
				}
			}
		}
	};

	var addOldTicketRow = function(ticket) {
		var template = $('#template_ticket_old').html();
		var compiled = _.template(template);
		var row = compiled({
			'ticket': ticket,
			'type': $('#project_type').val(),
			'style': 'normal',
			'projectId': projectId,
			'buyable': $('#buyable').val() === "1"
		});
		var $row = $($.parseHTML(row));
		$row.data('ticketData', ticket);
		$row.bind('click', function () {
			var parseDate = function(input) {
				var dash = '-';
				var whitespace = ' ';
				var colon = ':';
				if (input.indexOf(dash) !== -1) {
					var parts = input.split(dash);
					var year = parts[0];
					var month = parts[1] - 1; // Note: months are 0-based
					var day = parts[2];
					if (day.indexOf(whitespace) !== -1) {
						var details = day.split(whitespace);
						day = details[0];
						var times = details[1].split(colon);
						return new Date(year, month, day, times[0], times[1], times[2]);
					}
					return new Date(year, month, day);
				}
				return Date.parse(input);
			};

			var form = $(this).closest('form');
			var limit = ticket.audiences_limit;
			var count = ticket.audiences_count;
			if (parseInt(limit) === 0 || parseInt(limit) > parseInt(count)) {
				var delivery = ticket.delivery_date;
				if (Date.now() < parseDate(delivery)) {
					$(this).next().click();
				} else {
					alert("이미 지난 공연입니다.");
					return false;
				}
			} else {
				alert("매수 제한으로 참여할 수 없습니다.");
				return false;
			}
		});
		$('#old_ticket_list').append($row);
	};

	oldListTickets();

//textContent
	var introduceValue = $("#introduce_input_row").val();
	introduceValue = getConverterEnterString(introduceValue);
	$('.detail_creator_info_introduce').html(introduceValue);

	var setTicketNoticeDetail = function(){
		if(!$('#isEventTypeCrawlingEvent').val())
		{
			return;
		}

    var ticketNotice = $('#ticket_notice').val();
    //ticketNotice = ticketNotice.replace(/\r?\n/g, '<br />');
    ticketNotice = getConverterEnterString(ticketNotice);
    $('#ticket_notice_container').append(ticketNotice);
  };

  setTicketNoticeDetail();


	//주소복사하기
	new ClipboardJS('.detail_main_guide_share_btn');
	$('.detail_main_guide_share_btn').click(function(){
		toastr.options = {
                positionClass: 'toast-bottom-center',
                onclick: null
            };
		toastr.options.showMethod = 'slideDown';

		toastr.success("주소가 복사 되었습니다.");
	});

});


function isLogin(){
	var myId = Number($('#myId').val());
	if(myId == 0)
	{
		return false;
	}

	return true;
}


function isMyOrMasterComment(commentId){
	var myId = Number($('#myId').val());
	var isMaster = $('#isMaster').val();

	if(myId == commentId || isMaster)
	{
		return true;
	}

	return false;
};
