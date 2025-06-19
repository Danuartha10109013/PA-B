<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsLoginView()
    {
        $response = $this->get(route('auth.login'));
        $response->assertViewIs('auth.login');
    }

    public function testLoginProsesWithInactiveUser()
    {
        $user = User::factory()->create([
            'username' => 'bela',
            'name' => 'bela',
            'jabatan' => 'bela',
            'no_pegawai'=>'no1',
            'alamat'=>'no1',
            'email' => 'inactive@example.com',
            'password' => Hash::make('password123'),
            'active' => 0,
            'role' => 1,
        ]);

        Auth::shouldReceive('attempt')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $response = $this->post(route('login-proses'), [
            'username' => 'inactive@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('auth.login'));
        $response->assertSessionHas('error', 'Your Account was inactive, contact your admin');
    }

    public function testLoginProsesForAdminUser()
    {
        $user = User::factory()->create([
            'username' => 'bela',
            'name' => 'bela',
            'no_pegawai'=>'no1',
            'jabatan' => 'bela',
            'alamat'=>'no1',

            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 0,
            'active' => 1,
        ]);

        Auth::shouldReceive('attempt')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $response = $this->post(route('login-proses'), [
            'username' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success', 'Login Success, Hallo ' . $user->name);
    }

    public function testLoginProsesForPegawaiUser()
    {
        $user = User::factory()->create([
            'username' => 'bela',
            'name' => 'bela',
            'no_pegawai'=>'no1',
            'jabatan' => 'bela',
            'alamat'=>'no1',

            'email' => 'pegawai@example.com',
            'password' => Hash::make('password123'),
            'role' => 1,
            'active' => 1,
        ]);

        Auth::shouldReceive('attempt')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $response = $this->post(route('login-proses'), [
            'username' => 'pegawai@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('pegawai.dashboard'));
        $response->assertSessionHas('success', 'Login Success, Hallo ' . $user->name);
    }

    public function testLoginProsesForAtasanUser()
    {
        $user = User::factory()->create([
            'username' => 'bela',
            'name' => 'bela',
            'no_pegawai'=>'no1',
            'jabatan' => 'bela',
            'alamat'=>'no1',

            'email' => 'atasan@example.com',
            'password' => Hash::make('password123'),
            'role' => 2,
            'active' => 1,
        ]);

        Auth::shouldReceive('attempt')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $response = $this->post(route('login-proses'), [
            'username' => 'atasan@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('atasan.dashboard'));
        $response->assertSessionHas('success', 'Login Success, Hallo ' . $user->name);
    }

    public function testLoginProsesWithInvalidCredentials()
    {
        Auth::shouldReceive('attempt')->andReturn(false);

        $response = $this->post(route('login-proses'), [
            'username' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect(route('auth.login'));
        $response->assertSessionHas('error', 'Username atau Password anda salah!');
    }

    public function testLogout()
    {
        Auth::shouldReceive('logout')->once();

        $response = $this->get(route('logout'));

        $response->assertRedirect(route('auth.login'));
        $response->assertSessionHas('success', 'Kamu berhasil Logout');
    }

    // Example assertions for data types and specific cases
    public function testAssertions()
    {
        $this->assertEquals(100, 100);
        $this->assertEqualsCanonicalizing([1, 2, 3], [3, 2, 1]);
        $this->assertEqualsIgnoringCase('Laravel', 'laravel');
        $this->assertEqualsWithDelta(10.0, 10.5, 0.5);
        $this->assertIsNumeric('123');
        $this->assertIsInt(10);
        $this->assertIsFloat(10.5);
        $this->assertNan(NAN);
    }
}
