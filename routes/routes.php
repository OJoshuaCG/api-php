<?php

// routes.php
Router::get('/users', 'UserController@getAll');
Router::get('/users/{id}', 'UserController@getOne');
Router::post('/users', 'UserController@create');
Router::put('/users/{id}', 'UserController@update');
Router::delete('/users/{id}', 'UserController@delete');