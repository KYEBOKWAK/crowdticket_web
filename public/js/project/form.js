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

		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId + '/alias/' + alias;
		var method = 'get';
		var success = function() {
			alert('사용가능한 주소입니다.');
		};
		var error = function(request) {
			if (request.status === 409) {
				alert('이미 존재하는 주소입니다. 다른 이름을 사용해주세요.');
			} else if (request.status === 422) {
				alert('잘못된 형식의 주소입니다.');
			}
		};

		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
	};

	var updateDefault = function() {
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
			'project_target': $('#project_target').val()
		});
	};

	var updateProject = function(data) {
		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId;
		var method = 'put';
		var success = function(e) {
			$('#isReqiredSuccess').val('TRUE');

			alert('저장되었습니다.');
			alert(JSON.stringify(e));
		};
		var error = function(e) {
			alert('저장에 실패하였습니다.');
			alert(JSON.stringify(e));
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
					for (var i = 0, l = tickets.length; i < l; i++) {
						addTicketRow(tickets[i]);
					}
				}
			}
		}
	};

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

		//alert(JSON.stringify(data));

		if (validateTicketData(data)) {
			var success = function(result) {
				//clearTicketForm();
				addTicketRow(result);
			};
			var error = function(request) {
				alert('보상 추가에 실패하였습니다.');
				//alert(JSON.stringify(request));
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
				if(ticketsCategory[i].id === categoryNum){
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
				if(ticketsCategory[i].id === categoryNum){
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
/*
	var posterAjaxOption = {
		'beforeSerialize': function($form, options) {
			$posterFile = $('#poster_file');
			if ($posterFile.val() === '') {
				$posterFile.prop("disabled", true);
			} else {
				$posterFile.prop("disabled", false);
			}
		},
		'success': function(result) {
			//alert(JSON.stringify(result.id));
			//console.log(JSON.stringify(result));
			alert('저장되었습니다.');
		},
		'error': function(data) {
			alert("저장에 실패하였습니다.");
		}
	};
*/
	var onDescriptionChanged = function() {
		var description = $('#poster_description').val();
		$('.project-description').text(description);
	};

	var updateStory = function() {
		EasyDaumEditor.save(function(content) {
			updateProject({
				'video_url': $('#video_url').val(),
				'story': content
			});
		});
	};

	var submitProject = function() {
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
	};

	//form_body_required
	var updateRequired = function(){
		//유효성 체크
		if(requiredVaildCheck() == true){
			var isPlace = $('#isPlace').val();
			if(isPlace === "FALSE")
			{
				isPlace = "none";
			}
			else {
				isPlace = "";
			}

			//프로젝트 타입이 티켓 판매라면 타겟이 어떤값이든 초기화 시켜준다.
			var saleType = $('#saleType').val();
			var projectTarget = $('#projectTarget').val();
			if(saleType === "sale")
			{
				projectTarget = "";
			}

			updateProject({
				'type': saleType,
				'project_type': $('#projectType').val(),
				'concert_hall': isPlace,
				'project_target': projectTarget
			});
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
		});
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
				alert('할인 정보 추가 성공!');
				//clearTicketForm();
				addDiscountRow(result);
			};
			var error = function(request) {
				alert('할인 정보 추가에 실패하였습니다.');
				alert(JSON.stringify(request));
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
			'limite_count': $('#discount_limite_input').val(),
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
				for (var i = 0, l = discounts.length; i < l; i++) {
					addDiscountRow(discounts[i]);
				}
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
		alert(url);
		var success = function(result) {
			discount.remove();
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

	};
	/*
	var createGoods = function(){
		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId + '/goods';

		var method = 'post';

		var form = getGoodsFormData();
		//var form = new FormData();
		//form.append('price', $('#goods_price_input').val());
		//form.append('title', $('#goods_title_input').val());
		//form.append('content', $('#goods_content_input').val());
		//form.append('img_url', $('#goods_img_file').val());
		//var data = getGoodsFormData();
		//'price': $('#goods_price_input').val(),
		//'title': $('#goods_title_input').val(),
		//'content': $('#goods_content_input').val(),
		//'img_url': $('#goods_img_file').val()

		//var formData = new FormData(document.getElementById('#goods_img_file'));
		//alert(url);
		//alert(JSON.stringify(form.get('img_url')));
		if (validateGoodsData(form)) {
			var success = function(result) {
				alert(JSON.stringify(result));
				//console.log(JSON.stringify(result));
				//alert('MD 정보 추가 성공!');
				//clearTicketForm();
				//addTicketRow(result);
			};
			var error = function(request) {
				alert('MD 정보 추가에 실패하였습니다.');
				alert(JSON.stringify(request));
			};

			$.ajax({
				'url': url,
				'method': method,
				'data': form,
				'success': success,
				'error': error
			});

		}
	};
	*/

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
		alert("img change");
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#goods_img_preview').css('background-image', "url('" + e.target.result + "')");
				//$('.project-thumbnail').css('background-image', "url('" + e.target.result + "')");
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
			if ($goods_img_file.val() === '') {
				//$goods_img_file.prop("disabled", true);
			} else {
				//$goods_img_file.prop("disabled", false);
			}
		},
		'success': function(result) {
			//alert(JSON.stringify(result.img_url));
			//console.log(JSON.stringify(result));
			alert('성공! 저장되었습니다.');

			if(result['goodsState'] === 'updategoods') {
				updateGoods(result['goods']);
				clearGoodsForm();
				//alert(JSON.stringify(result['goods']));
			}
			else {
				addGoodsRow(result['goods']);
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
			}
		}
	};

	var addGoodsRow = function(goods){
		var lineItemMax = 3;
		var containerClassName = '.goodsListContainer';
		var goodsList = $('#goods_list');

		var templateGoodsItem = $('#template_goods_list_item').html();
		var compiledGoodsItem = _.template(templateGoodsItem);
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

		$('#goods_img_preview').css('background-image', "url('" + goodsData.img_url + "')");
		//$('#discount_submit_input').val(goodsData.submit_check);
		$('#goodsId').val(goodsData.id);

		$('#update_goods').attr('data-goods-id', goods.attr('data-goods-id'));
	};

	var updateGoods = function(goods) {
		var goodsItem = $('.goods-item[data-goods-id=' + goods.id + ']');
		goodsItem.remove();
		addGoodsRow(goods);
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

	var goodsListRefresh =  function(goodsParents, goodsListJson) {
		//다 지우고 다시 재정렬 한다.
		var goodsListDom = $('#goods_list');

		goodsListDom.children().remove();

		if (goodsListJson.length > 0) {
			for (var i = 0, l = goodsListJson.length; i < l; i++) {
				addGoodsRow(goodsListJson[i]);
			}
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

		$('#goods_img_preview').css('background-image', "url('" + $('#default_img').val() + "')");
	};
	//goods end


	$('#check_alias').bind('click', checkAliasDuplicate);
	$('#update_default').bind('click', updateDefault);
	$('#funding_closing_at').datepicker({'dateFormat': 'yy-mm-dd'});
	$('#create_ticket').bind('click', createTicket);
	$('#update_ticket').bind('click', updateTicket);
	$('#cancel_modify_ticket').bind('click', cancelModifyTicket);
	$('#ticket_delivery_date').datepicker({'dateFormat': 'yy-mm-dd'});
	//$('#poster_form').ajaxForm(posterAjaxOption);
	$('#update_story').bind('click', updateStory);
	$('#submit_project').bind('click', submitProject);
	//$('#poster_file_fake').bind('click', performPosterFileClick);
	//$('#poster_file').change(onPosterChanged);
	$('#poster_description').bind('input', onDescriptionChanged);

	//분류 탭 저장 form_body_required
	$('#update_required').bind('click', updateRequired);
	//티켓공지 저장
	$('#ticket_notice_save').bind('click', ticketNoticeSave)

	//Discount
	$('#create_discount').bind('click', createDiscount)
	$('#cancel_modify_discount').bind('click', cancelModifyDiscount);
	$('#update_discount').bind('click', updateDiscount);

	//Goods
	//$('#create_goods').bind('click', createGoods)
	$('#cancel_modify_goods').bind('click', cancelModifyGoods);
	$('#update_goods').bind('click', createGoods);

	$('#goods_form').ajaxForm(goodsAjaxOption);

	$('#goods_file_fake').bind('click', performGoodsFileClick);
	$('#goods_img_file').change(onGoodsImgChanged);

	//poster
	var performPosterTitleFileClick = function(){
		var imgNumber = $(this).attr('data-img-number');
		$('#title_img_file_'+imgNumber).trigger('click');
	};

	var onPosterTitleChanged = function(){
		if (this.files && this.files[0]) {
			var imgNumber = $(this).attr('data-img-number');
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#title_img_preview_'+imgNumber).css('background-image', "url('" + e.target.result + "')");
				setPosterTitleDeleteBtn(true, imgNumber);
			};
			reader.readAsDataURL(this.files[0]);
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
			/*
			$goods_img_file = $('#goods_img_file');
			if ($goods_img_file.val() === '') {
				//$goods_img_file.prop("disabled", true);
			} else {
				//$goods_img_file.prop("disabled", false);
			}
			*/
		},
		'success': function(result) {
			//var poster = JSON.stringify(result);
			alert('성공! 저장되었습니다.');

			//poster
			setPosterIdDeleteBtn(result['id']);

			//posterTitle
			var titleFileName = '';
			var titleImgDeleteBtnId = '';
			var fileNumber = 0;
			for (var i = 0, l = 4; i < l; i++) {
				fileNumber = i+1;
				titleFileName = 'title_img_file_'+fileNumber;

				setPosterIdTitleDeleteBtn(fileNumber, result['id']);
			}
		},
		'error': function(data) {
			alert("저장에 실패하였습니다.");
		}
	};

	var listOldPosters = function(){
		var postersJson = $('#posters_json').val();
		if (postersJson) {
			var posters = $.parseJSON(postersJson);
			//alert(JSON.stringify(posters['title_img_file_1'].img_url));
			var titleFileName = '';
			var fileNumber = 0;
			for (var i = 0, l = 4; i < l; i++) {
				fileNumber = i+1;
				titleFileName = 'title_img_file_'+fileNumber;
				if(posters[titleFileName].isFile == true){
					setPosterTitleDeleteBtn(true, fileNumber);
				}
				else{
					setPosterTitleDeleteBtn(false, fileNumber);
				}

				setPosterTitleImg(fileNumber, posters[titleFileName].img_url, posters['id']);
			}

			setPosterImg(posters['poster_img_file'].img_url, posters['id']);
			if(posters['poster_img_file'].isFile == true){
				//파일이 있으면 삭제 버튼 활성화
				setPosterDeleteBtn(true);
			}
		}
	};

	var setPosterTitleImg = function(titleFileNumber, imgUrl, posterId){
		var posterTitleId = '#title_img_preview_'+titleFileNumber;
		$(posterTitleId).css('background-image', "url('" + imgUrl + "')");

		setPosterIdTitleDeleteBtn(titleFileNumber, posterId);
	};

	var setPosterImg = function(imgUrl, posterId){
		$('#poster_img_preview').css('background-image', "url('" + imgUrl + "')");

		setPosterIdDeleteBtn(posterId);
	}

	var setPosterIdTitleDeleteBtn = function(titleFileNumber, posterId){
		var deleteBtnId = '#delete-poster-title-img'+titleFileNumber;
		$(deleteBtnId).attr('data-poster-id', posterId);
	}

	var setPosterIdDeleteBtn = function(posterId){
		$('#delete-poster-img').attr('data-poster-id', posterId);
		//$(deleteBtnId).attr('data-poster-id', posterId);
	}

	var setPosterTitleDeleteBtn = function(isShow, btnNum){
		var deleteBtnid = '#delete-poster-title-img'+btnNum;
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
			alert("삭제 성공하였습니다." + JSON.stringify(result));
			deleteTitlePosterImg(result);
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

	var deleteTitlePosterImg = function(imgNum){
		$('#title_img_preview_'+imgNum).css('background-image', "url('" + $('#default_img').val() + "')");
		$('#title_img_file_'+imgNum).val('');

		setPosterTitleDeleteBtn(false, imgNum);
	}

	var deletePosterImg = function(){
		$('#poster_img_preview').css('background-image', "url('" + $('#default_img').val() + "')");
		$('#poster_img_file').val('');

		setPosterDeleteBtn(false);
	}

	//반복되는 아이디 가져오는 방법을 몰라서 일단 1,2,3,4 추가해놈. 이미지가 늘어나면 이어서 bind 와 change만 추가하면 됨
	$('#title_img_file_fake_1').bind('click', performPosterTitleFileClick);
	$('#title_img_file_fake_2').bind('click', performPosterTitleFileClick);
	$('#title_img_file_fake_3').bind('click', performPosterTitleFileClick);
	$('#title_img_file_fake_4').bind('click', performPosterTitleFileClick);

	$('#delete-poster-title-img1').bind('click', deletePosterTitle);
	$('#delete-poster-title-img2').bind('click', deletePosterTitle);
	$('#delete-poster-title-img3').bind('click', deletePosterTitle);
	$('#delete-poster-title-img4').bind('click', deletePosterTitle);

	$('#title_img_file_1').change(onPosterTitleChanged);
	$('#title_img_file_2').change(onPosterTitleChanged);
	$('#title_img_file_3').change(onPosterTitleChanged);
	$('#title_img_file_4').change(onPosterTitleChanged);

	$('#poster_file_fake').bind('click', performPosterFileClick);
	$('#poster_img_file').change(onPosterChanged);
	$('#delete-poster-img').bind('click', deletePoster);

	$('#poster_form').ajaxForm(posterAjaxOption);



	//개설자 소개 start
	var saveCreator = function(){

	};

	var listOldChannel = function() {
		var channelJson = $('#channels_json').val();
		if (channelJson) {
			var channels = $.parseJSON(channelJson);
			//alert(JSON.stringify(channels));
			if (channels.length > 0) {
				for (var i = 0, l = channels.length; i < l; i++) {
					addChannelRow(channels, i);
				}
			}
		}

		setChannelAddBtn();
	};

	var addChannelRow = function(channels, index) {
		var channelListSize = $('#channel_list').children().size();
		if(channelListSize >= 6){
			alert('최대 6개 입니다.');
			return;
		}

		var channel = '';
		var isFake = '';
		if(channels == '') {
			channel = {
									"id" : "",
									"isFake" : "true",
									"categories_channel_id" : "1"
								};
		}
		else{
			channel = channels[index]
		}

		channel['index'] = index;
		channel['isFake'] = isFake;
		//var channel = channels[index];

		var templateChannel = $('#template_channel').html();
		var compiled = _.template(templateChannel);
		var row = compiled({ 'channel': channel, 'index' : index });
		var $row = $($.parseHTML(row));

		$row.data('channelData', channel);
		$('#channel_list').append($row);

		//카테고리 옵션 변경
		$row.children('#channel_category').val(channel.categories_channel_id).prop("selected", true);

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

			var addChannelBtn = $(element).children('.project-form-chaanel-button-container').children('.add-channel');

			var urlInput = $(element).children('#channel_category_url_input');
			var categoryInput = $(element).children('#channel_category');
			var channelIdInput = $(element).children('#channelId');

			categoryInput.attr('name', 'channel_category'+index);
			urlInput.attr('name', 'channel_category_url_input'+index);
			channelIdInput.attr('name', 'channelId'+index);

			if(index == channelListSize-1) {
				addChannelBtn.show();
			}
			else {
				addChannelBtn.hide();
			}
  	});
	};

	//채널input에 채널id 값 갱신;
	var updateChannelID = function(channels){
		$.each(channels,function(key,value) {
			$("input[name="+key+"]").val(value);
		});
	};

/*
	var addChannelRow = function(channel) {

		var templateChannel = $('#template_channel').html();
		var compiled = _.template(templateChannel);
		var row = compiled({ 'channel': channel });
		var $row = $($.parseHTML(row));
		$row.data('channelData', channel);
		$('#channel_list').append($row);

		//$row.find('.modify-discount').bind('click', modifyDiscount);
		$row.find('.delete-channel').bind('click', deleteChannel);
	};
*/
	var deleteChannel = function() {
		var channel = $(this).closest('.channel');
		var channelId = channel.attr('data-channel-id');
		if(channelId == '')
		{
			//채널아이디가 없으면 서버에 저장되지 않은 페이크 정보
			channel.remove();
			setChannelAddBtn();
			return;
		}

		var url = '/channels/' + channelId;
		var method = 'delete';

		var success = function(result) {
			alert("성공!" + JSON.stringify(result));
			channel.remove();
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
			//alert(JSON.stringify(resultJson.length));
			updateChannelID(resultJson);
			alert('저장되었습니다.' + JSON.stringify(resultJson));
		},
		'error': function(data) {
			alert("저장에 실패하였습니다.");
		}
	};

	//$('#save_creator').bind('click', saveCreator);
	$('#profile-upload-photo-fake').bind('click', performProfileFileClick);
	$('#input-user-photo').change(onProfileChanged);
	$('#creator_form').ajaxForm(profileAjaxOption);
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

	$(window).bind('beforeunload', function() {
		// return '페이지를 나가기 전에 저장되지 않은 정보를 확인하세요';
	});
});

