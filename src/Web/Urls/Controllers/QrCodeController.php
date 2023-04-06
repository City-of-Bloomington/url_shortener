<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\Controllers;

use Web\Controller;
use Web\View;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCodeController extends Controller
{
    public function __invoke(array $params): View
    {
        $repo = $this->di->get('Domain\Urls\DataStorage\UrlsRepository');
        try {
            $url      = $repo->load($params['code']);
            $renderer = new ImageRenderer(new RendererStyle(QR_SIZE), new ImagickImageBackEnd());
            $writer   = new Writer($renderer);

            $writer->writeFile(View::generateUrl('urls.redirect', ['code'=>$url->code]),
                               SITE_HOME."/qrcodes/{$url->code}.png");
            header('Location: '.View::generateUrl('urls.qrcode', ['code'=>$url->code]));
            exit();
        }
        catch (\Exception $e) {
            return new \Web\Views\NotFoundView();
        }
    }
}
