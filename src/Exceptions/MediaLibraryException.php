<?php

namespace TahirRasheed\LaravelSettings\Exceptions;

use Exception;

class MediaLibraryException extends Exception
{
    public static function install(): self
    {
        return new self("You must install & configure laravel media library package.");
    }
}
