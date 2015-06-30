<?php

Route::pattern('id', '[0-9]+');
Route::pattern('code', '[a-zA-Z0-9]+');
Route::pattern('name', '[a-zA-Z0-9]+');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('blueprints/welcome', 'BlueprintController@getBlueprintWelcome');

Route::get('projects', 'ProjectController@getProjects');
Route::get('projects/{id}', 'ProjectController@getProjectById');
Route::get('projects/{name}', 'ProjectController@getProjectByName');
Route::get('projects/{id}/supporters', 'ProjectController@getProjectSupporters');

Route::get('projects/{id}/news', 'NewsController@getNews');

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
	
	Route::post('blueprints', 'BlueprintController@createBlueprint'); 
	Route::get('blueprints/form', 'BlueprintController@getCreateForm'); 
	
	Route::get('projects/form/{id}', 'ProjectController@getUpdateFormById');
	Route::get('projects/form/{code}', 'ProjectController@getUpdateFormByCode');
	Route::put('projects/{id}', 'ProjectController@updateProject'); 
	Route::get('projects/{id}/orders', 'ProjectController@getProjectOrders'); 
	Route::get('projects/{id}/stats', 'ProjectController@getProjectStats');
	 
	Route::post('projects/{id}/news', 'NewsController@createNews'); 
	
	Route::post('tickets/{id}/orders', 'OrderController@createOrder'); 
	Route::delete('orders/{id}', 'OrderController@deleteOrder'); 
	
	Route::post('{entity}/{id}/comments', 'CommentController@createComment'); 
	Route::delete('comments/{id}', 'CommentController@deleteComment'); 
	
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
	
	Route::get('/', 'AdminController@getDashboard');
	Route::put('blueprints/{id}/approval', 'AdminController@approveBlueprint');
	Route::put('projects/{id}/rejection', 'AdminController@rejectProject');
	Route::put('projects/{id}/approval', 'AdminController@approveProject');
	
});
