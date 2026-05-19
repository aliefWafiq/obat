<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Category;
use App\Models\CategoryProduk;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\BuatProgram;
use App\Models\KodeKlinik;
use App\Models\KuantitasDiskon;

use Midtrans\Config;
use Midtrans\Snap;

class actionController extends Controller
{

    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'alamat' => 'required',
            'phoneNumber' => 'required|unique:users,phoneNumber',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'phoneNumber.required' => 'Nomor telepon wajib diisi.',
            'phoneNumber.unique' => 'Nomor telepon sudah terdaftar.',
            'password.required' => 'Password wajib diisi.'
        ]);

        $password = Hash::make($request->input('password'));

        $selectedKlinik = KodeKlinik::withCount('users')
            ->orderBy('users_count', 'asc')
            ->first();

        if (!$selectedKlinik) {
            return redirect('/register')->with('error', 'Kode klinik tidak terdaftar.');
        }

        User::create([
            'username' => $request->input('username'),
            'alamat' => $request->input('alamat'),
            'phoneNumber' => $request->input('phoneNumber'),
            'role' => 'User',
            'password' => $password,
            'idKlinik' => $selectedKlinik->id
        ]);

        return redirect('/')->with('success', 'Akun berhasil dibuat. Silakan masuk.');
    }

    public function registerKlinik(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'alamat' => 'required',
            'phoneNumber' => 'required|unique:users,phoneNumber',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'phoneNumber.required' => 'Nomor telepon wajib diisi.',
            'phoneNumber.unique' => 'Nomor telepon sudah terdaftar.',
            'password.required' => 'Password wajib diisi.'
        ]);

        $password = Hash::make($request->input('password'));

        $num = KodeKlinik::count() + 1;
        do {
            $kodeKlinik = str_pad($num, 2, '0', STR_PAD_LEFT);
            $num++;
        } while (KodeKlinik::where('kodeKlinik', $kodeKlinik)->exists());

        DB::beginTransaction();

        try {
            $klinik = KodeKlinik::create([
                'kodeKlinik' => $kodeKlinik,
                'namaKlinik' => $request->input('username')
            ]);

            $user = User::create([
                'username' => $request->input('username'),
                'alamat' => $request->input('alamat'),
                'phoneNumber' => $request->input('phoneNumber'),
                'role' => $request->input('role'),
                'password' => $password,
                'idKlinik' => $klinik->id
            ]);

            DB::commit();

            return redirect('/dashboard/user')->with('success', 'Akun admin berhasil dibuat dengan Kode Klinik: ' . $kodeKlinik);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat akun klinik: ' . $e->getMessage())->withInput();
        }
    }

    public function login(Request $request)
    {
        $data = array(
            'phoneNumber' => $request->input('phoneNumber'),
            'password' => $request->input('password')
        );
        $check = User::where('phoneNumber', $data['phoneNumber'])->first();

        if (Auth::attempt($data)) {
            if ($check->role == 'SuperAdmin' || $check->role == 'Admin') {
                return redirect('/dashboard');
            } else {
                return redirect('/home');
            }
        } else {
            return redirect('/')->with('error', 'Nomor telepon atau password salah.');
        }
    }

    public function signOut()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Anda berhasil keluar.');
    }

    public function createProduk(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kodeProduk' => 'required|unique:produk,kodeProduk',
            'namaProduk' => 'required',
            'deskripsi' => 'required',
            'idCategory' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ], [
            'gambar.required' => 'Gambar produk wajib diisi',
            'kodeProduk.required' => 'Kode produk wajib diisi.',
            'kodeProduk.unique' => 'Kode produk sudah terdaftar.',
            'namaProduk.required' => 'Nama produk wajib diisi.',
            'deskripsi.required' => 'Deskripsi produk wajib diisi.',
            'idCategory.required' => 'Kategori produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
            'stok.required' => 'Stok produk wajib diisi.',
        ]);

        $request->file('gambar')->store('images', 'public');

        Produk::create([
            'kodeProduk' => $request->input('kodeProduk'),
            'namaProduk' => $request->input('namaProduk'),
            'deskripsi' => $request->input('deskripsi'),
            'idCategory' => $request->input('idCategory'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
            'gambar' => $request->file('gambar')->store('images', 'public')
        ]);

        return redirect('/dashboard/produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProduk(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'namaProduk' => 'required',
            'deskripsi' => 'required',
            'idCategory' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ], [
            'namaProduk.required' => 'Nama produk wajib diisi.',
            'deskripsi.required' => 'Deskripsi produk wajib diisi.',
            'idCategory.required' => 'Kategori produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
            'stok.required' => 'Stok produk wajib diisi.'
        ]);

        $produk = Produk::find($id);
        $gambar = $request->hasFile('gambar') ? $request->file('gambar')->store('images', 'public') : $produk->gambar;

        if ($request->hasFile('gambar') && $produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        if ($produk) {
            $produk->update([
                'gambar' => $gambar,
                'namaProduk' => $request->input('namaProduk'),
                'deskripsi' => $request->input('deskripsi'),
                'idCategory' => $request->input('idCategory'),
                'harga' => $request->input('harga'),
                'stok' => $request->input('stok')
            ]);
            return redirect('/dashboard/produk')->with('success', 'Produk berhasil diperbarui.');
        } else {
            return redirect('/dashboard/produk')->with('error', 'Produk tidak ditemukan.');
        }
    }

    public function deleteProduk($id)
    {
        $produk = Produk::find($id);
        if ($produk) {
            Storage::disk('public')->delete($produk->gambar);
            $produk->delete();
            return redirect('/dashboard/produk')->with('success', 'Produk berhasil dihapus.');
        } else {
            return redirect('/dashboard/produk')->with('error', 'Produk tidak ditemukan.');
        }
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'alamat' => 'required',
            'phoneNumber' => 'required|unique:users,phoneNumber,' . $id,
            'role' => 'required',
            'idKlinik' => 'nullable|exists:kodeKlinik,id'
        ], [
            'username.required' => 'Username wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'phoneNumber.required' => 'Nomor telepon wajib diisi.',
            'phoneNumber.unique' => 'Nomor telepon sudah terdaftar.',
            'role.required' => 'Role wajib diisi.'
        ]);

        $user = User::find($id);
        if ($user) {
            // Mencegah admin mendemosi diri sendiri
            $role = $request->input('role');
            if ($user->id === Auth::id() && $role !== 'Admin' && $user->role === 'Admin') {
                return redirect()->back()->with('error', 'Anda tidak dapat mengubah role Anda sendiri dari Admin ke User untuk menghindari kehilangan akses.');
            }

            $updateData = [
                'username' => $request->input('username'),
                'alamat' => $request->input('alamat'),
                'phoneNumber' => $request->input('phoneNumber'),
                'role' => $role
            ];

            if (auth()->user()->role === 'SuperAdmin') {
                $updateData['idKlinik'] = $request->input('idKlinik');
            }

            $user->update($updateData);
            return redirect('/dashboard/user')->with('success', 'User berhasil diperbarui.');
        } else {
            return redirect('/dashboard/user')->with('error', 'User tidak ditemukan.');
        }
    }

    public function reassignUserClinic(Request $request, $id)
    {
        $request->validate([
            'idKlinik' => 'required|exists:kodeKlinik,id'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'idKlinik' => $request->input('idKlinik')
        ]);

        return redirect()->back()->with('success', 'Pengguna ' . $user->username . ' berhasil dipindahkan.');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect('/dashboard/user')->with('success', 'User berhasil dihapus.');
        } else {
            return redirect('/dashboard/user')->with('error', 'User tidak ditemukan.');
        }
    }

    public function masukKeranjang(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'jumlah' => 'required|numeric|min:1'
        ]);

        $userId = Auth::id();
        $checkCart = Keranjang::where('idUser', $userId)->where('idProduk', $request->input('produk_id'))->first();

        if ($request->input('jumlah') > Produk::find($request->input('produk_id'))->stok) {
            return redirect('/keranjang')->with('error', 'Jumlah produk melebihi stok yang tersedia.');
        } else {
            if ($checkCart) {
                $checkCart->update([
                    'jumlah' => $checkCart->jumlah + $request->input('jumlah')
                ]);
                return redirect('/keranjang')->with('success', 'Jumlah produk berhasil diperbarui di keranjang.');
            } else {
                Keranjang::create([
                    'idUser' => $userId,
                    'idProduk' => $request->input('produk_id'),
                    'jumlah' => $request->input('jumlah'),
                ]);

                return redirect('/keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
            }
        }
    }

    public function removeItemKeranjang($id)
    {
        $keranjangItem = Keranjang::where('id', $id)->where('idUser', Auth::id())->first();
        if ($keranjangItem) {
            $keranjangItem->delete();
            return redirect('/keranjang')->with('success', 'Item berhasil dihapus dari keranjang.');
        } else {
            return redirect('/keranjang')->with('error', 'Item tidak ditemukan atau Anda tidak memiliki akses.');
        }
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'namaCategory' => 'required|unique:category,namaCategory'
        ], [
            'namaCategory.required' => 'Nama kategori wajib diisi.',
            'namaCategory.unique' => 'Nama kategori sudah terdaftar.'
        ]);

        Category::create([
            'namaCategory' => $request->input('namaCategory')
        ]);

        return redirect('/dashboard/category')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'namaCategory' => 'required|unique:category,namaCategory,' . $id
        ], [
            'namaCategory.required' => 'Nama kategori wajib diisi.',
            'namaCategory.unique' => 'Nama kategori sudah terdaftar.'
        ]);

        $category = Category::find($id);
        if ($category) {
            $category->update([
                'namaCategory' => $request->input('namaCategory')
            ]);
            return redirect('/dashboard/category')->with('success', 'Kategori berhasil diperbarui.');
        } else {
            return redirect('/dashboard/category')->with('error', 'Kategori tidak ditemukan.');
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return redirect('/dashboard/category')->with('success', 'Kategori berhasil dihapus.');
        } else {
            return redirect('/dashboard/category')->with('error', 'Kategori tidak ditemukan.');
        }
    }

    public function createPemesanan(Request $request)
    {
        $idUser = Auth::id();

        $itemKeranjang = Keranjang::with(['produk.kuantitasDiskon'])->where('idUser', $idUser)->get();

        if ($itemKeranjang->isEmpty()) {
            return redirect('/keranjang')->with('error', 'Keranjang kosong. Tambahkan produk sebelum melakukan pemesanan.');
        }

        $total = 0;
        foreach ($itemKeranjang as $item) {
            $subtotal = $item->produk->harga * $item->jumlah;
            $allRules = $item->produk->kuantitasDiskon;
            $bestRule = $allRules ? $allRules->where('minimalBeli', '<=', $item->jumlah)->sortByDesc('minimalBeli')->first() : null;
            if ($bestRule) {
                $subtotal = max(0, $subtotal - ($bestRule->diskon / 100 * $subtotal));
            }
            $total += $subtotal;
        }

        if ($itemKeranjang->first()->produk->stok < $itemKeranjang->first()->jumlah) {
            return redirect('/keranjang')->with('error', 'Stok produk tidak mencukupi untuk jumlah yang Anda pesan.');
        }

        $kodePemesanan = 'PM' . time() . rand(1000, 9999);
        $estimasiPembayaran = now()->addDays(21)->format('Y-m-d');
        $estimasiPengiriman = now()->addDays(5)->format('Y-m-d');

        $pemesanan = Pemesanan::create([
            'kodePemesanan' => $kodePemesanan,
            'idUser' => $idUser,
            'status' => 'Pending',
            'totalHarga' => $total,
            'estimasipembayaran' => $estimasiPembayaran,
            'estimasiPengantaran' => $estimasiPengiriman
        ]);

        foreach ($itemKeranjang as $item) {
            $subtotal = $item->produk->harga * $item->jumlah;
            $allRules = $item->produk->kuantitasDiskon;
            $bestRule = $allRules ? $allRules->where('minimalBeli', '<=', $item->jumlah)->sortByDesc('minimalBeli')->first() : null;
            if ($bestRule) {
                $subtotal = max(0, $subtotal - ($bestRule->diskon / 100 * $subtotal));
            }
            $hargaSatuan = $subtotal / $item->jumlah;

            DetailPemesanan::create([
                'idPemesanan' => $pemesanan->id,
                'idProduk' => $item->idProduk,
                'jumlahBeli' => $item->jumlah,
                'harga' => $hargaSatuan
            ]);
            $produk = Produk::find($item->idProduk);
            $produk->update([
                'stok' => $produk->stok - $item->jumlah
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $kodePemesanan,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->username,
                'phone' => Auth::user()->phoneNumber,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        Keranjang::where('idUser', $idUser)->delete();
        return response()->json(['snapToken' => $snapToken]);
    }

    public function updateStatusPemesanan(Request $request)
    {
        Log::info('Midtrans Notification:', $request->all());
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $orderIdParts = explode('-', $request->order_id);
            $pureOrderId = $orderIdParts[0];

            $order = Pemesanan::where('kodePemesanan', $pureOrderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order tidak ditemukan'], 404);
            }

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $order->update(['status' => 'Lunas']);
            } elseif (in_array($request->transaction_status, ['deny', 'expire', 'cancel'])) {
                $order->update(['status' => 'Gagal']);
            }

            return response()->json(['message' => 'Success']);
        }

        return response()->json(['message' => 'Invalid Signature'], 403);
    }

    private function generateMidtransLink($pesanan)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        $baseUrl = $isProduction
            ? 'https://api.midtrans.com/v1/payment-links'
            : 'https://api.sandbox.midtrans.com/v1/payment-links';

        $params = [
            'transaction_details' => [
                'order_id' => $pesanan->kodePemesanan,
                'gross_amount' => (int) $pesanan->totalHarga,
            ],
            'usage_limit' => 1,
            'notification_url' => 'https://a73c-103-190-46-192.ngrok-free.app/updateStatusPemesanan',
            'customer_details' => [
                'first_name' => Auth::user()->username,
                'phone' => Auth::user()->phoneNumber,
            ],
        ];

        $response = Http::withBasicAuth($serverKey, '')
            ->post($baseUrl, $params);

        if ($response->successful()) {
            return $response->json()['payment_url'];
        }

        logger('Midtrans Error: ' . $response->body());
        return null;
    }

    public function bayarUlang($id)
    {
        $pesanan = Pemesanan::where('id', $id)->where('idUser', Auth::id())->firstOrFail();

        if ($pesanan->status !== 'Pending') {
            return redirect()->back()->with('error', 'Pesanan ini tidak dapat dibayar lagi.');
        }

        if ($pesanan->paymentLink) {
            return redirect()->away($pesanan->paymentLink);
        }

        $paymentLink = $this->generateMidtransLink($pesanan);

        if (!$paymentLink) {
            return redirect()->back()->with('error', 'Gagal membuat link pembayaran. Pastikan koneksi internet stabil atau hubungi admin.');
        }

        $pesanan->update(['paymentLink' => $paymentLink]);

        return redirect()->away($paymentLink);
    }

    public function cetakStruk($id)
    {
        $pesanan = Pemesanan::with(['details.produk', 'user'])->findOrFail($id);

        if ($pesanan->status !== 'Lunas') {
            return redirect()->back()->with('error', 'Struk hanya dapat dicetak untuk pesanan yang sudah lunas.');
        }

        if ($pesanan->idUser !== Auth::id() && Auth::user()->role !== 'Admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mencetak struk ini.');
        }

        $pdf = Pdf::loadView('struk_pembayaran', compact('pesanan'));
        $pdf->setPaper([0, 0, 226, 600], 'potrait');

        return $pdf->stream('struk-' . $pesanan->kodePemesanan . '.pdf');
    }


    public function buatProgram(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tagProgram' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required'
        ], [
            'gambar.required' => 'Gambar program wajib diisi.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'tagProgram.required' => 'Tag program wajib diisi',
            'judul.required' => 'Judul program wajib diisi',
            'deskripsi.required' => 'Deskripsi program wajib diisi'
        ]);

        $gambarPath = $request->file('gambar')->store('images/program', 'public');

        BuatProgram::create([
            'gambar' => $gambarPath,
            'tagProgram' => $request->tagProgram,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect('/dashboard/listProgram')->with('success', 'Program berhasil dibuat.');
    }

    public function updateProgram(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'tagProgram' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required'
        ], [
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        $program = BuatProgram::find($id);
        if (!$program) {
            return redirect('/dashboard/listProgram')->with('error', 'Program tidak ditemukan.');
        }

        $updateData = [
            'tagProgram' => $request->tagProgram,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi
        ];

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($program->gambar);
            $gambarPath = $request->file('gambar')->store('images/program', 'public');
            $updateData['gambar'] = $gambarPath;
        }

        $program->update($updateData);
        return redirect('/dashboard/listProgram')->with('success', 'Program berhasil diperbarui.');
    }

    public function deleteProgram($id)
    {
        $program = BuatProgram::find($id);
        if (!$program) {
            return redirect('/dashboard/listProgram')->with('error', 'Program tidak ditemukan.');
        }

        Storage::disk('public')->delete($program->gambar);
        $program->delete();

        return redirect('/dashboard/listProgram')->with('success', 'Program berhasil dihapus.');
    }

    public function buatDiskon(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'minimalBeli' => 'required',
            'diskon' => 'required'
        ], [
            'produk_id.required' => 'Produk wajib dipilih.',
            'minimalBeli.required' => 'Minimal beli wajib diisi',
            'diskon.required' => 'Diskon wajib diisi'
        ]);

        KuantitasDiskon::create([
            'idProduk' => $request->produk_id,
            'minimalBeli' => $request->minimalBeli,
            'diskon' => $request->diskon
        ]);

        return redirect('/dashboard/listDiskon')->with('success', 'Diskon berhasil dibuat.');
    }

    public function updateDiskon(Request $request, $id)
    {
        $request->validate([
            'produk_id' => 'required',
            'minimalBeli' => 'required',
            'diskon' => 'required'
        ], [
            'produk_id.required' => 'Produk wajib dipilih.',
            'minimalBeli.required' => 'Minimal beli wajib diisi',
            'diskon.required' => 'Diskon wajib diisi'
        ]);

        $diskon = KuantitasDiskon::findOrFail($id);
        $diskon->update([
            'idProduk' => $request->produk_id,
            'minimalBeli' => $request->minimalBeli,
            'diskon' => $request->diskon
        ]);

        return redirect('/dashboard/listDiskon')->with('success', 'Diskon berhasil diperbarui.');
    }

    public function deleteDiskon($id)
    {
        $diskon = KuantitasDiskon::findOrFail($id);
        $diskon->delete();

        return redirect('/dashboard/listDiskon')->with('success', 'Diskon berhasil dihapus.');
    }
}
