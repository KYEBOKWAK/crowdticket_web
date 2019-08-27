var ticket_category_etc = {"ticket_category_etc":7};

$(document).ready(function() {
	var ticketsCategoryJson = $('#tickets_json_category_info').val();
	var ticketsCategory = '';
	if (ticketsCategoryJson) {
		//alert(ticketsCategoryJson);
		 ticketsCategory = $.parseJSON(ticketsCategoryJson);
	}

	var checkAliasDuplicate = function() {
		var alias = $('#alias').val();
		if (alias.length === 0) {
			alert('주소를 입력해주세요.');
			return;
		}

		if(isCheckKorean(alias) || isCheckEmptyValue(alias))
		{
			return;
		}

		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId + '/alias/' + alias;
		var method = 'get';
		var success = function() {
			swal('사용가능한 주소입니다.', "", "success");
		};
		var error = function(request) {
			if (request.status === 409) {
				swal('이미 존재하는 주소입니다. 다른 이름을 사용해주세요.', "", "error");
			} else if (request.status === 422) {
				swal('잘못된 형식의 주소입니다.', "", "error");
			}
		};

		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
	};

	var updateDefault = function(isNext) {
		updateProject({
			'title': $('#title').val(),
			'alias': $('#alias').val(),
			'category_id': $('#category').val(),
			'city_id': $('#city').val(),
			'hash_tag1': $('#hash_tag1').val(),
			'hash_tag2': $('#hash_tag2').val(),
			'pledged_amount': $('#pledged_amount').val(),
			'funding_closing_at': $('#funding_closing_at').val(),
			'detailed_address': $('#detailed_address').val(),
			'concert_hall': $('#concert_hall').val(),
			'project_target': $('#project_target').val(),
			'temporary_date': $('#temporary_date').val(),
			'sale_start_at': getSaleStartTime(),
			'picking_closing_at': getPickClosingDay()
		}, isNext);
	};

	var updateProject = function(data, isNext) {
		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId;
		var method = 'put';

		var success = function(e) {

			$('#isReqiredSuccess').val('TRUE');

			loadingProcessStop($('.project_form_button_wrapper'));

			swal("저장되었습니다", {
							  buttons: {
							    save: {
							      text: "확인",
							      value: "save",
							    },
							  },

								icon: "success",
							}).then(function(value){
								if(isNext == true)
								{
									nextTabSelect();
								}
							});
		};
		var error = function(e) {
			loadingProcessStop($('.project_form_button_wrapper'));
			swal("저장에 실패하였습니다.", "", "error");
		};

		$.ajax({
			'url': url,
			'method': method,
			'data': data,
			'success': success,
			'error': error
		});
	};

	var listOldTickets = function() {
		var ticketsJson = $('#tickets_json').val();
		if (ticketsJson) {
			var tickets = $.parseJSON(ticketsJson);
			if(tickets)
			{
				if (tickets.length > 0) {
					setHaveTicketText(true);
					for (var i = 0, l = tickets.length; i < l; i++) {
						addTicketRow(tickets[i]);
					}
				}
				else
				{
					setHaveTicketText(false);
				}
			}
		}
	};

	var setHaveTicketText = function(isTicket){
		//$('#ticket_list').remove();
		if(isTicket == true)
		{
			$('#ticket_no_ticket').hide();
		}
		else
		{
			$('#ticket_no_ticket').show();
		}
	};

	var checkNoTicket = function()
	{
		var ticketCount = 0;
		$('.ticket').each(function(){
			ticketCount++;
			return false;
		});

		if(ticketCount > 0)
		{
			setHaveTicketText(true);
		}
		else
		{
			setHaveTicketText(false);
		}
	}

	var setHaveDiscountText = function(isTicket){
		//$('#ticket_list').remove();
		if(isTicket == true)
		{
			$('#discount_no_list').hide();
		}
		else
		{
			$('#discount_no_list').show();
		}
	};

	var checkNoDiscount = function()
	{
		var ticketCount = 0;
		$('.discount').each(function(){
			ticketCount++;
			return false;
		});

		if(ticketCount > 0)
		{
			setHaveDiscountText(true);
		}
		else
		{
			setHaveDiscountText(false);
		}
	}

	var validateTicketData = function(ticket) {
		return true;
		/*
		if (ticket.reward.length === 0) {
			alert("내용을 입력해주세요");
			return false;
		}
		return true;
		*/
	};

	var createTicket = function() {
		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId + '/tickets';

		var method = 'post';
		var data = getTicketFormData();

		if (validateTicketData(data)) {
			var success = function(result) {
				addTicketRow(result);
				checkNoTicket();
			};
			var error = function(request) {
				alert('티켓 추가에 실패하였습니다.');
			};

			$.ajax({
				'url': url,
				'method': method,
				'data': data,
				'success': success,
				'error': error
			});
		}
	};

	var getTicketFormData = function() {
		var hour = Number($('#ticket_delivery_hour').val());
		var min = Number($('#ticket_delivery_min').val());
		if (hour < 10) {
			hour = "0" + hour;
		}
		if (min < 10) {
			min = "0" + min;
		}

		var showDate = $('#ticket_delivery_date').val() + " " + hour + ":" + min + ":00";

		var category = $('#ticket_category').val();
		var categoryNum = Number(category);

		if(categoryNum === ticket_category_etc['ticket_category_etc'])
		{
			category = $('#ticket_category_etc_input').val();
		}

		return {
			'price': $('#ticket_price').val(),
			'audiences_limit': $('#ticket_count').val(),
			//'category': $('#ticket_category').val(),
			'category': category,
			'show_date': showDate
		};
	};

/*
	var getTicketFormData = function() {
		var projectType = $('#project_saleType').val();
		var realTicketCount;
		var requireShipping;
		var deliveryDate;
		if (projectType === 'funding') {
			realTicketCount = $('#ticket_real_count').val();
			requireShipping = $('#ticket_require_shipping').is(':checked') ? 1 : 0;
			question = $('#ticket_question').val();
			deliveryDate = $('#ticket_delivery_date').val() + " 00:00:00";
		} else if (projectType === 'sale') {
			realTicketCount = 1;
			requireShipping = 0;
			var hour = Number($('#ticket_delivery_hour').val());
			var min = Number($('#ticket_delivery_min').val());
			if (hour < 10) {
				hour = "0" + hour;
			}
			if (min < 10) {
				min = "0" + min;
			}
			deliveryDate = $('#ticket_delivery_date').val() + " " + hour + ":" + min + ":00";
		} else {
			return;
		}

		return {
			'price': $('#ticket_price').val(),
			'reward': $('#ticket_reward').val(),
			'question': $('#ticket_question').val(),
			'audiences_limit': $('#ticket_audiences_limit').val(),
			'real_ticket_count': realTicketCount,
			'require_shipping': requireShipping,
			'delivery_date': deliveryDate
		};
	};
*/
	var clearTicketForm = function() {
		$('#ticket_price').val('0');
		$('#ticket_count').val('0');
		$('#ticket_delivery_date').val(getDateFormatted(new Date()));
		$('#ticket_delivery_hour').val('1');
		$('#ticket_delivery_min').val('0');
		$('#ticket_category').val(1);
		setShowTicketCategoryETCInput(false);
		/*
		$('#ticket_price').val('0');
		$('#ticket_real_count').val('0');
		$('#ticket_reward').val('');
		$('#ticket_question').val('');
		$('#ticket_require_shipping').removeAttr('checked');
		$('#ticket_audiences_limit').val('0');
		$('#ticket_delivery_date').val(getDateFormatted(new Date()));
		*/
	};

	var getDateFormatted = function(date) {
	    var dd = date.getDate();
	    var mm = date.getMonth() + 1;
	    var yyyy = date.getFullYear();
	    if(dd < 10) {
	        dd = '0' + dd;
	    }
	    if(mm < 10) {
	        mm = '0' + mm;
	    }
	    return yyyy + '-' + mm + '-' + dd;
	};

	var addTicketRow = function(ticket) {
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

		var template = $('#template_ticket').html();
		var compiled = _.template(template);
		var row = compiled({ 'ticket': ticket, 'type': $('#project_saleType').val(), 'style': 'modifyable',  'ticketCategory': ticketCategoryTemp});
		var $row = $($.parseHTML(row));
		$row.data('ticketData', ticket);
		$('#ticket_list').append($row);

		//$("#ticket_list").tsort();

		$row.find('.modify-ticket').bind('click', modifyTicket);
		$row.find('.delete-ticket').bind('click', deleteTicket);
	};

	var modifyTicket = function() {
		setCreateTicketButtonShown(false);

		var ticket = $(this).closest('.ticket');
		var ticketData = ticket.data('ticketData');
		var rawDate = ticketData.show_date.split(" ");
		var d = rawDate[0].split("-");
		var t = rawDate[1].split(":");

		var showDate = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);

		var isPlace = $('#isPlace').val();
		if(isPlace == 'FALSE'){
			showDate.setFullYear(0000);
		}

		//alert(showDate);

		$('#ticket_price').val(ticketData.price);
		$('#ticket_count').val(ticketData.audiences_limit);
		$('#ticket_delivery_date').val(getDateFormatted(showDate));
		$('#ticket_delivery_hour').val(showDate.getHours());
		$('#ticket_delivery_min').val(showDate.getMinutes());

		var ticketCategoryTemp = ticket_category_etc['ticket_category_etc'];
		setShowTicketCategoryETCInput(true);
		$('#ticket_category_etc_input').val(ticketData.category);
		if(ticketsCategory.length > 0){
			var categoryNum = Number(ticketData.category);
			for (var i = 0; i < ticketsCategory.length; i++) {
				if(Number(ticketsCategory[i].id) === categoryNum){
					ticketCategoryTemp = categoryNum;
					setShowTicketCategoryETCInput(false);
					break;
				}
			}
		}

		$('#ticket_category').val(ticketCategoryTemp);

		$('#update_ticket').attr('data-ticket-id', ticket.attr('data-ticket-id'));
	};

	var cancelModifyTicket = function() {
		setCreateTicketButtonShown(true);
		clearTicketForm();
	};

	var setCreateTicketButtonShown = function(shown) {
		if (shown) {
			$('#create_ticket').show();
			$('#update_ticket, #cancel_modify_ticket').hide();
		} else {
			$('#create_ticket').hide();
			$('#update_ticket, #cancel_modify_ticket').show();
		}
	};

	var updateTicket = function() {
		var ticketId = $(this).attr('data-ticket-id');
		var url = '/tickets/' + ticketId;
		var method = 'put';
		var data = getTicketFormData();

		if (validateTicketData(data)) {
			var success = function(result) {
				var ticket = $('.ticket[data-ticket-id=' + ticketId + ']');
				ticket.remove();
				addTicketRow(result);
				cancelModifyTicket();
			};
			var error = function(request) {
				alert('수정에 실패하였습니다.');
			};

			$.ajax({
				'url': url,
				'method': method,
				'data': data,
				'success': success,
				'error': error
			});
		}
	};

	var deleteTicket = function() {
		var ticket = $(this).closest('.ticket');
		var ticketId = ticket.attr('data-ticket-id');
		var url = '/tickets/' + ticketId;
		var method = 'delete';

		var success = function(result) {
			ticket.remove();
			checkNoTicket();
		};
		var error = function(request) {
			alert('삭제에 실패하였습니다.');
		};

		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
	};

	var onDescriptionChanged = function() {
		var description = $('#poster_description').val();
		$('.project-description').text(description);
	};

	var updateStory = function(isNext) {
		loadingProcess($(".project_form_button_wrapper"));

		var markupStr = $('#summernote').summernote('code');
		updateProject({
			'story': markupStr
		}, isNext);
	};

	var submitProject = function() {
		swal("제출하시겠습니까?", "제출후에는 프로젝트 수정이 불가능합니다.", "info", {
						  buttons: {
						    save: {
						      text: "예",
						      value: "save",
						    },
								nosave: {
						      text: "아니오",
						      value: "notsave",
						    },

						  },
						})
						.then(function(value){
							switch (value) {
						    case "save":
								{
									var projectId = $('#project_id').val();
									var url = '/projects/' + projectId + '/submit';
									var method = 'put';
									var success = function(result) {
										//alert('제출 성공');
										swal("제출 성공!", {
										  buttons: {
										    save: {
										      text: "확인",
										      value: "save",
										    },
										  },

											icon: "success",
										}).then(function(value){
											location.reload();
										});

									};
									var error = function(request, status) {
										//alert('제출에 실패하였습니다.');
										loadingProcessStop($("#submit_project"));
										swal("제출에 실패하였습니다.", "", "error");
									};

									//submit_project
									loadingProcess($("#submit_project"));

									$.ajax({
										'url': url,
										'method': method,
										'success': success,
										'error': error
									});
								}
						    break;
						  }
						});
		/*
		if (window.confirm('정말 제출하시겠습니까?')) {
			var projectId = $('#project_id').val();
			var url = '/projects/' + projectId + '/submit';
			var method = 'put';
			var success = function(result) {
				alert('제출 성공');
			};
			var error = function(request, status) {
				alert('제출에 실패하였습니다.');
			};

			$.ajax({
				'url': url,
				'method': method,
				'success': success,
				'error': error
			});
		}
		*/
	};

	//form_body_required
	var updateRequired = function(isNext){
		//유효성 체크
		if(requiredVaildCheck() == true){
			loadingProcess($('.project_form_button_wrapper'));
			updateProject({
				'type': $('#saleType').val(),
				'project_type': $('#projectType').val(),
				//'temporary_date': temporary_date,
				'isPlace' : $('#isPlace').val(),
				'project_target': $('#project_target').val()
			}, isNext);
		}
	};

	var setShowTicketCategoryETCInput = function(shown) {
		if (shown) {
			$('#ticket_category_etc_input').show();
		} else {
			$('#ticket_category_etc_input').hide();
			$('#ticket_category_etc_input').val('');
		}
	};

//티켓 공지 세이브
	var ticketNoticeSave = function(){
		var ticketNotice = $('#ticket_notice_textarea').val();

		updateProject({
			'ticket_notice': ticketNotice
		}, false);
	};

	//Discount start
	var createDiscount = function(){
		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId + '/discounts';

		var method = 'post';
		var data = getDiscountFormData();
		//alert(url);
		//alert(JSON.stringify(data));
		if (validateDiscountData(data)) {
			var success = function(result) {
				addDiscountRow(result);
				checkNoDiscount();
			};
			var error = function(request) {
				alert('할인 정보 추가에 실패하였습니다.');
			};

			$.ajax({
				'url': url,
				'method': method,
				'data': data,
				'success': success,
				'error': error
			});
		}
	};

	var getDiscountFormData = function(){
		return {
			//'price': $('#discount_content_input').val()
			'percent_value': $('#discount_percent_value_input').val(),
			'content': $('#discount_content_input').val(),
			'submit_check': $('#discount_submit_input').val()
		};
	};

	var validateDiscountData = function(ticket) {
		return true;
		/*
		if (ticket.reward.length === 0) {
			alert("내용을 입력해주세요");
			return false;
		}
		return true;
		*/
	};

	var listOldDiscounts = function(){
		var discountsJson = $('#discounts_json').val();
		if (discountsJson) {
			var discounts = $.parseJSON(discountsJson);
			if (discounts.length > 0) {
				setHaveDiscountText(true);
				for (var i = 0, l = discounts.length; i < l; i++) {
					addDiscountRow(discounts[i]);
				}
			}
			else
			{
				setHaveDiscountText(false);
			}
		}
	};

	var addDiscountRow = function(discount) {

		var templateDiscount = $('#template_discount').html();
		var compiled = _.template(templateDiscount);
		var row = compiled({ 'discount': discount });
		var $row = $($.parseHTML(row));
		$row.data('discountData', discount);
		$('#discount_list').append($row);

		$row.find('.modify-discount').bind('click', modifyDiscount);
		$row.find('.delete-discount').bind('click', deleteDiscount);
	};

	var modifyDiscount = function() {
		setCreateDiscountButtonShown(false);

		var discount = $(this).closest('.discount');
		var discountData = discount.data('discountData');

		$('#discount_percent_value_input').val(discountData.percent_value);
		$('#discount_content_input').val(discountData.content);

		$('#discount_limite_input').val(discountData.limite_count);
		$('#discount_submit_input').val(discountData.submit_check);

		$('#update_discount').attr('data-discount-id', discount.attr('data-discount-id'));
	};

	var setCreateDiscountButtonShown = function(shown) {
		if (shown) {
			$('#create_discount').show();
			$('#update_discount, #cancel_modify_discount').hide();
		} else {
			$('#create_discount').hide();
			$('#update_discount, #cancel_modify_discount').show();
		}
	};

	var deleteDiscount = function() {
		var discount = $(this).closest('.discount');
		var discountId = discount.attr('data-discount-id');
		var url = '/discounts/' + discountId;
		var method = 'delete';

		var success = function(result) {
			discount.remove();
			checkNoDiscount();
		};
		var error = function(request) {
			alert('삭제에 실패하였습니다.');
		};

		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
	};

	var updateDiscount = function() {
		var discountId = $(this).attr('data-discount-id');
		var url = '/discounts/' + discountId;
		var method = 'put';
		var data = getDiscountFormData();

		if (validateDiscountData(data)) {
			var success = function(result) {
				var discount = $('.discount[data-discount-id=' + discountId + ']');
				discount.remove();
				addDiscountRow(result);
				cancelModifyDiscount();
			};
			var error = function(request) {
				alert('수정에 실패하였습니다.');
			};

			$.ajax({
				'url': url,
				'method': method,
				'data': data,
				'success': success,
				'error': error
			});
		}
	};

	var cancelModifyDiscount = function() {
		setCreateDiscountButtonShown(true);
		clearDiscountForm();
	};

	var clearDiscountForm = function() {
		$('#discount_percent_value_input').val('');
		$('#discount_content_input').val('');

		$('#discount_limite_input').val('');
		$('#discount_submit_input').val('');
	};
	//Discount end

	//goods START
	var createGoods = function(){
		var goodsPrice = $('#goods_price_input').val();
		if(goodsPrice < 0)
		{
			swal("굿즈 가격 오류", "", "error");

			return false;
		}

		$('#updatebutton').val('');

		$('#goods_form').submit();
	};

	var updateGoods_btn = function(){
		var goodsPrice = $('#goods_price_input').val();
		if(goodsPrice < 0)
		{
			swal("굿즈 가격 오류", "", "error");

			return false;
		}

		$('#updatebutton').val('TRUE');

		$('#goods_form').submit();
	};

	var getGoodsFormData = function(){
		return {
			//'price': $('#discount_content_input').val()
			'price': $('#goods_price_input').val(),
			'title': $('#goods_title_input').val(),
			'content': $('#goods_content_input').val(),
			'img_url': $('#goods_img_file').val()
			//'img_url': ''
		};
	};

	var performGoodsFileClick = function() {
		$('#goods_img_file').trigger('click');
	};

	var onGoodsImgChanged = function() {
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				setGoodsImgPreview(e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	};

	var validateGoodsData = function(data){
		return true;
	}

	var goodsAjaxOption = {
		'beforeSerialize': function($form, options) {
			$goods_img_file = $('#goods_img_file');

		},
		'success': function(result) {
			if(result['goodsState'] === 'updategoods') {
				updateGoods(result['goods'], result['goodsList']);
				clearGoodsForm();
			}
			else {
				addGoodsRow(result['goods']);
				goodsImgResize();
				clearGoodsForm();
			}
		},
		'error': function(data) {
			alert("저장에 실패하였습니다.");
		}
	};

	var listOldGoods = function(){
		var goodsJson = $('#goods_json').val();
		if (goodsJson) {
			var goods = $.parseJSON(goodsJson);
			if (goods.length > 0) {
				for (var i = 0, l = goods.length; i < l; i++) {
					addGoodsRow(goods[i]);
				}

				goodsImgResize();
			}
		}
	};

	var addGoodsRow = function(goods){
		var lineItemMax = 3;
		var containerClassName = '.goodsListContainer';
		var goodsList = $('#goods_list');

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
		$('#goodsList_'+newListContainerCount).append($rowGoodsItem)

		$rowGoodsItem.find('.modify-goods').bind('click', modifyGoods);
		$rowGoodsItem.find('.delete-goods').bind('click', deleteGoods);
	};

	var modifyGoods = function() {
		setCreateGoodsButtonShown(false);

		var goods = $(this).closest('.goods-item');
		var goodsData = goods.data('goodsData');

		$('#goods_title_input').val(goodsData.title);
		$('#goods_price_input').val(goodsData.price);
		$('#goods_content_input').val(goodsData.content);

		setGoodsImgPreview(goodsData.img_url);
		$('#goodsId').val(goodsData.id);

		$('#ticket_discount_input').val(goodsData.ticket_discount);

		$('#update_goods').attr('data-goods-id', goods.attr('data-goods-id'));
	};

	var goodsImgResize = function(){

	};

	var updateGoods = function(goods, resultlist) {
		var goodsItem = $('.goods-item[data-goods-id=' + goods.id + ']');

		var goodsParents = goodsItem.parents();

		goodsItem.remove();

		goodsListRefresh(goodsParents, resultlist);
		//goodsItem.remove();
		//addGoodsRow(goods);
		cancelModifyGoods();
	};

	var deleteGoods = function() {
		var goods = $(this).closest('.goods-item');
		var goodsId = goods.attr('data-goods-id');
		var url = '/goods/' + goodsId;
		var method = 'delete';

		var success = function(result) {
			var goodsParents = goods.parents();

			goods.remove();

			goodsListRefresh(goodsParents, result);
			//alert(JSON.stringify(result));
			//삭제 후 라인이 비어있는지 체크해서 라인까지 삭제 해준다.

		};
		var error = function(request) {
			alert('삭제에 실패하였습니다.');
		};

		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
	};

	var setGoodsImgPreview = function(url){
		if(url)
		{
			$('#goods_file_sub').show();

			//$('#goods_img_preview').show();
			$('.goods_img_preview_wrapper').show();
			$('#goods_img_preview').attr("src", url);

			//$('#goods_img_preview').css('background-image', "url('" + url + "')");
		}
		else
		{
			$('#goods_file_sub').hide();

			$('.goods_img_preview_wrapper').hide();
			$('#goods_img_preview').attr("src", "");
			//$('#goods_img_preview').hide();
			//$('#goods_img_preview').css('background-image', "");
		}
	};

	$('#goods_file_sub').click(function(){
		setGoodsImgPreview('');

		if ($.browser.msie)
		{
	 		// ie 일때 input[type=file] init.
			$("#goods_img_file").replaceWith( $("#goods_img_file").clone(true) );
		}
		else
		{
			// other browser 일때 input[type=file] init.
			$("#goods_img_file").val("");
		}
	});

	var goodsListRefresh =  function(goodsParents, goodsListJson) {
		//다 지우고 다시 재정렬 한다.
		var goodsListDom = $('#goods_list');

		goodsListDom.children().remove();

		if (goodsListJson.length > 0) {
			for (var i = 0, l = goodsListJson.length; i < l; i++) {
				addGoodsRow(goodsListJson[i]);
			}

			goodsImgResize();
		}
	};

	var setCreateGoodsButtonShown = function(shown) {
		if (shown) {
			$('#create_goods').show();
			$('#update_goods, #cancel_modify_goods').hide();
		} else {
			$('#create_goods').hide();
			$('#update_goods, #cancel_modify_goods').show();
		}
	};

	var cancelModifyGoods = function(){
		setCreateGoodsButtonShown(true);
		clearGoodsForm();
	};

	var clearGoodsForm = function(){
		$('#goods_title_input').val('');
		$('#goods_price_input').val('');
		$('#goods_content_input').val('');
		$('#goodsId').val('');
		$('#ticket_discount_input').val(0);

		//$('#goods_img_preview').css('background-image', "url('" + $('#default_img').val() + "')");
		setGoodsImgPreview('');
	};
	//goods end

	var updatePoster = function(isNext){
		if(isNext)
		{
			$('#poster_form').attr('data-poster-form-next-save', "TRUE");
		}
		else {
			$('#poster_form').attr('data-poster-form-next-save', "FALSE");
		}

		loadingProcess($('.project_form_button_wrapper'));
		$('#poster_form').submit();
	};

	var nextCheck = function(){
		var selected_tab = $('#selected_tab').val();

		if(selected_tab == 'ticket'){
				//티켓일땐 바로 넥스트. 굿즈 정보 갔을때 다음 누르면 여길 탄다
				//nextTabSelect();
				swal("다음으로 가시겠습니까?", {
								  buttons: {
										nosave: {
								      text: "아니오",
								      value: "notsave",
								    },
										save: {
								      text: "예",
								      value: "save",
								    },
								  },
								})
								.then(function(value){
									switch (value) {
								    case "save":
										{
											nextTabSelect();
										}
								    break;
								  }
								});

				return;
		}

		swal("저장 후 다음으로 가시겠습니까?", {
						  buttons: {
								nosave: {
						      text: "저장하지 않음",
						      value: "notsave",
						    },
						    save: {
						      text: "예",
						      value: "save",
						    },
						  },
						})
						.then(function(value){
							switch (value) {
						    case "save":
								{
									if(selected_tab == 'required')
									{
										updateRequired(true);
									}
									else if(selected_tab == 'base')
									{
										updateDefault(true);
									}
									else if(selected_tab == 'poster')
									{
										updatePoster(true);
									}
									else if(selected_tab == 'story')
									{
										updateStory(true);
									}
								}
						    break;

								case "notsave":
								{
									nextTabSelect();
								}
								break;
						  }
						});
	};

	var nextTabSelect = function(){
		loadingProcess($('.project_form_button_wrapper'));

		var selectTab = $('#selected_tab').val();

		var tabInfoJson = $('#tabInfoJson').val();
		var tabInfoList = $.parseJSON(tabInfoJson);

		var nextTabIndex = 0;
		for(var i = 0 ; i < tabInfoList.length ; i++)
		{
			var index = i;
			if(tabInfoList[i].key == selectTab)
			{
				index++;
				if(index >= tabInfoList.length)
				{
					index = 0;
				}

				nextTabIndex = index;

				break;
			}
		}

		var nextTabKey = tabInfoList[nextTabIndex].key;

		tabSelect(nextTabKey);
	};

	var ticketNext = function(){
		var nextIdx = 0;
		$('.project_form_ticket_tab').each(function(index, element){
			if($(element).hasClass("active") == true)
			{
				nextIdx = index + 1;
			}
		});


		$('.project_form_ticket_tab').each(function(index, element){
			if(nextIdx == index)
			{
				var tabhrefName = $(element).children().attr('href');
				$('a[href='+ tabhrefName +']').click();
			}
		});
	};


	$('#check_alias').bind('click', checkAliasDuplicate);
	$('#update_default').bind('click', updateDefault);
	$('#funding_closing_at').datepicker({'dateFormat': 'yy-mm-dd'});
	$('#sale_start_at').datepicker({'dateFormat': 'yy-mm-dd'});
	$('#create_ticket').bind('click', createTicket);
	$('#update_ticket').bind('click', updateTicket);
	$('#cancel_modify_ticket').bind('click', cancelModifyTicket);
	$('#ticket_delivery_date').datepicker({'dateFormat': 'yy-mm-dd'});

	//$('#update_story').bind('click', updateStory);
	$('#update_story').bind('click', function(){
		updateStory(false);
	});
	$('#submit_project').bind('click', submitProject);

	$('#poster_description').bind('input', onDescriptionChanged);

	//분류 탭 저장 form_body_required
	//$('#update_required').bind('click', updateRequired);
	$('#update_required').click(function(){
		updateRequired(false);
	});

	$('#update_and_next').bind('click', nextCheck);
	//티켓공지 저장
	$('#ticket_notice_save').bind('click', ticketNoticeSave)

	//Discount
	$('#create_discount').bind('click', createDiscount)
	$('#cancel_modify_discount').bind('click', cancelModifyDiscount);
	$('#update_discount').bind('click', updateDiscount);

	//Goods
	$('#create_goods').bind('click', createGoods)
	$('#cancel_modify_goods').bind('click', cancelModifyGoods);
	$('#update_goods').bind('click', updateGoods_btn);

	$('#goods_form').ajaxForm(goodsAjaxOption);

	$('#goods_file_fake').bind('click', performGoodsFileClick);
	$('#goods_img_file').change(onGoodsImgChanged);

	//poster
	//$('#update_poster').bind('click', updatePoster);
	$('#update_poster').click(function(){
		updatePoster(false);
	});

	//$('.ticket_go_next').bind('click', ticketNext);
	$('.ticket_go_next').bind('click', function(){
		swal("다음으로 가시겠습니까?", {
						  buttons: {
								nosave: {
						      text: "아니오",
						      value: "notsave",
						    },
						    save: {
						      text: "예",
						      value: "save",
						    },
						  },
						})
						.then(function(value){
							switch (value) {
						    case "save":
								{
									ticketNext();
								}
						    break;
						  }
						});
	});

	var setSaleStartTime = function(){
		var saleTimeCheck = $('#sale_start_checkbox').is(':checked');
		var saleStartTimeWrapperEle = $('#project_sale_select_time_wrapper');
		if(saleTimeCheck == true)
		{
			saleStartTimeWrapperEle.hide();
		}
		else
		{
			saleStartTimeWrapperEle.show();
		}
	};

	//판매 시작 시간 설정
	var initSaleStartTime = function(){
		var saleStartValue = $('#sale_start_at').val();
		var saleCheckBox = $('#sale_start_checkbox');

		if(saleStartValue)
		{
			//티켓팅 시작 시간이 있다.
			saleCheckBox.attr("checked", false);
		}
		else
		{
			//즉시 오픈
			saleCheckBox.attr("checked", true);
		}

		setSaleStartTime();
	};

	initSaleStartTime();

	$('#sale_start_checkbox').click(function(){
		setSaleStartTime();
	});

	var getSaleStartTime = function(){
		var saleTimeCheck = $('#sale_start_checkbox').is(':checked');
		if(saleTimeCheck)
		{
			return '';
		}

		var saleStartDay = $('#sale_start_at').val();
		var saleStartHour = $('#sale_start_hour').val();
		if (saleStartHour < 10) {
			saleStartHour = "0" + saleStartHour;
		}

		var saleStartTime = saleStartDay + " " + saleStartHour + ":" + "00:00";

		return saleStartTime;
	};

	var getPickClosingDay = function(){
		if(!$("#isPickType").val())
		{
			return '';
		}

		return $("#pickday_select").attr("pick-closing-at");
	};

	var performPosterTitleFileClick = function(){
		var imgNumber = $(this).attr('data-img-number');
		$('#title_img_file_'+imgNumber).trigger('click');
	};

	var onPosterTitleChanged = function(){

		if (this.files && this.files[0]) {
			var imgNumber = $(this).attr('data-img-number');
			var posterId = $(this).attr('data-poster-id');
			if(isFileCheck(this) == true)
			{
				var reader = new FileReader();
				reader.onload = function(e) {
					setPosterTitleImg(imgNumber, e.target.result, posterId, true);
				};
				reader.readAsDataURL(this.files[0]);
			}
			else
			{
				//용량 초과시 이미지 지우()
				deleteTitlePosterImg(imgNumber, posterId);
			}
		}
	};

	var performPosterFileClick = function() {
		$('#poster_img_file').trigger('click');
	};

	var onPosterChanged = function() {
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#poster_img_preview').css('background-image', "url('" + e.target.result + "')");
				setPosterDeleteBtn(true);
			};
			reader.readAsDataURL(this.files[0]);
		}
	};

	var posterAjaxOption = {
		'beforeSerialize': function($form, options) {
		},
		'success': function(result) {

			var isNext = $('#poster_form').attr('data-poster-form-next-save');

			loadingProcessStop($('.project_form_button_wrapper'));

			swal("저장되었습니다", {
							  buttons: {
							    save: {
							      text: "확인",
							      value: "save",
							    },
							  },

								icon: "success",
							})
							.then(function(value){
								if(isNext == "TRUE")
								{
									nextTabSelect();
								}
							});

/*
			swal("저장되었습니다", {
							  buttons: {
							    save: {
							      text: "확인",
							      value: "save",
							    },
							  },

								icon: "success",
							})
							.then((value) => {
								if(isNext == "TRUE")
								{
									nextTabSelect();
								}
							});
							*/
		},
		'error': function(data) {
			loadingProcessStop($('.project_form_button_wrapper'));

			swal("저장에 실패하였습니다.", '', 'error');
		}
	};

	var listOldPosters = function(){
		var postersJson = $('#posters_json').val();
		if (postersJson) {
			var posters = $.parseJSON(postersJson);

			$('.title_img_preview').each(function(index, item){
				var fileNumber = index + 1;
				var titleFileName = 'title_img_file_'+fileNumber;

				setPosterTitleImg(fileNumber, posters[titleFileName].img_url, posters['id'], posters[titleFileName].isFile);
			});
		}
	};

	var setPosterTitleImg = function(titleFileNumber, imgUrl, posterId, isFile){
		//alert(titleFileNumber + " / "+ posterId);
		var posterTitleId = '#title_img_preview_'+titleFileNumber;
		var posterAddBtn = '#title_img_file_fake_'+titleFileNumber;

		if(isFile == true)
		{
			$(posterTitleId).show();
			$(posterTitleId).attr('src', imgUrl);

			$(posterAddBtn).hide();

			if(titleFileNumber == 1)
			{
				//첫번째 이미지면 미리보기에 바로 셋팅 해준다.
				var viewer = $('.project-img').eq(0);
				if(viewer)
				{
					viewer.attr('src', imgUrl);
				}
			}
		}
		else
		{
			$(posterTitleId).hide();
			$(posterTitleId).attr('src', '');
			//$(posterTitleId)[0].width = 0;
			//$(posterTitleId)[0].height = 0;

			$(posterAddBtn).show();

			if(titleFileNumber == 1)
			{
				//첫번째 이미지면 미리보기에 바로 셋팅 해준다.
				var viewer = $('.project-img').eq(0);
				if(viewer)
				{
					viewer.attr('src', $("#viewerDefaultImgURL").val());
				}
			}
		}

		setPosterTitleDeleteBtn(isFile, titleFileNumber);
	};

	var setPosterIdTitleDeleteBtn = function(titleFileNumber, posterId){
		//var deleteBtnId = '#title_img_file_sub_'+titleFileNumber;
		//$(deleteBtnId).attr('data-poster-id', posterId);
	}

	var setPosterIdDeleteBtn = function(posterId){
		$('#delete-poster-img').attr('data-poster-id', posterId);
		//$(deleteBtnId).attr('data-poster-id', posterId);
	}

	var setPosterTitleDeleteBtn = function(isShow, btnNum){
		var deleteBtnid = '#title_img_file_sub_'+btnNum;
		if (isShow) {
			$(deleteBtnid).show();
		} else {
			$(deleteBtnid).hide();
		}
	};

	var setPosterDeleteBtn = function(isShow){
		var deleteBtnid = '#delete-poster-img';
		if (isShow) {
			$(deleteBtnid).show();
		} else {
			$(deleteBtnid).hide();
		}
	};

	var deletePosterTitle = function(){
		var posterId = $(this).attr('data-poster-id');
		var imgNum = $(this).attr('data-img-number');
		var url = '/posters/title/' + posterId + '/' + imgNum;
		var method = 'delete';

		var success = function(result) {
			deleteTitlePosterImg(result, posterId);
			swal("삭제 성공!", "", "success");
		};
		var error = function(request) {
			swal("삭제 실패", "", "error");
		};

		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
	};

	var deletePoster = function(){
		var posterId = $(this).attr('data-poster-id');
		var url = '/posters/poster/' + posterId;
		var method = 'delete';

		var success = function(result) {
			alert("삭제 성공하였습니다." + JSON.stringify(result));
			deletePosterImg();
		};
		var error = function(request) {
			alert('삭제에 실패하였습니다.');
		};

		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
	};

	var deleteTitlePosterImg = function(imgNum, posterId){
		setPosterTitleImg(imgNum, '', posterId, false);

		var title_img_file_name = '#title_img_file_'+imgNum;
		if ($.browser.msie)
		{
	 		// ie 일때 input[type=file] init.
			$(title_img_file_name).replaceWith( $("#goods_img_file").clone(true) );
		}
		else
		{
			// other browser 일때 input[type=file] init.
			$(title_img_file_name).val("");
		}
	}

	var deletePosterImg = function(){
		$('#poster_img_preview').css('background-image', "url('" + $('#default_img').val() + "')");
		$('#poster_img_file').val('');

		setPosterDeleteBtn(false);
	}

	$('.title_img_file_fake').each(function(){
		$(this).bind('click', performPosterTitleFileClick);
	});

	$('.title_img_file').each(function(){
		$(this).change(onPosterTitleChanged);
	});

	$('.project_form_poster_trash').each(function(){
		$(this).bind('click', deletePosterTitle);
	});

	$('#poster_file_fake').bind('click', performPosterFileClick);
	$('#poster_img_file').change(onPosterChanged);
	$('#delete-poster-img').bind('click', deletePoster);

	$('#poster_form').ajaxForm(posterAjaxOption);

	//개설자 소개 start
	var saveCreator = function(){
		if(isCheckPhoneNumber($('#contact').val()) == false)
		{
			return;
		}

		if(isCheckEmail($('#email').val()) == false)
		{
			return;
		}

		if(!$('#bank').val()){
			swal("은행 정보를 입력해주세요.(필수입력)", "", "warning");
			return;
		}

		if(!$('#account').val()){
			swal("계좌 정보를 입력해주세요.(필수입력)", "", "warning");
			return;
		}

		if(!$('#account_holder').val()){
			swal("예금주 정보를 입력해주세요.(필수입력)", "", "warning");
			return;
		}

		var calcul_notice = $('#calcul_notice_check').is(':checked');
		if(calcul_notice == false)
		{
			swal('유의사항을 읽고 체크 해주세요.', '', 'warning');
			return;
		}
		//calcul_notice_check

		$('#creator_form').submit();
	};

	var listOldChannel = function() {
		var channelCount = 0;
		var channelJson = $('#channels_json').val();
		if (channelJson) {
			var channels = $.parseJSON(channelJson);
			channelCount = channels.length;
			if (channels.length > 0) {
				for (var i = 0, l = channels.length; i < l; i++) {
					addChannelRow(channels, i);
				}
			}
		}

		if(channelCount == 0)
		{
			addChannelRow('', 0);
		}

		setChannelAddBtn();
	};

	var reListChannel = function(){
		//채널정보 재정렬
		//기존 데이터 세이브
		var channelTempArray = new Array();

		$('.channel').each(function(index){
			var data = $(this).data('channelData');
			var channelURL = $(this).children().children('.channel_category_url_input').val();
			var channelCategory = $(this).children().children('.channel_category').val();

			if(data)
			{
				var channelObject = new Object();

				channelObject.data = data;
				channelObject.selectCategoryId = channelCategory;
				channelObject.url = channelURL;

				channelTempArray.push(channelObject);
			}
		});


		$('#channel_list').children().remove();

		var channelDataTempArray = new Array();
		for(var i = 0 ; i < channelTempArray.length ; i++)
		{
			channelDataTempArray.push(channelTempArray[i].data);
		}

		for(var i = 0 ; i < channelTempArray.length ; i++)
		{
			addChannelRow(channelDataTempArray, i);

			$('#channel_category'+i).val(channelTempArray[i].selectCategoryId);
			$('#channel_category_url_input'+i).val(channelTempArray[i].url);
		}

		if(channelTempArray.length == 0)
		{
			addChannelRow('', 0);
		}

		setChannelAddBtn();
	};

	var addChannelRow = function(channels, index) {
		//var channelListSize = $('#channel_list').children().size();
		var channelCount = 1;
		$('.channel').each(function(){
			channelCount++;
		});

		if(channelCount > 6){
			swal('최대 6개 입니다.', '', 'error');
			return;
		}

		var channel = '';
		var isFake = '';
		if(channels == '')
		{
			channel = {
									"id" : "",
									"isFake" : "true",
									"categories_channel_id" : "1",
									"url" : "http://"
								};
		}
		else{
			channel = channels[index]
		}

		channel['index'] = index;
		channel['isFake'] = isFake;

		var templateChannel = $('#template_channel').html();
		var compiled = _.template(templateChannel);
		var row = compiled({ 'channel': channel, 'index' : index });
		var $row = $($.parseHTML(row));

		$row.data('channelData', channel);
		$('#channel_list').append($row);

		//카테고리 옵션 변경
		$('#channel_category'+index).val(channel.categories_channel_id).prop("selected", true);

		$row.find('.add-channel').bind('click', addChannelFakeRow);
		$row.find('.delete-channel').bind('click', deleteChannel);
	};

	var addChannelFakeRow = function(){
		var channelListSize = $('#channel_list').children().size();

		addChannelRow('', channelListSize);
		setChannelAddBtn();
	}

	var setChannelAddBtn = function(){
		var channelListSize = $('#channel_list').children().size();
		$( ".channel" ).each(function( index, element ) {

			var addChannelBtn = $("#add-channel"+index);
			var deleteChannelBtn = $("#delete-channel"+index);

			addChannelBtn.hide();

			if(index == channelListSize-1) {
				addChannelBtn.show();
				//alert('last' + index);
				//deleteChannelBtn.hide();
			}
  	});
	};

	//채널input에 채널id 값 갱신;
	var updateChannelID = function(channels){
		$.each(channels,function(key,value) {
			$("input[name="+key+"]").val(value);
			//console.error('key : ' + key + 'value : ' + value);
		});
	};

	var deleteChannel = function() {
		var channel = $(this).closest('.channel');
		var channelId = channel.attr('data-channel-id');
		if(channelId == '')
		{
			//채널아이디가 없으면 서버에 저장되지 않은 페이크 정보
			channel.remove();

			reListChannel();
			return;
		}

		var url = '/channels/' + channelId;
		var method = 'delete';

		var success = function(result) {
			channel.remove();
			reListChannel();
			swal('채널 제거 성공!', '', 'success');
		};
		var error = function(request) {
			alert('삭제에 실패하였습니다.');
		};

		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
	};

	var performProfileFileClick = function(){
		$('#input-user-photo').trigger('click');
	};

	var onProfileChanged = function(){
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#user-photo').show();
				$('#user-default-photo').hide();
				$('#isdeletephoto').val('');
				$('#user-photo').css('background-image', "url('" + e.target.result + "')");
			};
			reader.readAsDataURL(this.files[0]);
		}
	};

	var profileAjaxOption = {
		'beforeSerialize': function($form, options) {
		},
		'success': function(result) {
			var resultJson = $.parseJSON(result);
			updateChannelID(resultJson);
			//alert('저장되었습니다.' + JSON.stringify(result));
			swal("저장되었습니다.! 상단의 제출하기를 눌러주세요!", '', 'success');

		},
		'error': function(data) {
			alert("저장에 실패하였습니다.");
		}
	};

	var deleteProfileFile = function(){
		if ($.browser.msie)
		{
	 		// ie 일때 input[type=file] init.
			$("#input-user-photo").replaceWith( $("#input-user-photo").clone(true) );
		}
		else
		{
			// other browser 일때 input[type=file] init.
			$("#input-user-photo").val("");
		}

		$('#isdeletephoto').val('TRUE');
		$('#user-photo').hide();
		$('#user-default-photo').show();
	};

	$('#save_creator').bind('click', saveCreator);
	$('#profile-upload-photo-fake').bind('click', performProfileFileClick);
	$('#input-user-photo').change(onProfileChanged);
	$('#creator_form').ajaxForm(profileAjaxOption);

	$('#profile-delete-photo').bind('click', deleteProfileFile);
	//개설자 소개 end

	setShowTicketCategoryETCInput(false);

	$('#ticket_category').on('change', function(type){
		if(Number($(this).val()) === ticket_category_etc['ticket_category_etc']){
			setShowTicketCategoryETCInput(true);
		}
		else{
			setShowTicketCategoryETCInput(false);
		}
	});

	setCreateTicketButtonShown(true);
	setCreateDiscountButtonShown(true);
	setCreateGoodsButtonShown(true);

	listOldTickets();
	listOldDiscounts();
	listOldGoods();
	listOldPosters();
	listOldChannel();

	//test//
	//reListChannel();

	$(window).bind('beforeunload', function() {
		// return '페이지를 나가기 전에 저장되지 않은 정보를 확인하세요';
	});

	/////////////ticket_ticket/////////////
	$('#discount_checkbox').click(function(){
		if($('#discount_checkbox').is(':checked') == true)
		{
			$('#isDiscount').val("FALSE");
		}
		else
		{
			$('#isDiscount').val("TRUE");
		}

		if($('#isDiscount').val() == "TRUE")
		{
			sendNoDiscount();
			return;
		}

		if($('#discount_list').children().size() > 0)
		{
			//discount개수가 0보다 크면 경고창을 띄운다.
			swal("할인정보가 모두 지워집니다. 계속 하시겠습니까?", {
								buttons: {
									cancel: "취소",
									catch: {
										text: "계속",
										value: "continue",
									},
								},

								icon: "warning",
							})
							.then(function(value){
								if(value == "continue")
								{
									sendNoDiscount();
								}
								else
								{
									$('#isDiscount').val("TRUE");
									setDiscountValue();
								}
							});

			/*
			swal("할인정보가 모두 지워집니다. 계속 하시겠습니까?", {
								buttons: {
									cancel: "취소",
									catch: {
										text: "계속",
										value: "continue",
									},
								},

								icon: "warning",
							})
							.then((value) => {
								if(value == "continue")
								{
									sendNoDiscount();
								}
								else
								{
									$('#isDiscount').val("TRUE");
									setDiscountValue();
								}
							});
							*/
		}
		else
		{
			sendNoDiscount();
		}
	});

	var setDiscountValue = function(){
		var isDiscount = $('#isDiscount').val();
		var discountCheckBox = $('#discount_checkbox');

		if(isDiscount == "TRUE")
		{
			discountCheckBox.attr("checked", false);
		}
		else
		{
			discountCheckBox.attr("checked", true);
		}

		setDiscountCheckBox();
	};

	var setDiscountCheckBox = function(){
		var discountCheck = $('#discount_checkbox').is(':checked');
		if(discountCheck == true)
		{
			//할인율 적용 안됨
			$('.project_form_discount_content_container').hide();
		}
		else
		{
			$('.project_form_discount_content_container').show();
		}
	};

	var sendNoDiscount = function(){
		var projectId = $('#project_id').val();
		var url = '/discounts/' + projectId + '/nodiscount';
		var method = 'post';
		var discountCheck = $('#isDiscount').val();

		var data = {'discountcheck': discountCheck};

		var success = function(e) {
			removeAllDiscountList();
			$('#isDiscount').val(e);
			setDiscountValue();
			//alert('저장되었습니다.');
		};
		var error = function(e) {
			alert('저장에 실패하였습니다.');
			setDiscountValue();
		};

		$.ajax({
			'url': url,
			'method': method,
			'data': data,
			'success': success,
			'error': error
		});
	};

	setDiscountValue();

	var removeAllDiscountList = function(){
		//var goodsList = $('#goods_list');
		$(".delete-discount").each(function(){
			$(this).trigger('click');
		});
	};
	//////////////ticket_ticket end////////

	//////////////ticket_goods////////////
	$('#goods_checkbox').click(function(){
		if($('#goods_checkbox').is(':checked') == true)
		{
			$('#isGoods').val("FALSE");
		}
		else
		{
			$('#isGoods').val("TRUE");
		}

		if($('#isGoods').val() == "TRUE")
		{
			sendNoGoods();
			return;
		}

		if($('#goods_list').children().size() > 0)
		{
			//discount개수가 0보다 크면 경고창을 띄운다.
			swal("굿즈정보가 모두 지워집니다. 계속 하시겠습니까?", {
								buttons: {
									cancel: "취소",
									catch: {
										text: "계속",
										value: "continue",
									},
								},

								icon: "warning",
							})
							.then(function(value){
								if(value == "continue")
								{
									sendNoGoods();
								}
								else
								{
									$('#isGoods').val("TRUE");
									setGoodsValue();
								}
							});

			/*
			swal("굿즈정보가 모두 지워집니다. 계속 하시겠습니까?", {
								buttons: {
									cancel: "취소",
									catch: {
										text: "계속",
										value: "continue",
									},
								},

								icon: "warning",
							})
							.then((value) => {
								if(value == "continue")
								{
									sendNoGoods();
								}
								else
								{
									$('#isGoods').val("TRUE");
									setGoodsValue();
								}
							});
							*/
		}
		else
		{
			sendNoGoods();
		}
	});

	var setGoodsValue = function(){
		var isGoods = $('#isGoods').val();
		var goodsCheckBox = $('#goods_checkbox');

		if(isGoods == "TRUE")
		{
			goodsCheckBox.attr("checked", false);
		}
		else
		{
			goodsCheckBox.attr("checked", true);
		}

		setGoodsCheckBox();
	};

	var setGoodsCheckBox = function(){
		var goodsCheck = $('#goods_checkbox').is(':checked');
		if(goodsCheck == true)
		{
			//할인율 적용 안됨
			$('.project_form_goods_content_container').hide();
		}
		else
		{
			$('.project_form_goods_content_container').show();
		}
	};

	var sendNoGoods = function(){
		var projectId = $('#project_id').val();
		var url = '/goods/' + projectId + '/nogoods';
		var method = 'post';
		var goodsCheck = $('#isGoods').val();

		var data = {'goodscheck': goodsCheck};

		var success = function(e) {
			removeAllGoodsList();

			$('#isGoods').val(e);
			setGoodsValue();
		};
		var error = function(e) {
			alert('저장에 실패하였습니다.');
			setGoodsValue();
		};

		$.ajax({
			'url': url,
			'method': method,
			'data': data,
			'success': success,
			'error': error
		});
	};

	setGoodsValue();

	var removeAllGoodsList = function(){
		//var goodsList = $('#goods_list');
		$(".delete-goods").each(function(){
			$(this).trigger('click');
		});
	};
	///////////////ticket_goods end///////

	//글자수제한걸기//
	//프로젝트 제목
	isWordLengthCheck($("#title"), $(".titleLength"));
	isWordLengthCheck($("#goods_content_input"), $(".goods_contentLength"));
	isWordLengthCheck($("#introduce"), $(".introduceLength"));
	//$("#introduce") 글자수 제한으로 리프레시
	$("#introduce").trigger('keyup');

	isWordLengthCheck($("#alias"), $(".aliasLength"));
	$("#alias").trigger('keyup');
});

