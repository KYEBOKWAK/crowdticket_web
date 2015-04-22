<?php

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::post('blueprints', 'BlueprintController@createBlueprint'); // user
Route::get('blueprints/form', 'BlueprintController@getBlueprintForm'); // user
Route::get('blueprints', 'BlueprintController@getBlueprints'); // admin
Route::get('blueprints/{id}', 'BlueprintController@getBlueprint'); // admin
Route::put('blueprints/{id}/approval', 'BlueprintController@approveBlueprint'); // admin

Route::get('categories/{id}/projects', 'ProjectController@getCategoryProjectsById');
Route::get('categories/{title}/projects', 'ProjectController@getCategoryProjectsByTitle');
Route::get('cities/{id}/projects', 'ProjectController@getCityProjectsById');
Route::get('cities/{name}/projects', 'ProjectController@getCityProjectsByName');

Route::post('projects', 'ProjectController@createProject'); // approved
Route::get('projects/form', 'ProjectController@getProjectForm'); // approved
Route::get('projects', 'ProjectController@getProjects');
Route::get('projects/{id}', 'ProjectController@getProject');
Route::get('projects/{id}/supporters', 'ProjectController@getProjectSupporters');
Route::get('projects/{id}/orders', 'ProjectController@getProjectOrders'); // master
Route::get('projects/{id}/stats', 'ProjectController@getProjectStats'); // master
Route::put('projects/{id}', 'ProjectController@updateProject'); // master
Route::put('projects/{id}/approval', 'ProjectController@approveProject'); // admin

Route::post('projects/{id}/news', 'NewsController@createNews'); // master
Route::get('projects/{id}/news', 'NewsController@getNews');

Route::post('tickets/{id}/orders', 'OrderController@createOrder'); // user
Route::delete('orders/{id}', 'OrderController@deleteOrder'); // user

Route::get('organizations', 'OrganizationController@getOrganizations');
Route::get('organizations/{id}', 'OrganizationController@getOrganization');
Route::get('organizations/{id}/members', 'MemberController@getMembers');

Route::get('users/{id}', 'UserController@getUser');
Route::get('users/{id}/orders', 'UserController@getUserOrders');
Route::get('users/{id}/projects', 'UserController@getUserProjects');

Route::post('{entity}/{id}/comments', 'CommentController@createComment'); // user
Route::get('{entity}/{id}/comments', 'CommentController@getComments');
Route::delete('comments/{id}', 'CommentController@deleteComment'); // master
