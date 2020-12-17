<?php

Route::pattern('id', '[0-9]+');
Route::pattern('code', '[a-zA-Z0-9]+');
Route::pattern('alias', '[a-zA-Z0-9-_]+');
Route::pattern('name', '[a-zA-Z]+');
Route::pattern('entity', 'projects|comments|tickets|overcount|mannayo|mannayocommentscomment');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('/facebook', 'Auth\SocialAuthController@redirect');
Route::get('/facebook/callback', 'Auth\SocialAuthController@callback');
//Route::get('/facebook/callback/{facebookid}/{facebookName}/{facebookEmail}/{previousURL}', 'Auth\SocialAuthController@callback')->where('previousURL', '.*');

Route::post('/social/gologin', 'Auth\SocialAuthController@goSocialLogin');
//Route::get('/facebook/callback/{facebookid}/{facebookName}/{facebookEmail}', 'Auth\SocialAuthController@callback');

//Route::get('/redirection/go', 'Auth\AuthController@redirect');

Route::post('initialize', 'WelcomeController@initialize');
Route::post('ping', 'WelcomeController@ping');

Route::get('/', 'WelcomeController@index');
Route::get('/home', 'WelcomeController@index');

Route::get('kakao/chat', function () {
    return view('kakao_channel_connect');
});

Route::get('terms/', function () {
    return view('customer.terms');
});
Route::get('privacy/', function () {
    return view('customer.privacy');
});
Route::get('thirdterms/', function () {
    return view('customer.thirdterms');
});
Route::get('join_agree/', function () {
    return view('customer.join_agree');
});
Route::get('marketing_agree/', function () {
    return view('customer.marketing_agree');
});
Route::get('creator_agree/', function () {
    return view('customer.creator_agree');
});
Route::get('project_agree/', function () {
    return view('customer.project_agree');
});
Route::get('cs_agree/', function () {
    return view('customer.cs_agree');
});

/*
Route::get('testterms/', function () {
    return view('customer.testterms');
});
Route::get('help/', function () {
    return view('customer.help');
});
*/

//mobile App 약관동의 start
Route::get('privacy/app/', function () {
    return view('customer.privacy_app');
});
Route::get('terms/app/', function () {
    return view('customer.terms_app');
});
Route::get('thirdterms/app/', function () {
    return view('customer.thirdterms_app');
});
Route::get('join_agree/app/', function () {
    return view('customer.join_agree_app');
});
Route::get('marketing_agree/app/', function () {
    return view('customer.marketing_agree_app');
});

//mobile App 약관동의 end

/*
//CREATOR Landing PAGE
Route::get('creators/', function () {
    return view('landing/landing_creator');
});

//CREATOR LANDING EMAIL form
Route::get('landing/form', function () {
    return view('landing/landing_creator_form');
});
*/

Route::post('landing/sendmail', 'MailSendController@sendEmail');
Route::post('question/sendmail', 'MailSendController@sendQuestionEmail');
Route::get('register/sendmail', 'MailSendController@sendEmailRegister');
//


Route::get('blueprints/welcome', 'BlueprintController@getBlueprintWelcome');

Route::get('object/projects', 'ProjectController@getProjectObjects');
Route::get('projects', 'ProjectController@getProjects');
Route::get('mcn/{company}', 'ProjectController@getMCNProjects');
Route::get('projects/{id}', 'ProjectController@getProjectById');
Route::get('projects/{alias}', 'ProjectController@getProjectByAlias');
Route::get('projects/{id}/alias/{alias}', 'ProjectController@checkProjectAlias');
Route::get('projects/{id}/supporters', 'ProjectController@getSupporters');
Route::get('projects/{id}/news', 'ProjectController@getNews');
Route::get('projects/{id}/comments', 'ProjectController@getComments');

//매거진 START
Route::get('magazine', 'MagazineController@getMagazineAll');
Route::get('magazine/{id}', 'MagazineController@getMagazine');
//매거진 END

