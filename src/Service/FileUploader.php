<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader {

    public function __construct(
        private string $imgDirectory,
        private SluggerInterface $slugger
    ) {
    }

    public function upload(UploadedFile $file): string {
        $originalFilename = pathinfo($file -> getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this -> slugger -> slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file -> guessExtension();

        try {
            $file -> move($this -> getImgDirectory(), $fileName);
        } catch (FileException $e) {
            throw $e('Impossible de télécharger le fichier');
        }

        return $fileName;
    }

    public function getImgDirectory(): string {
        return $this -> imgDirectory;
    }
}

?>