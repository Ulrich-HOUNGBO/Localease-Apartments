<?php
// api/src/Controller/CreateIllustrationAction.php
namespace App\Controller;
use App\Entity\Illustration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
#[AsController]
final class CreateIllustrationAction extends AbstractController
{
    public function __invoke(Request $request): Illustration
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }
        $illustration = new Illustration();
        $illustration->file = $uploadedFile;
        return $illustration;
    }
}