function posterTitleFakeClick(img_num){
	alert(img_num);
	return false;
}
//분류탭 form_body_required

function tabSelect(tabKey){
	if(tabKey != 'required'){
		if(requiredSavedCheck() == false)
		{//최종적으로 저장 안됐을때만 체크 한다.
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
	return false;
}

function setProjectType(projectType){

	//var buttonName = "#"+projectType+"Button";
	var artistsButton = $('#artistsButton');
	var creatorsButton = $('#creatorsButton');

	artistsButton.css('background-color', "white");
	artistsButton.css('color', "black");

	creatorsButton.css('background-color', "white");
	creatorsButton.css('color', "black");

	if(projectType == 'artist'){
		artistsButton.css('background-color', "#ea535a");
		artistsButton.css('color', "white");
		$('#projectType').val("artist");
	}
	else if(projectType == 'creator'){
		creatorsButton.css('background-color', "#ea535a");
		creatorsButton.css('color', "white");
		$('#projectType').val("creator");
	}

	//innerHTML
}

function setSaleType(type){
	var saleButton = $('#saleTypeButton');
	var fundingButton = $('#fundingTypeButton');
	var placeContainer = $('#isPlaceContainer');
	var isPlaceButton = $('#isPlaceButton');

	saleButton.css('background-color', "white");
	saleButton.css('color', "black");

	fundingButton.css('background-color', "white");
	fundingButton.css('color', "black");

	if(type == 'sale'){
		saleButton.css('background-color', "#ea535a");
		saleButton.css('color', "white");

		$('#saleType').val("sale");

		isPlaceButton.css('background-color', "white");
		isPlaceButton.css('color', "black");
		$('#isPlace').val("TRUE");

		placeContainer.css('display', "none");
	}
	else if(type == 'funding'){
		fundingButton.css('background-color', "#ea535a");
		fundingButton.css('color', "white");

		$('#saleType').val("funding");

		placeContainer.css('display', "grid");
	}
}

function setIsPlace(){
	var isPlace = $('#isPlace').val();
	var isPlaceButton = $('#isPlaceButton');

	if(isPlace === "TRUE"){
		isPlaceButton.css('background-color', "#ea535a");
		isPlaceButton.css('color', "white");
		$('#isPlace').val("FALSE");
	}
	else{
		isPlaceButton.css('background-color', "white");
		isPlaceButton.css('color', "black");
		$('#isPlace').val("TRUE");
	}
}

//meony, people
function setTargetType(type){
	var moneyButton = $('#targetMoneyButton');
	var peopleButton = $('#targetPeopleButton');

	moneyButton.css('background-color', "white");
	moneyButton.css('color', "black");

	peopleButton.css('background-color', "white");
	peopleButton.css('color', "black");

	if(type == 'money'){
		moneyButton.css('background-color', "#ea535a");
		moneyButton.css('color', "white");

		$('#project_target').val("money");
	}
	else if(type == 'people'){
		peopleButton.css('background-color', "#ea535a");
		peopleButton.css('color', "white");

		$('#project_target').val("people");
	}
}
