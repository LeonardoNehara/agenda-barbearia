<?php
use core\Router;

$router = new Router();

// Login
$router->get('/', 'LoginController@index');
$router->post('/logar', 'LoginController@logar');
$router->get('/deslogar', 'LoginController@deslogar');

// Cadastro de Usuário
$router->get('/usuario', 'UsuarioController@index');

// Barbeiros
$router->get('/barbeiros', 'BarbeiroController@index');  