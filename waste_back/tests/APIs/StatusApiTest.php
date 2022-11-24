<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Status;

class StatusApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_status()
    {
        $status = Status::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/statuses', $status
        );

        $this->assertApiResponse($status);
    }

    /**
     * @test
     */
    public function test_read_status()
    {
        $status = Status::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/statuses/'.$status->id
        );

        $this->assertApiResponse($status->toArray());
    }

    /**
     * @test
     */
    public function test_update_status()
    {
        $status = Status::factory()->create();
        $editedStatus = Status::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/statuses/'.$status->id,
            $editedStatus
        );

        $this->assertApiResponse($editedStatus);
    }

    /**
     * @test
     */
    public function test_delete_status()
    {
        $status = Status::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/statuses/'.$status->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/statuses/'.$status->id
        );

        $this->response->assertStatus(404);
    }
}
