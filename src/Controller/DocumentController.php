<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DocumentController extends AbstractController
{
    #[Route('/document', name: 'app_document')]
    public function listPdfs(): Response
    {

$uploadDir = $this->getParameter('brochures_directory');
$pdfFiles = [];

// dd($uploadDir);

if(is_dir($uploadDir))
    {
            $finder = new Finder();
            $finder->files()->in($uploadDir)->name('*.pdf')->depth('== 0');

            foreach($finder as $file)
                {
                    $pdfFiles[] = $file->getFilename() ;
                }
    }


        return $this->render('document/index.html.twig', [
          'pdf_file' => $pdfFiles
        ]);
    }
}
