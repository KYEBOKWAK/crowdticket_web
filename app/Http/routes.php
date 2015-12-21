<?php

Route::pattern('id', '[0-9]+');
Route::pattern('code', '[a-zA-Z0-9]+');
Route::pattern('alias', '[a-zA-Z0-9-_]+');
Route::pattern('name', '[a-zA-Z]+');
Route::pattern('entity', 'projects|comments');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('/facebook', 'Auth\SocialAuthController@redirect');
Route::get('/facebook/callback', 'Auth\SocialAuthController@callback');

Route::get('/', 'WelcomeController@index');
Route::get('terms/', function() { return view('customer.terms'); });
Route::get('privacy/', function() { return view('customer.privacy'); });
Route::get('help/', function() { return view('customer.help'); });

Route::get('blueprints/welcome', 'BlueprintController@getBlueprintWelcome');

Route::get('projects', 'ProjectController@getProjects');
Route::get('projects/{id}', 'ProjectController@getProjectById');
Route::get('projects/{alias}', 'ProjectController@getProjectByAlias');
Route::get('projects/{alias}/validity', 'ProjectController@validateProjectAlias');
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
Route::get('users/{id}/orders', 'UserController@getUserOrders');
Route::get('users/{id}/projects', 'UserController@getUserProjects');

Route::group(['middleware' => 'auth'], function() {
	
	Route::get('users/{id}/form', 'UserController@getUpdateForm');
	Route::put('users/{id}', 'UserController@updateUser');
	
	Route::post('blueprints', 'BlueprintController@createBlueprint'); 
	Route::get('blueprints/form', 'BlueprintController@getCreateForm'); 
	
	Route::get('projects/form/{id}', 'ProjectController@getUpdateFormById');
	Route::get('projects/form/{code}', 'ProjectController@getUpdateFormByCode');
	Route::put('projects/{id}', 'ProjectController@updateProject');
	Route::put('projects/{id}/story/images', 'ProjectController@uploadStoryImage');
	Route::put('projects/{id}/news/images', 'ProjectController@uploadNewsImage');
	Route::put('projects/{id}/submit', 'ProjectController@submitProject');
	Route::get('projects/{id}/stats', 'ProjectController@getStats');
	Route::get('projects/{id}/orders', 'ProjectController@getOrders'); 
	
	Route::post('projects/{id}/tickets', 'TicketController@createTicket');
	Route::put('tickets/{id}', 'TicketController@updateTicket');
	Route::delete('tickets/{id}', 'TicketController@deleteTicket');
	 
	Route::post('projects/{id}/news', 'NewsController@createNews');
	Route::get('projects/{id}/news/form', 'NewsController@getCreateForm');
	Route::get('news/{id}/form', 'NewsController@getUpdateForm');
	Route::put('news/{id}', 'NewsController@updateNews');
	Route::delete('news/{id}', 'NewsController@deleteNews');
	
	Route::post('tickets/{id}/orders', 'OrderController@createOrder'); 
	Route::get('tickets/{id}/orders', 'OrderController@getTicketOrders');
	Route::post('tickets/{id}/orders/form', 'OrderController@getOrderForm');
	Route::get('projects/{id}/tickets', 'OrderController@getTickets');
	Route::delete('orders/{id}', 'OrderController@deleteOrder'); 
	
	Route::post('{entity}/{id}/comments', 'CommentController@createComment');
	Route::delete('comments/{id}', 'CommentController@deleteComment'); 
	
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
	
	Route::get('/', 'AdminController@getDashboard');
	Route::put('blueprints/{id}/approval', 'AdminController@approveBlueprint');
	Route::put('projects/{id}/rejection', 'AdminController@rejectProject');
	Route::put('projects/{id}/approval', 'AdminController@approveProject');
	Route::put('order/{id}/approval', 'Adm11111111111111inController@approveOrder');
	
});