Route::get('categories/{id}/projects', 'ProjectController@getCategoryProjectsById');
Route::get('categories/{title}/projects', 'ProjectController@getCategoryProjectsByTitle');

Route::get('cities/{id}/projects', 'ProjectController@getCityProjectsById');
Route::get('cities/{name}/projects', 'ProjectController@getCityProjectsByName');

Route::get('organizations', 'OrganizationController@getOrganizations');
Route::get('organizations/{id}', 'OrganizationController@getOrganization');
Route::get('organizations/{id}/members', 'MemberController@getMembers');

Route::get('{entity}/{id}/comments', 'CommentController@getComments');

Route::get('users/{id}', 'UserController@getUser');

//Mannayo START
Route::get('mannayo', 'MannayoController@goMannayo');
Route::get('mannayo/list', 'MannayoController@getMannayoList');
Route::post('get/creator/find/list', 'MannayoController@findCreatorList');
Route::post('search/creator/api/list', 'MannayoController@callYoutubeSearch');
Route::post('search/creator/find/crolling', 'MannayoController@callYoutubeSearchCrolling');
Route::post('search/creator/find/crolling/channel', 'MannayoController@getCreatorInfoInCrollingWithChannel');

///creator API START
Route::get("api/search/creator/api/list", "MannayoController@callYoutubeSearchAPI");
Route::get('api/search/creator/find/crolling', 'MannayoController@callYoutubeSearchCrollingAPI');
Route::get('api/search/creator/find/crolling/channel', 'MannayoController@getCreatorInfoInCrollingWithChannelAPI');

// Route::get('api/search/creator/find/crolling/{search_channel_id}/{channel_all_count}', 'MannayoController@callYoutubeSearchCrollingAPI');
// Route::get('api/search/creator/find/crolling/{search_channel_id}/inchannel', 'MannayoController@getCreatorInfoInCrollingWithChannelAPI');

///creator API END

Route::get('mannayo/share/{channel_id}', 'MannayoController@goMannayoCreators');
Route::get('mannayo/share/meetup/{meetup_id}', 'MannayoController@goMannayoMeetups');

Route::get('mannayo/users/list', 'MannayoController@getMannayoUsers');

Route::get('mannayo/comments/list', 'MannayoController@getComments');
//Mannayo END

Route::get('app/story/{target}/{id}', 'ProjectController@getAppStory');


//상점
Route::get('store/', function () {
    return view('store.store_home');
});

Route::get('store/{id}', 'ProjectController@getStoreDetailByID');
Route::get('store/{alias}', 'ProjectController@getStoreDetailByAlias');

Route::get('review/store/write/{id}', 'ProjectController@getWriteReviewPage');
Route::get('review/store/{store_id}/edit/{comment_id}', 'ProjectController@getEditReviewPage');


Route::get('item/store/{id}', 'ProjectController@getStoreItemDetail');
// Route::get('order/store/{id}', 'ProjectController@getOrderStore');

// Route::get('complite/store/{id}', 'ProjectController@getOrderStoreComplite');

/////

//event start
//기획전으로 우선 개발
Route::get('event/{alias}', 'ProjectController@getEventPage');
//event end

