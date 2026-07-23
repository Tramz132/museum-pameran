<?php

namespace Tests\Feature;

use App\Models\LoanRequest;
use App\Models\MuseumItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MuseumPameranTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_redirection_based_on_role_after_login(): void
    {
        // 1. Admin login redirect
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        $response->assertRedirect(route('admin.dashboard'));

        // Logout
        $this->post('/logout');

        // 2. Staff login redirect
        $staff = User::factory()->create(['role' => 'staff']);
        $response = $this->post('/login', [
            'email' => $staff->email,
            'password' => 'password',
        ]);
        $response->assertRedirect(route('staff.dashboard'));

        // Logout
        $this->post('/logout');

        // 3. Panitia login redirect
        $panitia = User::factory()->create(['role' => 'panitia']);
        $response = $this->post('/login', [
            'email' => $panitia->email,
            'password' => 'password',
        ]);
        $response->assertRedirect(route('panitia.dashboard'));
    }

    public function test_role_middleware_blocks_unauthorized_access(): void
    {
        $panitia = User::factory()->create(['role' => 'panitia']);
        
        // Panitia tries to access admin dashboard -> redirected to panitia dashboard
        $response = $this->actingAs($panitia)->get(route('admin.dashboard'));
        $response->assertRedirect(route('panitia.dashboard'));
        
        $staff = User::factory()->create(['role' => 'staff']);
        
        // Staff tries to access admin dashboard -> redirected to staff dashboard
        $response = $this->actingAs($staff)->get(route('admin.dashboard'));
        $response->assertRedirect(route('staff.dashboard'));
    }

    public function test_panitia_can_view_catalog_and_request_loan(): void
    {
        $panitia = User::factory()->create(['role' => 'panitia']);
        $item = MuseumItem::factory()->create(['status' => 'Tersedia']);

        // Can view catalog
        $response = $this->actingAs($panitia)->get(route('panitia.catalog'));
        $response->assertStatus(200);

        // Can submit loan request
        $response = $this->actingAs($panitia)->post(route('panitia.loan-requests.store'), [
            'museum_item_id' => $item->id,
            'nama_acara' => 'Pameran Seni Modern',
            'lokasi' => 'Galeri Nasional',
            'tanggal_mulai' => now()->addDays(2)->toDateString(),
            'tanggal_selesai' => now()->addDays(5)->toDateString(),
        ]);

        $response->assertRedirect(route('panitia.loan-requests.index'));
        $this->assertDatabaseHas('loan_requests', [
            'nama_acara' => 'Pameran Seni Modern',
            'status' => 'Pending',
        ]);
    }

    public function test_staff_can_approve_loan_request(): void
    {
        $panitia = User::factory()->create(['role' => 'panitia']);
        $staff = User::factory()->create(['role' => 'staff']);
        $item = MuseumItem::factory()->create(['status' => 'Tersedia']);
        
        $loanRequest = LoanRequest::factory()->create([
            'museum_item_id' => $item->id,
            'user_id' => $panitia->id,
            'status' => 'Pending',
        ]);

        // Staff approves loan
        $response = $this->actingAs($staff)->patch(route('staff.verifications.verify', $loanRequest), [
            'status' => 'Approved',
            'catatan' => 'Berkas lengkap.',
        ]);

        $response->assertRedirect(route('staff.verifications.index'));
        $this->assertDatabaseHas('loan_requests', [
            'id' => $loanRequest->id,
            'status' => 'Approved',
            'approved_by' => $staff->id,
        ]);
        
        $this->assertEquals('Dipinjam', $item->fresh()->status);
    }
}
