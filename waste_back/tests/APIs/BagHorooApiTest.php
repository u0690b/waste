<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BagHoroo;

class BagHorooApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_bag_horoo()
    {
        $bagHoroo = BagHoroo::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/bag_horoos', $bagHoroo
        );

        $this->assertApiResponse($bagHoroo);
    }

    /**
     * @test
     */
    public function test_read_bag_horoo()
    {
        $bagHoroo = BagHoroo::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/bag_horoos/'.$bagHoroo->id
        );

        $this->assertApiResponse($bagHoroo->toArray());
    }

    /**
     * @test
     */
    public function test_update_bag_horoo()
    {
        $bagHoroo = BagHoroo::factory()->create();
        $editedBagHoroo = BagHoroo::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/bag_horoos/'.$bagHoroo->id,
            $editedBagHoroo
        );

        $this->assertApiResponse($editedBagHoroo);
    }

    /**
     * @test
     */
    public function test_delete_bag_horoo()
    {
        $bagHoroo = BagHoroo::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/bag_horoos/'.$bagHoroo->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/bag_horoos/'.$bagHoroo->id
        );

        $this->response->assertStatus(404);
    }
}
