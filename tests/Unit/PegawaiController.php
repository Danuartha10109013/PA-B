<?php

namespace Tests\Unit;



use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PegawaiTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexDisplaysAllEmployees()
    {
        $response = $this->get(route('admin.kelolapegawai'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.admin.pegawai.index');
    }

    public function testAddEmployeeWithGetRequest()
    {
        Storage::fake('public');
        $avatar = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->get(route('admin.kelolapegawai.add', [
            'name' => 'John Doe',
            'username' => 'johndoe',
            'birthday' => '1990-01-01',
            'jabatan' => 'Staff',
            'no_pegawai' => 'EMP002',
            'email' => 'johndoe@example.com',
            'avatar' => $avatar,
        ]));

        $response->assertRedirect(route('admin.kelolapegawai'));
        $this->assertDatabaseHas('users', [
            'username' => 'johndoe',
            'email' => 'johndoe@example.com'
        ]);
    }

    public function testUpdateEmployeeWithGetRequest()
    {
        $user = User::factory()->create();

        $response = $this->get(route('admin.kelolapegawai.edit', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'janedoe@example.com',
            'jabatan' => 'Manager',
        ]));

        $response->assertRedirect(route('admin.kelolapegawai'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'jabatan' => 'Manager',
        ]);
    }

    public function testActivateEmployeeWithGetRequest()
    {
        $user = User::factory()->create(['active' => 0]);

        $response = $this->get(route('admin.kelolapegawai.active', $user->id));

        $response->assertRedirect(route('admin.kelolapegawai'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'active' => 1,
        ]);
    }

    public function testDeactivateEmployeeWithGetRequest()
    {
        $user = User::factory()->create(['active' => 1]);

        $response = $this->get(route('admin.kelolapegawai.nonactive', $user->id));

        $response->assertRedirect(route('admin.kelolapegawai'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'active' => 0,
        ]);
    }

    public function testDeleteEmployeeWithGetRequest()
    {
        $user = User::factory()->create();

        $response = $this->get(route('admin.kelolapegawai.delete', $user->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
