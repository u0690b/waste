<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Industry;

class IndustryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_industry()
    {
        $industry = Industry::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/industries', $industry
        );

        $this->assertApiResponse($industry);
    }

    /**
     * @test
     */
    public function test_read_industry()
    {
        $industry = Industry::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/industries/'.$industry->id
        );

        $this->assertApiResponse($industry->toArray());
    }

    /**
     * @test
     */
    public function test_update_industry()
    {
        $industry = Industry::factory()->create();
        $editedIndustry = Industry::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/industries/'.$industry->id,
            $editedIndustry
        );

        $this->assertApiResponse($editedIndustry);
    }

    /**
     * @test
     */
    public function test_delete_industry()
    {
        $industry = Industry::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/industries/'.$industry->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/industries/'.$industry->id
        );

        $this->response->assertStatus(404);
    }
}
