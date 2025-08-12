<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UsersModel;

class UsersModelApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_users_model()
    {
        $usersModel = UsersModel::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/users_models', $usersModel
        );

        $this->assertApiResponse($usersModel);
    }

    /**
     * @test
     */
    public function test_read_users_model()
    {
        $usersModel = UsersModel::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/users_models/'.$usersModel->id
        );

        $this->assertApiResponse($usersModel->toArray());
    }

    /**
     * @test
     */
    public function test_update_users_model()
    {
        $usersModel = UsersModel::factory()->create();
        $editedUsersModel = UsersModel::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/users_models/'.$usersModel->id,
            $editedUsersModel
        );

        $this->assertApiResponse($editedUsersModel);
    }

    /**
     * @test
     */
    public function test_delete_users_model()
    {
        $usersModel = UsersModel::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/users_models/'.$usersModel->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/users_models/'.$usersModel->id
        );

        $this->response->assertStatus(404);
    }
}
