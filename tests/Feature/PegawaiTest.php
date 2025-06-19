<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PegawaiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user to authenticate
        $this->user = User::factory()->create([
            'username' => 'johndoe', // Ensure username is set
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
            'active' => 1, // Assuming your active field exists
            'no_pegawai'=>'no1',
            'jabatan' => 'bela',
            'alamat'=>'no1',
            'role'=>1,
        ]);
    }

    public function testIndexDisplaysAllEmployees()
    {
        $this->actingAs($this->user);

        // Optionally, create some employee records for testing
        User::factory()->count(5)->create();

        $response = $this->get(route('admin.kelolapegawai'));
        
        // Assert that the response status is OK
        $response->assertStatus(200);
        
        // Assert that the correct view is returned
        $response->assertViewIs('pages.admin.pegawai.index');
        
        // Assert that the view contains the data
        $response->assertViewHas('data');
        $response->assertViewHas('nopegawai');

        // Check that the data contains the employees created
        $employees = User::all();
        foreach ($employees as $employee) {
            $response->assertSee($employee->name);
            $response->assertSee($employee->username);
            $response->assertSee($employee->email);
            $response->assertSee($employee->no_pegawai);
            $response->assertSee($employee->role);
        }

        // Check the newly generated employee number
        $lastUser = User::orderBy('no_pegawai', 'desc')->first();
        if ($lastUser) {
            $lastNoPegawai = intval(substr($lastUser->no_pegawai, 3));
            $newNoPegawai = 'EMP' . str_pad($lastNoPegawai + 1, 3, '0', STR_PAD_LEFT);
            $response->assertSee($newNoPegawai);
        } else {
            $response->assertSee('EMP001');
        }
    }

    public function testAddEmployeeWithPostRequest()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('admin.kelolapegawai.add'), [
            'username' => 'newuser',
            'name' => 'New User',
            'birthday' => '1990-01-01',
            'jabatan' => 'Staff',
            'no_pegawai' => 'EMP002',
            'email' => 'newuser@example.com',
            'avatar' => null, // Assume no avatar for simplicity
            'no_pegawai'=>'no1',
            'jabatan' => 'bela',
            'alamat'=>'no1',
            'role'=>1,
        ]);

        $response->assertRedirect(route('admin.kelolapegawai'));
        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
            'email' => 'newuser@example.com'
        ]);
    }

    public function testUpdateEmployeeWithPostRequest()
    {
        $this->actingAs($this->user);
        $employee = User::factory()->create([
            'username' => 'existinguser',
            'email' => 'existinguser@example.com',
            'jabatan' => 'Staff',
            'no_pegawai'=>'no1',
            'jabatan' => 'bela',
            'alamat'=>'no1',
            'role'=>1,

        ]);

        $response = $this->post(route('admin.kelolapegawai.update', $employee->id), [
            'username' => 'updateduser',
            'name' => 'Updated User',
            'jabatan' => 'Senior Staff',
            'email' => 'updateduser@example.com',
            'avatar' => null, // Assume no avatar for simplicity
        ]);

        $response->assertRedirect(route('admin.kelolapegawai'));
        $this->assertDatabaseHas('users', [
            'username' => 'updateduser',
            'email' => 'updateduser@example.com'
        ]);
    }

    public function testActivateEmployee()
    {
        $this->actingAs($this->user);
        $employee = User::factory()->create(['active' => 0]);

        $response = $this->post(route('admin.kelolapegawai.activate', $employee->id));
        
        $response->assertRedirect(route('admin.kelolapegawai'));
        $this->assertDatabaseHas('users', [
            'id' => $employee->id,
            'active' => 1,
        ]);
    }

    public function testDeactivateEmployee()
    {
        $this->actingAs($this->user);
        $employee = User::factory()->create(['active' => 1]);

        $response = $this->post(route('admin.kelolapegawai.deactivate', $employee->id));
        
        $response->assertRedirect(route('admin.kelolapegawai'));
        $this->assertDatabaseHas('users', [
            'id' => $employee->id,
            'active' => 0,
        ]);
    }

    public function testDeleteEmployee()
    {
        $this->actingAs($this->user);
        $employee = User::factory()->create();

        $response = $this->post(route('admin.kelolapegawai.delete', $employee->id));
        
        $response->assertRedirect(route('admin.kelolapegawai'));
        $this->assertDatabaseMissing('users', [
            'id' => $employee->id,
        ]);
    }
}