//form_body_required START
$(document).ready(function() {
	var setProjectType = function(projectType){
		$('#projectType').val(projectType);
		setProjectTypeButton();
	};

	var setSaleType = function(saleType){
		$('#saleType').val(saleType);
		setSaleTypeButton();
	};

	var setIsPlace = function(isPlace){
		$('#isPlace').val(isPlace);
		setIsPlaceButton();
	};

	var setFundTarget = function(fundTarget){
		$('#project_target').val(fundTarget);
		setFundTargetButton();
	};

	var setProjectTypeButton = function(){
		var projectType = $('#projectType').val();
		if(projectType == 'artist'){
			//버튼
			$('#artistsButton').addClass('project-form-required-type-button-select');
			$('#creatorsButton').removeClass('project-form-required-type-button-select');
			$('#cultureButton').removeClass('project-form-required-type-button-select');
			//버튼텍스트
			$( ".project_form_button_text_artist" ).each(function(){
				$(this).addClass('project_form_button_select');
			});

			$( ".project_form_button_text_creator" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			$( ".project_form_button_text_culture" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});
		}
		else if(projectType == 'creator'){
			//버튼
			$('#artistsButton').removeClass('project-form-required-type-button-select');
			$('#creatorsButton').addClass('project-form-required-type-button-select');
			$('#cultureButton').removeClass('project-form-required-type-button-select');

			//버튼텍스트
			$( ".project_form_button_text_artist" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			$( ".project_form_button_text_creator" ).each(function(){
				$(this).addClass('project_form_button_select');
			});

			$( ".project_form_button_text_culture" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});
		}
		else if(projectType == 'culture'){
			//버튼
			$('#artistsButton').removeClass('project-form-required-type-button-select');
			$('#creatorsButton').removeClass('project-form-required-type-button-select');
			$('#cultureButton').addClass('project-form-required-type-button-select');

			//버튼텍스트
			$( ".project_form_button_text_artist" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			$( ".project_form_button_text_creator" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			$( ".project_form_button_text_culture" ).each(function(){
				$(this).addClass('project_form_button_select');
			});
		}
	};

	var setSaleTypeButton = function(){
		var saleType = $('#saleType').val();

		if(saleType == 'sale'){
			//버튼
			$('#fundingTypeButton').removeClass('project-form-required-type-button-select');
			$('#saleTypeButton').addClass('project-form-required-type-button-select');
			$('#pickTypeButton').removeClass('project-form-required-type-button-select');
			//버튼텍스트
			$( ".project_form_button_text_direct" ).each(function(){
				$(this).addClass('project_form_button_select');
			});

			$( ".project_form_button_text_schedule" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			$( ".project_form_button_text_pick" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			//티켓팅일 경우 장소 확정 후 안보이게 한다.
			setIsPlace('TRUE');
			$('#project_form_required_place_container').hide();

		}
		else if(saleType == 'funding'){
			//버튼
			$('#fundingTypeButton').addClass('project-form-required-type-button-select');
			$('#saleTypeButton').removeClass('project-form-required-type-button-select');
			$('#pickTypeButton').removeClass('project-form-required-type-button-select');
			//버튼텍스트
			$( ".project_form_button_text_direct" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			$( ".project_form_button_text_schedule" ).each(function(){
				$(this).addClass('project_form_button_select');
			});

			$( ".project_form_button_text_pick" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			//티켓팅일 경우 장소 보이게 한다.
			$('#project_form_required_place_container').show();
		}
		else if(saleType == 'pick'){
			/*
			//버튼
			$('#fundingTypeButton').removeClass('project-form-required-type-button-select');
			$('#saleTypeButton').removeClass('project-form-required-type-button-select');
			$('#pickTypeButton').addClass('project-form-required-type-button-select');
			//버튼텍스트
			$( ".project_form_button_text_direct" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			$( ".project_form_button_text_schedule" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			$( ".project_form_button_text_pick" ).each(function(){
				$(this).addClass('project_form_button_select');
			});

			//티켓팅일 경우 장소 확정 후 안보이게 한다.
			setIsPlace('TRUE');
			$('#project_form_required_place_container').hide();
			*/
		}
	};

	var setIsPlaceButton = function(){
		var isPlace = $('#isPlace').val();
		if(isPlace == 'TRUE'){
			//버튼
			$('#placeDecideButton').addClass('project-form-required-type-button-select');
			$('#placeUnDecidedButton').removeClass('project-form-required-type-button-select');
			//버튼텍스트
			$( ".project_form_button_text_placeDecide" ).each(function(){
				$(this).addClass('project_form_button_select');
			});

			$( ".project_form_button_text_UnDecided" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});
		}
		else if(isPlace == 'FALSE'){
			//버튼
			$('#placeUnDecidedButton').addClass('project-form-required-type-button-select');
			$('#placeDecideButton').removeClass('project-form-required-type-button-select');
			//버튼텍스트
			$( ".project_form_button_text_placeDecide" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			$( ".project_form_button_text_UnDecided" ).each(function(){
				$(this).addClass('project_form_button_select');
			});
		}
	};

	var setFundTargetButton = function(){
		var fundTarget = $('#project_target').val();
		if(fundTarget == 'money'){
			//버튼
			$('#targetMoneyButton').addClass('project-form-required-type-button-select');
			$('#targetPeopleButton').removeClass('project-form-required-type-button-select');
			//버튼텍스트
			$( ".project_form_button_text_money" ).each(function(){
				$(this).addClass('project_form_button_select');
			});

			$( ".project_form_button_text_people" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			$('.project_form_fund_target_sub_title').text("원이 모이면 성공!");
		}
		else if(fundTarget == 'people'){
			//버튼
			$('#targetPeopleButton').addClass('project-form-required-type-button-select');
			$('#targetMoneyButton').removeClass('project-form-required-type-button-select');
			//버튼텍스트
			$( ".project_form_button_text_money" ).each(function(){
				$(this).removeClass('project_form_button_select');
			});

			$( ".project_form_button_text_people" ).each(function(){
				$(this).addClass('project_form_button_select');
			});

			$('.project_form_fund_target_sub_title').text("명이 모이면 성공!");
		}
	};

	$('#artistsButton').bind('click',function(){
		setProjectType("artist");
	});

	$('#creatorsButton').bind('click',function(){
		setProjectType("creator");
	});

	$('#cultureButton').bind('click',function(){
		setProjectType("culture");
	});

	$('#fundingTypeButton').bind('click', function(){
		setSaleType('funding');
	});

	$('#saleTypeButton').bind('click', function(){
		setSaleType('sale');
	});

	$('#pickTypeButton').bind('click', function(){
		setSaleType('pick');
	});

	$('#placeDecideButton').bind('click', function(){
		setIsPlace('TRUE');
	});

	$('#placeUnDecidedButton').bind('click', function(){
		setIsPlace('FALSE');
	});

	$('#targetMoneyButton').bind('click', function(){
		setFundTarget('money');
	});

	$('#targetPeopleButton').bind('click', function(){
		setFundTarget('people');
	});


	setProjectTypeButton();
	setSaleTypeButton();
	setIsPlaceButton();
	setFundTargetButton();

	//수량 체크
	$("#discount_percent_value_input").change(function(){
		var value = $(this).val();

		if(value < 0)
		{
			swal("할인율은 0보다 작을 수 없습니다.", "", "warning");
			$(this).val(0);
		}

		if(value > 100)
		{
			swal("할인율은 100보다 클 수 없습니다.", "", "warning");
			$(this).val(100);
		}
	});

	var getPickStartDay = function(){
		if(!$("#isPickType").val())
		{
			return '';
		}

		var closing_at = $("#funding_closing_at").val();
		if(!closing_at)
		{
			return '';
		}

		var rawDate = closing_at.split(" ");
		var d = rawDate[0].split("-");

		//var closeDay = new Date(d[0],(d[1]-1),d[2]);
		var pickStartDay = new Date(d[0],(d[1]-1),d[2]);

		pickStartDay.setDate(pickStartDay.getDate() + 1);

		var yyyy_pick = pickStartDay.getFullYear();
		var mm_pick = pickStartDay.getMonth() + 1;
		var dd_pick = pickStartDay.getDate();

		return yyyy_pick+"-"+mm_pick+"-"+dd_pick;
	};

	//추첨 타입일 경우
	var initPickTypeElement = function(){
		if(!$("#isPickType").val())
		{
			return;
		}

		//var closing_at = $("#funding_closing_at").val();
		var closing_at = getPickStartDay();
		var selectPickDay = $("#pickday_select").attr("pick-closing-at");
		if(selectPickDay)
		{
			var pickDayValue = getSubStartDayEndDay(closing_at, selectPickDay);
			$("#pickday_select").val(pickDayValue);
		}
		//마감일 셋팅 해야함.

		setPickDayElement();
	};

	var setPickDayElement = function(){
			if(!$("#isPickType").val())
			{
				return;
			}

			//var closing_at = $("#funding_closing_at").val();
			//var closing_at = getPickStartDay();
			var closing_at = getPickStartDay();
			if(!closing_at)
			{
				return;
			}
			var selectPickDay = $("#pickday_select").val();

			var rawDate = closing_at.split(" ");
		  var d = rawDate[0].split("-");

			var closeDay = new Date(d[0],(d[1]-1),d[2]);
		  var pickPeriodDay = new Date(d[0],(d[1]-1),d[2]);

			pickPeriodDay.setDate(pickPeriodDay.getDate() + Number(selectPickDay));

		  var yyyy_pick = pickPeriodDay.getFullYear();
		  var mm_pick = pickPeriodDay.getMonth() + 1;
		  var dd_pick = pickPeriodDay.getDate();

			var yyyy_close = closeDay.getFullYear();
		  var mm_close = closeDay.getMonth() + 1;
		  var dd_close = closeDay.getDate();

			var payDay = pickPeriodDay;
			payDay.setDate(payDay.getDate() + 1);

			var yyyy_pay = payDay.getFullYear();
		  var mm_pay = payDay.getMonth() + 1;
		  var dd_pay = payDay.getDate();

			mm_pick = getTwoNumberToOneNumber(mm_pick);
			dd_pick = getTwoNumberToOneNumber(dd_pick);

			mm_close = getTwoNumberToOneNumber(mm_close);
			dd_close = getTwoNumberToOneNumber(dd_close);

			mm_pay = getTwoNumberToOneNumber(mm_pay);
			dd_pay = getTwoNumberToOneNumber(dd_pay);

			//getSubStartDayEndDay(closeDay, pickPeriodDay);

			$("#pick_day_period").text("추첨기간 : " + yyyy_close+"-"+mm_close+"-"+dd_close+" ~ "+yyyy_pick+"-"+mm_pick+"-"+dd_pick);
			$("#pay_day_after_pick").text("결제일 : " + yyyy_pay+"-"+mm_pay+"-"+dd_pay+" 오후 1시");

			$("#pickday_select").attr("pick-closing-at", yyyy_pick+"-"+mm_pick+"-"+dd_pick);

	};

	var selected_tab = $('#selected_tab').val();
	if(selected_tab == 'base'){
		if($("#isPickType").val())
		{

			initPickTypeElement();

			$("#funding_closing_at").change(function(){
				setPickDayElement();
			});
		}

		$("#pickday_select").change(function(){
			setPickDayElement();
		});
	}
	else if(selected_tab === 'required')
	{
		var elementPopup = document.createElement("div");
		elementPopup.innerHTML =
		"<div class='blueprint_check_pop_container'>" + 
			"<div class='blueprint_check_pop_title'>" + 
				"크라우드티켓이 확인 연락을 드려요!" +
			"</div>" +
			"<div class='blueprint_check_pop_line'>" + 
			"</div>" +
			"<div class='blueprint_check_pop_subtitle'>" + 
				"<p style='margin-bottom: 0px;'>편한 프로젝트 준비 및 등록을 위해<br>" +
				"저희 크라우드티켓이 작성을 함께 도와드려요</p>" +
			"</div>" +

			"<div class='blueprint_check_pop_contact_bg'>" + 
				"<p>연락은 평일 오전 10시 ~ 7시 사이에 드릴 예정입니다.</p>" +
			"</div>" +

			"<button class='blueprint_check_pop_button'>" +
				"확인" +
			"</button>" +
			"<p class='blueprint_check_pop_foot'>연락 전 직접 작성도 가능해요!</p>" +
		"</div>";

		swal({
			content: elementPopup,
			allowOutsideClick: "true",
			className: "blueprint_check_popup",
			closeOnClickOutside: false,
			closeOnEsc: false
		});

		$(".swal-footer").hide();

		$(".blueprint_check_pop_button").click(function(){
			swal.close();
		});
  }
  
  var addMannayoObject = function(project, parentElement, index){
    var containerClassName = '';
    var firstDiv = '';
    if(index === 0 )
    {
      firstDiv = "<div class='welcome_thumb_container thumb_container_right_is_mobile'>";
      containerClassName = 'welcome_thumb_container thumb_container_right_is_mobile';
    }
    else
    {
      firstDiv = "<div class='welcome_thumb_container'>";
      containerClassName = 'welcome_thumb_container';
    }

    var projectLink = project.link;

    var projectTypeWidth = '';
    if(!project.project_type)
    {
      project.project_type = 'artist';
    }
    
    if(project.project_type === 'artist')
    {
      projectTypeWidth = 'width:54px'
    }

    var projectImgClass = 'img_project_id_' + project.id;

    var mannayoObject = document.createElement("div");
    mannayoObject.className = containerClassName;
    mannayoObject.innerHTML = "<div class='welcome_thumb_img_wrapper'>" +
            "<div class='welcome_thumb_img_resize'>" +
                //"<img src='"+project.poster_url+"' onload='imageResize_new($('.welcome_thumb_img_resize')[0], this);' class='project-img'/>" +
                "<img class='"+projectImgClass+" project-img' src='"+$('#poster_url').val()+"'/>" +
            "</div>" +
        "</div>" +
        "<div class='welcome_thumb_content_container'>" +
        
            "<h5 class='text-ellipsize welcome_thumb_content_disc'>" +
                project.description +
            "</h5>" +

            "<h4 class='text-ellipsize-2 welcome_thumb_content_title'>" +
                project.title +
            "</h4>" +

            "<p class='welcome_thumb_content_date_place'>" +
              $('#ticket_data_slash').val() +
            "</p>" +

            "<div class='welcome_thumb_content_type_wrapper isMobileDisable' style='"+projectTypeWidth+"'>" +
                "<p class='welcome_thumb_content_type'>" +
                    project.project_type +
                "</p>" +
            "</div>" +
            
        "</div>" +
    "</div>";

    parentElement.appendChild(mannayoObject);      
    
    $('.'+projectImgClass).on('load', function() {
      //alert("image is loaded");
      imageResize_new($('.welcome_thumb_img_resize')[0], $('.'+projectImgClass)[0]);
    });
  };

  if($('#selected_tab').val() === 'poster')
  {
    var project = $('#g_project').val();
    project = $.parseJSON(project);

    //console.error(project.id);
    addMannayoObject(project, $('.project_form_poster_sampleview_container')[0], 0);
  }
});
//form_body_required END

function posterTitleFakeClick(img_num){
	alert(img_num);
	return false;
}
//분류탭 form_body_required

function tabSelect(tabKey){
	if(tabKey != 'required'){
		if(requiredSavedCheck() == false)
		{
			//최종적으로 저장 안됐을때만 체크 한다.
			requiredVaildCheck();

			return false;
		}
	}

	var base_url = window.location.origin;
	var projectId = $('#project_id').val();
	//var url = base_url+'/projects/form/' + projectId+'?tab='+tabKey;
	var url = base_url+'/projects/form/'+projectId+'?tab='+tabKey;

	window.location.href = url;
}

function requiredVaildCheck(){
	var projectType = $('#projectType').val();
	var saleType = $('#saleType').val();
//requiredSuccess === "FALSE"
	if(projectType === "" || saleType === "")
	{
		swal("프로젝트 종류와 결제 방식을 선택해주세요. ", "", "error");
		loadingProcessStop($(".project_form_button_wrapper"));
		return false;
	}

	return true;
}

function requiredSavedCheck(){
	var requiredSuccess = $('#isReqiredSuccess').val();
	if(requiredSuccess === "TRUE"){
		return true;
	}

	swal("저장 후 다음을 눌러주세요!", "", "error");

	loadingProcessStop($(".project_form_button_wrapper"));
	return false;
}