Route::group(['middleware' => 'auth'], function () {

    Route::get('users/{id}/form', 'UserController@getUpdateForm');
    Route::put('users/{id}', 'UserController@updateUser');
    Route::get('users/{id}/orders', 'UserController@getUserOrders');
    Route::get('users/{id}/mannayo', 'UserController@getUserMannayo');
    Route::get('users/store/{id}/orders', 'UserController@getMyContents');

    Route::post('blueprints', 'BlueprintController@createBlueprint');
    Route::get('blueprints/form', 'BlueprintController@getCreateForm');

    Route::get('projects/form/{id}', 'ProjectController@getUpdateFormById');
    Route::get('projects/form/{code}', 'ProjectController@getUpdateFormByCode');
    Route::put('projects/{id}', 'ProjectController@updateProject');
    //Route::put('projects/{id}/story/images', 'ProjectController@uploadStoryImage');
    Route::post('projects/{id}/story/images', 'ProjectController@uploadStoryImage');
    //Route::put('projects/{id}/news/images', 'ProjectController@uploadNewsImage');
    Route::post('projects/{id}/news/images', 'ProjectController@uploadNewsImage');

    Route::put('projects/{id}/submit', 'ProjectController@submitProject');
    Route::get('projects/{id}/stats', 'ProjectController@getStats');
    Route::get('projects/{id}/orders', 'ProjectController@getOrders');

    //Ticket
    Route::post('projects/{id}/tickets', 'TicketController@createTicket');
    Route::put('tickets/{id}', 'TicketController@updateTicket');
    Route::delete('tickets/{id}', 'TicketController@deleteTicket');

    //Discount
    Route::post('projects/{id}/discounts', 'DiscountController@createDiscount');
    Route::put('discounts/{id}', 'DiscountController@updateDiscount');
    Route::delete('discounts/{id}', 'DiscountController@deleteDiscount');

    //goods(MD)
    //Route::post('projects/{id}/goods', 'GoodsController@createGoods');
    Route::put('projects/goods/{id}', 'GoodsController@createGoods');
    Route::put('goods/{id}', 'GoodsController@updateGoods');
    Route::delete('goods/{id}', 'GoodsController@deleteGoods');

    //poster
    Route::put('projects/posters/{id}', 'PosterController@createPoster');
    Route::put('posters/{id}', 'PosterController@updatePoster');
    Route::delete('posters/title/{id}/{imgnum}', 'PosterController@deleteTitlePoster');
    Route::delete('posters/poster/{id}', 'PosterController@deletePoster');

    //channel
    Route::post('channels/{id}', 'ChannelController@createChannel');
    //Route::put('discounts/{id}', 'ChannelController@updateDiscount');
    Route::delete('channels/{id}', 'ChannelController@deleteChannel');

    //creator profile
    Route::put('users/upload/{id}', 'UserController@updateUserInfo');

    Route::post('projects/{id}/news', 'NewsController@createNews');
    Route::get('projects/{id}/news/form', 'NewsController@getCreateForm');
    Route::get('news/{id}/form', 'NewsController@getUpdateForm');
    Route::put('news/{id}', 'NewsController@updateNews');
    Route::delete('news/{id}', 'NewsController@deleteNews');

    Route::post('tickets/{id}/orders', 'OrderController@createOrder');
    //Route::post('tickets/{id}/neworders', 'OrderController@createNewOrder');
    Route::post('tickets/neworders', 'OrderController@createNewOrder');

    //티켓 구매 성공시
    Route::get('tickets/{id}/completeorder', 'OrderController@completeOrder');

    //티켓 매진시
    Route::get('tickets/{id}/overcounterorder', 'OrderController@overCounterOrder');

    Route::get('tickets/{id}/orders/completecomment', 'OrderController@completecomment');
    
    Route::post('tickets/orders/form', 'OrderController@getOrderForm');
    
    //이전 코드 getTickets
    Route::get('projects/{id}/tickets/{ticketid}', 'OrderController@getRenewalTicketsWithTicketID');
    Route::get('projects/{id}/tickets', 'OrderController@getRenewalTickets');
    Route::get('orders/{id}', 'OrderController@getOrder');
    Route::delete('orders/{id}', 'OrderController@deleteOrder');

    Route::post('{entity}/{id}/comments', 'CommentController@createComment');
    Route::delete('comments/{id}', 'CommentController@deleteComment');

    Route::delete('comments/delete', 'CommentController@deleteMeetupComment');

    Route::post('discounts/{id}/nodiscount', 'ProjectController@setNoDiscount');
    Route::post('goods/{id}/nogoods', 'ProjectController@setNoGoods');

    Route::put('projects/{projectid}/order/{orderid}/attended', 'ProjectController@attendedOrder');
    Route::put('projects/{projectid}/order/{orderid}/unattended', 'ProjectController@unAttendedOrder');
    Route::get('projects/{projectid}/order/{orderid}/getgoodsinfo', 'OrderController@getGoodsInfo');

    Route::get('projects/{id}/attend', 'ProjectController@getAttend');
    Route::get('projects/{id}/attend/{timeunix}', 'ProjectController@getAttendedList');

    Route::get('projects/{id}/picking', 'ProjectController@getPicking');
    Route::get('projects/{id}/pickingrandom', 'ProjectController@getPickingRandom');
    Route::get('projects/{id}/pickingexcel', 'ProjectController@getPickingExcel');
    Route::get('projects/{id}/pickingrequestrandom', 'ProjectController@requestPickingRandom');

    Route::post('projects/{id}/pickingcomplete', 'ProjectController@pickingComplete');
    Route::post('projects/{id}/pickingcomplete/sendmail', 'ProjectController@sendMailAfterPickComplete');
    Route::post('projects/{id}/pickingcomplete/sendcancelmail', 'ProjectController@sendCancelMailAfterPickComplete');
    Route::post('projects/{id}/pickingcomplete/sendsms', 'ProjectController@sendSMSAfterPickComplete');

    Route::post('projects/{id}/addpicking/{orderid}', 'ProjectController@addPicking');
    Route::delete('projects/{id}/deletepicking/{orderid}', 'ProjectController@deletePicking');

    Route::post('picking/{id}/excel/check', 'ProjectController@pickingExcelCheck');
    Route::post('picking/{id}/excel', 'ProjectController@pickingExcel');
    Route::post('picking/{id}/excel/cancel', 'ProjectController@pickingExcelCancel');
    Route::get('picking/{id}/excel/picked', 'ProjectController@getPickedExcel');

    //임시 코드
    Route::post('projects/{id}/addy/{orderid}', 'ProjectController@addY');
    Route::delete('projects/{id}/deletey/{orderid}', 'ProjectController@deleteY');

    Route::put('orders/{id}/updateorderstory', 'OrderController@updateOrderStory');

    Route::put('orders/{id}/updateorderanswer', 'OrderController@updateOrderAnswer');

    //매거진 START
    Route::get('magazine/write', 'MagazineController@goMagazineWrite');
    Route::get('magazine/{id}/modify', 'MagazineController@goMagazineModifyWrite');
    Route::post('magazine/story/images', 'MagazineController@uploadStoryImage');

    Route::post('magazine/{id}/update', 'MagazineController@updateMagazine');
    Route::post('magazine/update/story', 'MagazineController@updateMagazineStory');

    Route::delete('magazine/{id}/delete', 'MagazineController@deleteMagazine');
    Route::delete('magazine/{id}/deleteimg', 'MagazineController@removeMagazineTitleImageByRequest');
    Route::delete('magazine/{id}/deletethumbimg', 'MagazineController@removeMagazineThumbImageByRequest');
    //Route::post('magazine/update/{id}', 'MagazineController@updateMagazine');
    //매거진 END

    Route::post('like/{id}/{likekey}', 'UserController@addLike');

    Route::post('mannayo/create', 'MannayoController@createMeetup');
    Route::post('mannayo/create/creator', 'MannayoController@createCreator');
    
    Route::get('mannayo/user/info', 'MannayoController@getUserInfo');
    Route::post('mannayo/user/info/set', 'MannayoController@setUserInfo');
    Route::get('mannayo/get/meetup/count', 'MannayoController@getMeetupCount');
    Route::post('mannayo/meetup', 'MannayoController@meetUp');
    Route::post('mannayo/meetup/cancel', 'MannayoController@meetUpCancel');

    /////test//////
    //DB 테스트용 route
    //Route::post('')
    ///////////////

    //주문관리 api start
    Route::get('orders/project/tickets', 'ProjectController@getOrdersTickets');
    Route::get('orders/project/notickets', 'ProjectController@getOrdersNoTickets');
    Route::get('orders/project/supports', 'ProjectController@getOrdersSupports');
    Route::get('orders/project/all', 'ProjectController@getOrdersAll');
    //
    Route::get('orders/project/{project_id}/objects/{ticket_id}', 'ProjectController@getOrderObjects');
    Route::get('orders/project/{project_id}/notickets', 'ProjectController@getOrderObjectsNoTicket');
    Route::get('orders/project/{project_id}/supports', 'ProjectController@getOrderObjectsSupports');
    Route::get('orders/project/{project_id}/all', 'ProjectController@getOrderObjectsAll');

    Route::get('orders/light/info', 'ProjectController@getOrderLightInfo');
    //주문관리 api end

    //test URL
    Route::get('projects/{id}/admin/test', 'ProjectController@test');

    //구매 관리 매니저 start
    Route::get('superadmin/totalmanager', 'ProjectController@totalmanager');
    Route::post('orders/super/find', 'OrderController@getOrdersSuperFind');
    //구매 관리 매니저 end

    Route::get('manager/store/', 'ProjectController@getStoreManager');

    Route::get('store/item/addpage', 'ProjectController@getStoreAddItemPage');
    Route::get('store/item/{id}/editpage', 'ProjectController@getStoreEditItemPage');

    Route::get('order/store/{id}', 'ProjectController@getOrderStore');
    Route::get('complite/store/{id}', 'ProjectController@getOrderStoreComplite');
    Route::get('receipt/detail/store/{store_order_id}', 'ProjectController@getStoreDetailReceipt');

    Route::get('store/content/{store_order_id}', 'ProjectController@getStoreContent');

    Route::get('store/isp/{store_order_id}/complite', 'ProjectController@getStoreISPOrderComplite');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/', 'AdminController@getDashboard');
    Route::get('projects/{id}/orders', 'AdminController@getOrders');
    Route::put('blueprints/{id}/approval', 'AdminController@approveBlueprint');
    Route::put('projects/{id}/rejection', 'AdminController@rejectProject');
    Route::put('projects/{id}/approval', 'AdminController@approveProject');
    Route::post('projects/{id}/cancel', 'AdminController@cancelFundingProjectOrders');
    Route::put('order/{id}/approval', 'AdminController@approveOrder');

    //메일, 문자 보내기
    Route::post('projects/{id}/funding/mail/success', 'AdminController@sendSuccessFundingEmail');
    Route::post('projects/{id}/funding/mail/fail', 'AdminController@sendFailFundingEmail');
    Route::post('projects/{id}/funding/sms/success', 'AdminController@sendSuccessFundingSms');
    Route::post('projects/{id}/funding/sms/fail', 'AdminController@sendFailFundingSms');
    //이벤트 미당첨 이메닝ㄹ
    Route::post('projects/{id}/event/mail/fail', 'AdminController@sendFailEventEmail');

    //iamport 주문 비교하기
    Route::get('projects/{id}/ordercheck', 'AdminController@getOrderIamPortScheduleScope');

    //예약결제 결좌 처리하기
    Route::get('projects/{id}/orderfailcheck', 'AdminController@getOrderIamPortScheduleFail');

    //오더 98번 체크
    Route::get('projects/{id}/orderinitstatecheck', 'AdminController@getOrderStateInitCheck');

    Route::get('manager/store/{id}', 'ProjectController@getStoreCTAdminManager');

    Route::get('manager/store/{id}/item/addpage', 'ProjectController@getStoreAdminAddItemPage');

    Route::get('manager/store/{store_id}/item/{item_id}/editpage', 'ProjectController@getStoreAdminEditItemPage');
});
