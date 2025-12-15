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
$router->get('/getbarbeiros', 'BarbeiroController@getBarbeiros'); 
$router->get('/getbarbeirosativos', 'BarbeiroController@getBarbeirosAtivos');
$router->post('/cadbarbeiro', 'BarbeiroController@cadastro');
$router->post('/updateSituacaoBarbeiro', 'BarbeiroController@updateSituacaoBarbeiro');
$router->post('/editarbarbeiro', 'BarbeiroController@editar');

// Serviços
$router->get('/servicos', 'ServicoController@index');
$router->get('/getservicos', 'ServicoController@getServicos');
$router->get('/getservicosativos', 'ServicoController@getServicosAtivos');
$router->post('/cadServico', 'ServicoController@cadastro');
$router->post('/editarservico', 'ServicoController@editar');
$router->post('/updateSituacaoServico', 'ServicoController@updateSituacao');

// Agendamentos
$router->get('/agendamentos', 'AgendamentoController@index');