<?php

namespace App\Controller;

use App\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function index(Request $request,SluggerInterface $slugger): Response
    {

    $form = $this->createForm(ImageType::class);
    $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() )
            {
                $imageObject = $form->get("image")->getData();
                if($imageObject)
                    {
            $nomOriginal = pathinfo($imageObject->getClientOriginalName(),PATHINFO_FILENAME);
           $safeName    = $slugger->slug($nomOriginal);
           $newFileName = $safeName.'-'.uniqId().'.'.$imageObject->guessExtension();
           $imageObject->move($this->getParameter("images_directory"),$newFileName);
                    }
            }
  
        return $this->render('image/index.html.twig', [
            'form' => $form,
        ]);

    }

    #[Route('/image/show',name:'app_image_show',methods:['GET'])]
    public function show():Response
    {
      $directory = $this->getParameter('images_directory');
      $listeFiles = [] ;
      
            if(is_dir($directory))
                {
                        $finder = new Finder();
                        
                        $finder->files()->in($directory)->name('*.*')->depth('== 0');

                            foreach($finder as $file)
                                {
                                    $listeFiles = $file->getFilename();
                                }
                }
// dd($listeFiles);
            return $this->render('images/show.html.twig',
            [
                'fileListe'=>$listeFiles
            ]);
    }
}
