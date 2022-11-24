<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SoumDistrict;

class SoumDistrictApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_soum_district()
    {
        $soumDistrict = SoumDistrict::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/soum_districts', $soumDistrict
        );

        $this->assertApiResponse($soumDistrict);
    }

    /**
     * @test
     */
    public function test_read_soum_district()
    {
        $soumDistrict = SoumDistrict::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/soum_districts/'.$soumDistrict->id
        );

        $this->assertApiResponse($soumDistrict->toArray());
    }

    /**
     * @test
     */
    public function test_update_soum_district()
    {
        $soumDistrict = SoumDistrict::factory()->create();
        $editedSoumDistrict = SoumDistrict::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/soum_districts/'.$soumDistrict->id,
            $editedSoumDistrict
        );

        $this->assertApiResponse($editedSoumDistrict);
    }

    /**
     * @test
     */
    public function test_delete_soum_district()
    {
        $soumDistrict = SoumDistrict::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/soum_districts/'.$soumDistrict->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/soum_districts/'.$soumDistrict->id
        );

        $this->response->assertStatus(404);
    }
}
