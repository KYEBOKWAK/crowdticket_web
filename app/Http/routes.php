<?php

Route::pattern('id', '[0-9]+');
Route::pattern('code', '[a-zA-Z0-9]+');
Route::pattern('alias', '[a-zA-Z0-9-_]+');
Route::pattern('name', '[a-zA-Z]+');
Route::pattern('entity', 'projects|comments|tickets|overcount');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('/facebook', 'Auth\SocialAuthController@redirect');
Route::get('/facebook/callback', 'Auth\SocialAuthController@callback');
Route::get('/facebook/callback/{facebookid}/{facebookName}/{facebookEmail}/{previousURL}', 'Auth\SocialAuthController@callback')->where('previousURL', '.*');

Route::get('/', 'WelcomeController@index');
Route::get('/home', 'WelcomeController@index');
Route::get('terms/', function () {
    return view('customer.terms');
});
Route::get('privacy/', function () {
    return view('customer.privacy');
});
Route::get('help/', function () {
    return view('customer.help');
});

//CREATOR Landing PAGE
Route::get('creators/', function () {
    return view('landing/landing_creator');
});

//CREATOR LANDING EMAIL form
Route::get('landing/form', function () {
    return view('landing/landing_creator_form');
});

Route::post('landing/sendmail', 'MailSendController@sendEmail');
Route::post('question/sendmail', 'MailSendController@sendQuestionEmail');
Route::get('register/sendmail', 'MailSendController@sendEmailRegister');
//


Route::get('blueprints/welcome', 'BlueprintController@getBlueprintWelcome');

Route::get('projects', 'ProjectController@getProjects');
Route::get('projects/{id}', 'ProjectController@getProjectById');
Route::get('projects/{alias}', 'ProjectController@getProjectByAlias');
Route::get('projects/{id}/alias/{alias}', 'ProjectController@checkProjectAlias');
Route::get('projects/{id}/supporters', 'ProjectController@getSupporters');
Route::get('projects/{id}/news', 'ProjectController@getNews');
Route::get('projects/{id}/comments', 'ProjectController@getComments');

Route::get('categories/{id}/projects', 'ProjectController@getCategoryProjectsById');
Route::get('categories/{title}/projects', 'ProjectController@getCategoryProjectsByTitle');

Route::get('cities/{id}/projects', 'ProjectController@getCityProjectsById');
Route::get('cities/{name}/projects', 'ProjectController@getCityProjectsByName');

Route::get('organizations', 'OrganizationController@getOrganizations');
Route::get('organizations/{id}', 'OrganizationController@getOrganization');
Route::get('organizations/{id}/members', 'MemberController@getMembers');

Route::get('{entity}/{id}/comments', 'CommentController@getComments');

Route::get('users/{id}', 'UserController@getUser');

//test URL
Route::get('projects/{id}/admin/test', 'ProjectController@test');

/*
Route::get('order/error/overticketcount', function(){
  return view('errors.overcounter_ticket');
});
*/


Route::group(['middleware' => 'auth'], function () {

    Route::get('users/{id}/form', 'UserController@getUpdateForm');
    Route::put('users/{id}', 'UserController@updateUser');
    Route::get('users/{id}/orders', 'UserController@getUserOrders');

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
    //Route::post('tickets/{id}/orders/form', 'OrderController@getOrderForm');
    Route::post('tickets/orders/form', 'OrderController@getOrderForm');
    //Route::get('projects/{id}/tickets', 'OrderController@getTickets');
    //이전 코드 getTickets
    Route::get('projects/{id}/tickets/{ticketid}', 'OrderController@getRenewalTicketsWithTicketID');
    Route::get('projects/{id}/tickets', 'OrderController@getRenewalTickets');
    Route::get('orders/{id}', 'OrderController@getOrder');
    Route::delete('orders/{id}', 'OrderController@deleteOrder');

    Route::post('{entity}/{id}/comments', 'CommentController@createComment');
    Route::delete('comments/{id}', 'CommentController@deleteComment');

    Route::post('discounts/{id}/nodiscount', 'ProjectController@setNoDiscount');
    Route::post('goods/{id}/nogoods', 'ProjectController@setNoGoods');

    Route::put('projects/{projectid}/order/{orderid}/attended', 'ProjectController@attendedOrder');
    Route::put('projects/{projectid}/order/{orderid}/unattended', 'ProjectController@unAttendedOrder');
    Route::get('projects/{projectid}/order/{orderid}/getgoodsinfo', 'OrderController@getGoodsInfo');

    Route::get('projects/{id}/attend', 'ProjectController@getAttend');
    Route::get('projects/{id}/attend/{timeunix}', 'ProjectController@getAttendedList');

    Route::get('projects/{id}/picking', 'ProjectController@getPicking');
    Route::get('projects/{id}/pickingcomplete', 'ProjectController@pickingComplete');
    Route::post('projects/{id}/addpicking/{orderid}', 'ProjectController@addPicking');
    Route::delete('projects/{id}/deletepicking/{orderid}', 'ProjectController@deletePicking');
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
});
