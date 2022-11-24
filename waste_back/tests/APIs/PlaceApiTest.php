<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Place;

class PlaceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_place()
    {
        $place = Place::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/places', $place
        );

        $this->assertApiResponse($place);
    }

    /**
     * @test
     */
    public function test_read_place()
    {
        $place = Place::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/places/'.$place->id
        );

        $this->assertApiResponse($place->toArray());
    }

    /**
     * @test
     */
    public function test_update_place()
    {
        $place = Place::factory()->create();
        $editedPlace = Place::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/places/'.$place->id,
            $editedPlace
        );

        $this->assertApiResponse($editedPlace);
    }

    /**
     * @test
     */
    public function test_delete_place()
    {
        $place = Place::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/places/'.$place->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/places/'.$place->id
        );

        $this->response->assertStatus(404);
    }
}
