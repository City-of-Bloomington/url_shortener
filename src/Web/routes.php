<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @see https://docs.laminas.dev/laminas-permissions-acl
 */
declare (strict_types=1);

$ROUTES = new Aura\Router\RouterContainer(BASE_URI);
$map    = $ROUTES->getMap();

$map->tokens(['id' => '\d+']);

$map->get('home.index',    '/'      , Web\HomeController::class);

$map->attach('login.', '/login', function ($r) {
    $r->get('oidc',  '/oidc', Web\Authentication\Controllers\OidcController::class);
});

$map->get('login.logout',  '/logout', Web\Authentication\Controllers\LogoutController::class);

$map->attach('urls.', '/urls', function ($r) {
    $r->get('add',    '/add'        , Web\Urls\Controllers\AddController::class)->allows(['POST']);
    $r->get('update', '/{id}/update', Web\Urls\Controllers\UpdateController::class)->allows(['POST']);
    $r->get('delete', '/{id}/delete', Web\Urls\Controllers\DeleteController::class);
    $r->get('view',   '/{id}',        Web\Urls\Controllers\ViewController::class);
    $r->get('index',  ''            , Web\Urls\Controllers\ListController::class);
});
