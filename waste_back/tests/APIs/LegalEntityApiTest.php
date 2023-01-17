<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\LegalEntity;

class LegalEntityApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_legal_entity()
    {
        $legalEntity = LegalEntity::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/legal_entities', $legalEntity
        );

        $this->assertApiResponse($legalEntity);
    }

    /**
     * @test
     */
    public function test_read_legal_entity()
    {
        $legalEntity = LegalEntity::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/legal_entities/'.$legalEntity->id
        );

        $this->assertApiResponse($legalEntity->toArray());
    }

    /**
     * @test
     */
    public function test_update_legal_entity()
    {
        $legalEntity = LegalEntity::factory()->create();
        $editedLegalEntity = LegalEntity::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/legal_entities/'.$legalEntity->id,
            $editedLegalEntity
        );

        $this->assertApiResponse($editedLegalEntity);
    }

    /**
     * @test
     */
    public function test_delete_legal_entity()
    {
        $legalEntity = LegalEntity::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/legal_entities/'.$legalEntity->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/legal_entities/'.$legalEntity->id
        );

        $this->response->assertStatus(404);
    }
}
