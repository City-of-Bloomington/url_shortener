<?php
/**
 * @copyright 2023-2024 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @see https://auraphp.com/packages/3.x/Router
 */
declare (strict_types=1);

$ROUTES = new Aura\Router\RouterContainer(BASE_URI=='/' ? null : BASE_URI);
$map    = $ROUTES->getMap();

$map->tokens(['id' => '\d+', 'code' => sprintf('[^/]{%d,%d}', CODE_MIN, CODE_MAX)]);

$map->get('home.index',    '/'      , Web\HomeController::class);

$map->get('help.',    '/help'      , Web\HelpController::class);

$map->attach('login.', '/login', function ($r) {
    $r->get('oidc',  '/oidc', Web\Authentication\Controllers\OidcController::class);
});

$map->get('login.logout',  '/logout', Web\Authentication\Controllers\LogoutController::class);

$map->attach('urls.', '/urls', function ($r) {
    $r->get('add',    '/add'        , Web\Urls\Add\Controller::class)->allows(['POST']);
    $r->get('update', '/{id}/update', Web\Urls\Update\Controller::class)->allows(['POST']);
    $r->get('delete', '/{id}/delete', Web\Urls\Delete\Controller::class);
    $r->get('view',   '/{id}',        Web\Urls\View\Controller::class);
    $r->get('index',  ''            , Web\Urls\List\Controller::class);
});

$map->get('urls.redirect', '/{code}', Web\Urls\Redirect\Controller::class);
$map->get('urls.qrcode',   '/qrcodes/{code}.png', Web\Urls\QrCode\Controller::class);
