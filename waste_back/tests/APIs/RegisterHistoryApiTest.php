<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\RegisterHistory;

class RegisterHistoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_register_history()
    {
        $registerHistory = RegisterHistory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/register_histories', $registerHistory
        );

        $this->assertApiResponse($registerHistory);
    }

    /**
     * @test
     */
    public function test_read_register_history()
    {
        $registerHistory = RegisterHistory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/register_histories/'.$registerHistory->id
        );

        $this->assertApiResponse($registerHistory->toArray());
    }

    /**
     * @test
     */
    public function test_update_register_history()
    {
        $registerHistory = RegisterHistory::factory()->create();
        $editedRegisterHistory = RegisterHistory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/register_histories/'.$registerHistory->id,
            $editedRegisterHistory
        );

        $this->assertApiResponse($editedRegisterHistory);
    }

    /**
     * @test
     */
    public function test_delete_register_history()
    {
        $registerHistory = RegisterHistory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/register_histories/'.$registerHistory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/register_histories/'.$registerHistory->id
        );

        $this->response->assertStatus(404);
    }
}
