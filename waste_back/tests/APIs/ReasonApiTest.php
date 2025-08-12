<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Reason;

class ReasonApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_reason()
    {
        $reason = Reason::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/reasons', $reason
        );

        $this->assertApiResponse($reason);
    }

    /**
     * @test
     */
    public function test_read_reason()
    {
        $reason = Reason::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/reasons/'.$reason->id
        );

        $this->assertApiResponse($reason->toArray());
    }

    /**
     * @test
     */
    public function test_update_reason()
    {
        $reason = Reason::factory()->create();
        $editedReason = Reason::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/reasons/'.$reason->id,
            $editedReason
        );

        $this->assertApiResponse($editedReason);
    }

    /**
     * @test
     */
    public function test_delete_reason()
    {
        $reason = Reason::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/reasons/'.$reason->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/reasons/'.$reason->id
        );

        $this->response->assertStatus(404);
    }
}
