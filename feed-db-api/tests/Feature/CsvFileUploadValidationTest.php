<?php

namespace Tests\Feature;

use Tests\TestCase;

class CsvFileUploadValidationTest extends TestCase
{
    /**
     * @test
     */
    public function it_return_422_error_when_file_field_is_empty()
    {
        $response = $this->json('post', route('csv_feeder'), []);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_return_422_error_when_file_field_is_not_a_successfully_uploaded_file()
    {
        $response = $this->json('post', route('csv_feeder'), [
            'file' => 'store',
        ]);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_return_422_error_when_file_field_is_not_a_type_of_csv()
    {
        $file = Helpers::generateFakeFile('data.pdf');

        $response = $this->json('post', route('csv_feeder'), [
            'file' => $file,
        ]);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
}
