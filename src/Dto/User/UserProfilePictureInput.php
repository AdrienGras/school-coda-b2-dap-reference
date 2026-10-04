<?php

namespace App\Dto\User;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

final class UserProfilePictureInput
{
    public function __construct(
        // null quand le client n'a envoyé aucune partie `file` : c'est la validation qui le lui dit
        #[Assert\NotNull]
        #[Assert\Image(maxSize: '2M', mimeTypes: ['image/jpeg', 'image/png', 'image/webp'])]
        public ?UploadedFile $file,
    ) {
    }
}
