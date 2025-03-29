<?php

namespace App\Domain\Image\ValueObjects;

enum ImageType: string
{
    case AVATAR = 'avatar';
    case GALLERY = 'gallery';
}
