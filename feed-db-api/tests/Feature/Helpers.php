<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;

class Helpers
{
    public static function generateFakeFile(string $name, int $number = 1024, string $type = 'csv')
    {
        return UploadedFile::fake()->create($name, $number, $type);
    }
}
