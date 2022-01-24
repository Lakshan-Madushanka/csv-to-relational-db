<?php

namespace Tests\Feature;

use App\Services\FileUpload;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadServiceTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_successfully_store_a_valid_csv_file_using_fileUpload_service()
    {
        //Storage::fake('local');

        $uploadService = new FileUpload();

        $file = Helpers::generateFakeFile('data.csv');

        $path = 'private/uploads/db_feeder/csv';

        $fileName = $uploadService->storeFile($file, $path);

        $this->assertNotNull($fileName);

        Storage::disk('local')->assertExists($path);
    }
}
