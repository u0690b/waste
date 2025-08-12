<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Register;

class RegisterApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_register()
    {
        $register = Register::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/registers', $register
        );

        $this->assertApiResponse($register);
    }

    /**
     * @test
     */
    public function test_read_register()
    {
        $register = Register::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/registers/'.$register->id
        );

        $this->assertApiResponse($register->toArray());
    }

    /**
     * @test
     */
    public function test_update_register()
    {
        $register = Register::factory()->create();
        $editedRegister = Register::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/registers/'.$register->id,
            $editedRegister
        );

        $this->assertApiResponse($editedRegister);
    }

    /**
     * @test
     */
    public function test_delete_register()
    {
        $register = Register::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/registers/'.$register->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/registers/'.$register->id
        );

        $this->response->assertStatus(404);
    }
}
