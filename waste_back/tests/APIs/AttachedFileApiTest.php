<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AttachedFile;

class AttachedFileApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_attached_file()
    {
        $attachedFile = AttachedFile::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/attached_files', $attachedFile
        );

        $this->assertApiResponse($attachedFile);
    }

    /**
     * @test
     */
    public function test_read_attached_file()
    {
        $attachedFile = AttachedFile::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/attached_files/'.$attachedFile->id
        );

        $this->assertApiResponse($attachedFile->toArray());
    }

    /**
     * @test
     */
    public function test_update_attached_file()
    {
        $attachedFile = AttachedFile::factory()->create();
        $editedAttachedFile = AttachedFile::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/attached_files/'.$attachedFile->id,
            $editedAttachedFile
        );

        $this->assertApiResponse($editedAttachedFile);
    }

    /**
     * @test
     */
    public function test_delete_attached_file()
    {
        $attachedFile = AttachedFile::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/attached_files/'.$attachedFile->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/attached_files/'.$attachedFile->id
        );

        $this->response->assertStatus(404);
    }
}
