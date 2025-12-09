<?php
use core\Router;

$router = new Router();

// Login
$router->get('/', 'LoginController@index');
$router->post('/logar', 'LoginController@logar');
$router->get('/deslogar', 'LoginController@deslogar');

// Início
$router->get('/inicio', 'InicioController@index');

// Cadastro de Usuário
$router->get('/usuario', 'UsuarioController@index');
$router->post('/cadusuario', 'UsuarioController@cadastro');
$router->get('/getusuarios', 'UsuarioController@getUsuarios');
$router->post('/updatesituacaousuario', 'UsuarioController@updateSituacaoUsuario');
$router->post('/editarusuario', 'UsuarioController@editar');

// Barbeiros
$router->get('/barbeiros', 'BarbeiroController@index'); 

// Serviços
$router->get('/servicos', 'ServicoController@index');

// Agendamentos
$router->get('/agendamentos', 'AgendamentoController@index');