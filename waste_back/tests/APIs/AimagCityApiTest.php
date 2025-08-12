<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AimagCity;

class AimagCityApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_aimag_city()
    {
        $aimagCity = AimagCity::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/aimag_cities', $aimagCity
        );

        $this->assertApiResponse($aimagCity);
    }

    /**
     * @test
     */
    public function test_read_aimag_city()
    {
        $aimagCity = AimagCity::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/aimag_cities/'.$aimagCity->id
        );

        $this->assertApiResponse($aimagCity->toArray());
    }

    /**
     * @test
     */
    public function test_update_aimag_city()
    {
        $aimagCity = AimagCity::factory()->create();
        $editedAimagCity = AimagCity::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/aimag_cities/'.$aimagCity->id,
            $editedAimagCity
        );

        $this->assertApiResponse($editedAimagCity);
    }

    /**
     * @test
     */
    public function test_delete_aimag_city()
    {
        $aimagCity = AimagCity::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/aimag_cities/'.$aimagCity->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/aimag_cities/'.$aimagCity->id
        );

        $this->response->assertStatus(404);
    }
}
