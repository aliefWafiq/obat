<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityAndMaintenanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Ensure cache is cleared before each test
        \Illuminate\Support\Facades\Cache::flush();
    }

    /**
     * Test guest redirection for protected routes.
     */
    public function test_guest_is_redirected_to_login_for_protected_routes(): void
    {
        // Try accessing home
        $response = $this->get('/home');
        $response->assertRedirect('/');

        // Try accessing dashboard
        $response = $this->get('/dashboard');
        $response->assertRedirect('/');

        // Try accessing an admin action
        $response = $this->post('/category/create', ['categoryName' => 'Test']);
        $response->assertRedirect('/');
    }

    /**
     * Test normal user access control.
     */
    public function test_normal_user_can_access_home_but_not_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'User']);

        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);

        // Try accessing dashboard
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertRedirect('/home');
        $response->assertSessionHas('error', 'Anda tidak memiliki akses ke halaman ini.');

        // Try accessing category create action
        $response = $this->actingAs($user)->post('/category/create', ['categoryName' => 'TestCategory']);
        $response->assertRedirect('/home');
        $response->assertSessionHas('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    /**
     * Test admin and superadmin access control.
     */
    public function test_admin_and_super_admin_can_access_dashboard_and_actions(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $superAdmin = User::factory()->create(['role' => 'SuperAdmin']);

        // Admin dashboard
        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);

        // SuperAdmin dashboard
        $response = $this->actingAs($superAdmin)->get('/dashboard');
        $response->assertStatus(200);
    }

    /**
     * Test maintenance mode redirection behavior.
     */
    public function test_maintenance_mode_active_behavior(): void
    {
        // Activate maintenance mode
        Setting::set('modePemeliharaan', 'true');

        $user = User::factory()->create(['role' => 'User']);
        $admin = User::factory()->create(['role' => 'Admin']);
        $superAdmin = User::factory()->create(['role' => 'SuperAdmin']);

        // 1. Guest visiting /home should be redirected to login page (which is /)
        $response = $this->get('/home');
        $response->assertRedirect('/');

        // 2. Normal user visiting /home should be redirected to /maintenance
        $response = $this->actingAs($user)->get('/home');
        $response->assertRedirect('/maintenance');

        // 3. Admin visiting /dashboard should be redirected to /maintenance
        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertRedirect('/maintenance');

        // 4. SuperAdmin visiting /dashboard or /home should NOT be redirected to /maintenance
        $response = $this->actingAs($superAdmin)->get('/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($superAdmin)->get('/home');
        $response->assertStatus(200);

        // 5. Allowed routes should pass through for restricted roles
        $response = $this->actingAs($user)->get('/maintenance');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/logOut');
        $response->assertRedirect('/');

        // Public login and register actions are allowed
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test maintenance mode inactive behavior.
     */
    public function test_maintenance_mode_inactive_behavior(): void
    {
        // Deactivate maintenance mode
        Setting::set('modePemeliharaan', 'false');

        // Accessing /maintenance should redirect to login (/)
        $response = $this->get('/maintenance');
        $response->assertRedirect('/');

        $user = User::factory()->create(['role' => 'User']);
        $response = $this->actingAs($user)->get('/maintenance');
        $response->assertRedirect('/');
    }

    /**
     * Test Midtrans webhook resolves order ID with trailing timestamp.
     */
    public function test_midtrans_webhook_resolves_order_id_with_timestamp_suffix(): void
    {
        // Set mock server key
        config(['midtrans.server_key' => 'mock_key']);

        $user = User::factory()->create();
        $order = \App\Models\Pemesanan::create([
            'kodePemesanan' => 'ORD-2026-05-2771',
            'idUser' => $user->id,
            'status' => 'Pending',
            'totalHarga' => 10000,
            'estimasipembayaran' => now()->addDays(1)->format('Y-m-d'),
            'estimasiPengantaran' => now()->addDays(5)->format('Y-m-d'),
            'tipePembayaran' => 'Cash',
        ]);

        $orderIdWithSuffix = 'ORD-2026-05-2771-1779673822298';
        $statusCode = '200';
        $grossAmount = '10000';
        $signatureKey = hash("sha512", $orderIdWithSuffix . $statusCode . $grossAmount . 'mock_key');

        $response = $this->postJson('/updateStatusPemesanan', [
            'order_id' => $orderIdWithSuffix,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signatureKey,
            'transaction_status' => 'settlement',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Success']);

        $this->assertEquals('Lunas', $order->fresh()->status);
    }

    /**
     * Test create pemesanan with credit payment type.
     */
    public function test_create_pemesanan_credit_success(): void
    {
        $user = User::factory()->create(['role' => 'User']);
        $category = \App\Models\Category::create(['namaCategory' => 'Obat']);
        $product = \App\Models\Produk::create([
            'kodeProduk' => 'PRD001',
            'gambar' => 'test.jpg',
            'namaProduk' => 'Paracetamol',
            'deskripsi' => 'Obat Sakit Kepala',
            'idCategory' => $category->id,
            'harga' => 5000,
            'stok' => 10,
        ]);
        
        \App\Models\keranjang::create([
            'idUser' => $user->id,
            'idProduk' => $product->id,
            'jumlah' => 2,
        ]);

        $response = $this->actingAs($user)->postJson(route('createPemesanan', ['type' => 'Credit']), [
            'payment_method' => 'credit',
            'promo_code' => '',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'redirect' => route('pemesanan'),
        ]);

        $this->assertDatabaseHas('pemesanan', [
            'idUser' => $user->id,
            'status' => 'Credit',
            'tipePembayaran' => 'Credit',
            'totalHarga' => 10000,
        ]);

        // Cart should be empty
        $this->assertDatabaseMissing('keranjang', [
            'idUser' => $user->id,
        ]);
    }
}

