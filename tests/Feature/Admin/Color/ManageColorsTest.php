<?php

namespace Tests\Feature\Admin\Color;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageColorsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_be_redirected_when_not_authenticate(): void {
        $response = $this->get(route('admin.colors.index'));

        $response->assertStatus(302);
        $response->assertRedirectToRoute('login');
    }

    public function test_403_page_be_rendered_when_user_is_not_staff_or_admin(): void {
        $user = User::create([
            'name' => 'Test user 1',
            'email' => 'email1@gmail.com',
            'role' => 'CUSTOMER'
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.colors.index'));

        $response->assertStatus(403);
    }

    public function test_staff_or_admin_can_view_manage_colors_page(): void {
        $user = User::create([
            'name' => 'Test user 1',
            'email' => 'email1@gmail.com',
            'role' => 'STAFF'
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.colors.index'));

        $response->assertStatus(200);
    }

    public function test_create_color_success(): void {
        $user = User::create([
            'name' => 'Test user 1',
            'email' => 'email1@gmail.com',
            'role' => 'STAFF'
        ]);

        $response = $this->actingAs($user)
            ->post(
                route('admin.colors.store'),
                [
                    '_token' => csrf_token(),
                    'name' => 'Đen',
                    'hex_code' => '#121212'
                ]
            );

        $response->assertStatus(302);
        $response->assertRedirectToRoute('admin.colors.index');
        $response->assertSessionHas('success');
    }

    public function test_create_color_failed_if_missing_field(): void {
        $user = User::create([
            'name' => 'Test user 1',
            'email' => 'email1@gmail.com',
            'role' => 'STAFF'
        ]);

        $response = $this->actingAs($user)
            ->post(
                route('admin.colors.store'),
                [
                    '_token' => csrf_token(),
                    'hex_code' => '#121212'
                ]
            );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
    }
}
