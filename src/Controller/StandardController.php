<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StandardController extends AbstractController
{
    protected function savePictureFile(FormInterface $form): string|bool
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $form['pictureFile']->getData();

        if ($uploadedFile) {
            $subImgFolder = strtolower(get_called_class());
            $subImgFolder = preg_replace('/[^a-z0-9 -]+/', '', $subImgFolder);
            $subImgFolder = str_replace(['app', 'controller'], '', $subImgFolder) . 's';

            $destinationFolder = $this->getParameter('kernel.project_dir') . '/public/images/' . $subImgFolder;
            $pictureName = uniqid() . '.' . $uploadedFile->guessExtension();
            $uploadedFile->move($destinationFolder, $pictureName);

            return $pictureName;
        }
        return false;
    }
}