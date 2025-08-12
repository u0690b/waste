<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Resolve;

class ResolveApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_resolve()
    {
        $resolve = Resolve::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/resolves', $resolve
        );

        $this->assertApiResponse($resolve);
    }

    /**
     * @test
     */
    public function test_read_resolve()
    {
        $resolve = Resolve::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/resolves/'.$resolve->id
        );

        $this->assertApiResponse($resolve->toArray());
    }

    /**
     * @test
     */
    public function test_update_resolve()
    {
        $resolve = Resolve::factory()->create();
        $editedResolve = Resolve::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/resolves/'.$resolve->id,
            $editedResolve
        );

        $this->assertApiResponse($editedResolve);
    }

    /**
     * @test
     */
    public function test_delete_resolve()
    {
        $resolve = Resolve::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/resolves/'.$resolve->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/resolves/'.$resolve->id
        );

        $this->response->assertStatus(404);
    }
}
