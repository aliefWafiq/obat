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
            'status' => 'Menunggu Persetujuan',
            'tipePembayaran' => 'Credit',
            'totalHarga' => 10000,
        ]);

        // Cart should be empty
        $this->assertDatabaseMissing('keranjang', [
            'idUser' => $user->id,
        ]);
    }

    /**
     * Test admin approves credit transaction sets invoice status.
     */
    public function test_admin_approves_credit_transaction_sets_invoice_status(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $user = User::factory()->create(['role' => 'User']);
        $order = \App\Models\Pemesanan::create([
            'kodePemesanan' => 'ORD-CREDIT-TEST',
            'idUser' => $user->id,
            'status' => 'Menunggu Persetujuan',
            'totalHarga' => 5000,
            'estimasipembayaran' => now()->addDays(21)->format('Y-m-d'),
            'estimasiPengantaran' => now()->addDays(5)->format('Y-m-d'),
            'tipePembayaran' => 'Credit',
        ]);

        $response = $this->actingAs($admin)->post(route('approveTransaksi', $order->id));
        $response->assertRedirect();
        
        $this->assertEquals('Invoice', $order->fresh()->status);
    }

    /**
     * Test admin approves cash transaction sets pending status.
     */
    public function test_admin_approves_cash_transaction_sets_pending_status(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $user = User::factory()->create(['role' => 'User']);
        $order = \App\Models\Pemesanan::create([
            'kodePemesanan' => 'ORD-CASH-TEST',
            'idUser' => $user->id,
            'status' => 'Menunggu Persetujuan',
            'totalHarga' => 5000,
            'estimasipembayaran' => now()->addDays(1)->format('Y-m-d'),
            'estimasiPengantaran' => now()->addDays(5)->format('Y-m-d'),
            'tipePembayaran' => 'Cash',
        ]);

        $response = $this->actingAs($admin)->post(route('approveTransaksi', $order->id));
        $response->assertRedirect();
        
        $this->assertEquals('Pending', $order->fresh()->status);
    }

    /**
     * Test registration stores in session and only saves to db after OTP verification.
     */
    public function test_registration_stores_in_session_and_only_saves_to_db_after_otp_verification(): void
    {
        // 1. Create a clinic so we can map the user to it
        $clinic = \App\Models\KodeKlinik::create([
            'namaKlinik' => 'Klinik Test',
            'alamat' => 'Alamat Test',
            'kodeKlinik' => 'KLK001',
        ]);

        // 2. Submit the registration form
        $registrationData = [
            'username' => 'newusertest',
            'alamat' => 'Jalan Kebangsaan No. 45',
            'phoneNumber' => '081234567890',
            'password' => 'secret12345',
        ];

        $response = $this->post('/register/action', $registrationData);

        // Should redirect back to register view showing the OTP form
        $response->assertRedirect('/register');
        $response->assertSessionHas('otp_sent', true);

        // Assert user is NOT in the database yet
        $this->assertDatabaseMissing('users', [
            'username' => 'newusertest',
            'phoneNumber' => '081234567890',
        ]);

        // Assert user details are stored in the session
        $this->assertTrue(session()->has('pending_user'));
        $this->assertEquals('newusertest', session('pending_user')['username']);

        // Assert OTP record is created in the database
        $this->assertDatabaseHas('otps', [
            'phone_number' => '081234567890',
        ]);

        $otpRecord = \App\Models\Otp::where('phone_number', '081234567890')->first();
        $this->assertNotNull($otpRecord);

        // 3. Verify OTP code
        $verifyResponse = $this->post(route('verifyOTP'), [
            'otp' => $otpRecord->code,
        ]);

        // Should redirect to home page with success
        $verifyResponse->assertRedirect('/home');
        $verifyResponse->assertSessionHas('success', 'Registrasi berhasil! Anda telah masuk.');
        $this->assertAuthenticated();

        // Assert user IS NOW in the database and active
        $this->assertDatabaseHas('users', [
            'username' => 'newusertest',
            'phoneNumber' => '081234567890',
        ]);

        // Assert session is cleared
        $this->assertFalse(session()->has('pending_user'));

        // Assert OTP is deleted
        $this->assertDatabaseMissing('otps', [
            'phone_number' => '081234567890',
        ]);
    }

    /**
     * Test that updating a clinic admin does not erase their idKlinik and successfully updates the KodeKlinik name.
     */
    public function test_updating_clinic_admin_retains_clinic_id_and_updates_clinic_name(): void
    {
        $superAdmin = User::factory()->create(['role' => 'SuperAdmin']);
        $clinic = \App\Models\KodeKlinik::create([
            'kodeKlinik' => '99',
            'namaKlinik' => 'Klinik Awal',
        ]);
        $adminUser = User::factory()->create([
            'role' => 'Admin',
            'username' => 'Klinik Awal',
            'idKlinik' => $clinic->id,
            'phoneNumber' => '081234567891',
            'alamat' => 'Alamat Awal',
        ]);

        // Put request without 'idKlinik' (as generated by editing an Admin user)
        $response = $this->actingAs($superAdmin)->put(route('updateUser', $adminUser->id), [
            'username' => 'Klinik Baru',
            'alamat' => 'Alamat Baru',
            'phoneNumber' => '081234567891',
        ]);

        $response->assertRedirect('/dashboard/user');
        
        // Assert user's idKlinik is NOT erased/null
        $adminUser->refresh();
        $this->assertEquals($clinic->id, $adminUser->idKlinik);
        $this->assertEquals('Klinik Baru', $adminUser->username);
        $this->assertEquals('Alamat Baru', $adminUser->alamat);

        // Assert KodeKlinik namaKlinik is updated to 'Klinik Baru'
        $clinic->refresh();
        $this->assertEquals('Klinik Baru', $clinic->namaKlinik);
    }

    /**
     * Test registration without OTP when WA/OTP system is disabled.
     */
    public function test_registration_without_otp_when_sistem_whatsapp_is_disabled(): void
    {
        // 1. Disable WA/OTP system in Settings
        Setting::set('sistemWhatsapp', 'false');

        // Create a clinic for assignment
        $clinic = \App\Models\KodeKlinik::create([
            'kodeKlinik' => '88',
            'namaKlinik' => 'Klinik Bawah',
        ]);

        // 2. Perform register POST request
        $response = $this->post('/register/action', [
            'username' => 'directuser',
            'alamat' => 'Alamat Direct',
            'phoneNumber' => '089876543210',
            'password' => 'simplepassword',
        ]);

        // Should bypass OTP, redirect directly to home page, and authenticate the user
        $response->assertRedirect('/home');
        $response->assertSessionHas('success', 'Registrasi berhasil! Anda telah masuk.');
        $this->assertAuthenticated();

        // Assert user details are stored in the database directly
        $this->assertDatabaseHas('users', [
            'username' => 'directuser',
            'phoneNumber' => '089876543210',
        ]);

        // Assert no OTP record was created in the database
        $this->assertDatabaseMissing('otps', [
            'phone_number' => '089876543210',
        ]);

        // 3. Test that FonnteService sendMessage returns false when disabled
        $fonnte = new \App\Services\FonnteService();
        $this->assertFalse($fonnte->sendMessage('089876543210', 'Test message'));
    }
}

