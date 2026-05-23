<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Produk;
use App\Models\keranjang;
use App\Models\User;
use App\Models\Category;
use App\Models\Pemesanan;
use App\Models\BuatProgram;
use App\Models\DetailPemesanan;
use App\Models\KodeKlinik;
use App\Models\KuantitasDiskon;
use App\Models\Settings;

class mainController extends Controller
{
    public function index()
    {
        $categories = Category::with(['produk' => function ($query) {
            $query->latest()->limit(4);
        }])->take(4)->get();

        $produk = Produk::with('category')->latest()->take(4)->get();
        $BuatProgram = BuatProgram::all();

        return view('landingPage', compact('categories', 'produk', 'BuatProgram'));
    }

    public function viewRegister()
    {
        if (setting('pendaftaranMandiriDokter', 'false') === 'true' || setting('pendaftaranMandiriDokter', 'false') === '1') {
            return redirect()->route('login')->with('error', 'Fitur registrasi mandiri sedang dinonaktifkan oleh administrator.');
        }

        if (Auth::check()) {
            return redirect('/home');
        } else {
            return view('register');
        }
    }

    public function viewLogin()
    {
        if (Auth::check()) {
            return redirect('/home');
        } else {
            return view('login');
        }
    }

    public function home()
    {
        $produk = Produk::all();
        $categories = Category::all();
        $BuatProgram = BuatProgram::all();
        return view('user.home', compact('produk', 'categories', 'BuatProgram'));
    }

    public function pemesanan()
    {
        $pemesanan = Pemesanan::where('idUser', Auth::id())->latest()->get();
        return view('user.pemesanan', compact('pemesanan'));
    }

    public function keranjang()
    {
        $idUser = Auth::id();
        $items = Keranjang::with(['produk.kuantitasDiskon'])->where('idUser', $idUser)->get();
        $pemesananPending = Pemesanan::where('status', 'Pending')->where(function ($query) {
            $query->whereDate('estimasipembayaran', '<=', Carbon::today());
        })->get();
        
        $total = 0;
        foreach ($items as $item) {
            $subtotalOriginal = $item->produk->harga * $item->jumlah;
            $item->subtotal_original = $subtotalOriginal;
            
            $allRules = $item->produk->kuantitasDiskon;
            $bestRule = $allRules ? $allRules->where('minimalBeli', '<=', $item->jumlah)->sortByDesc('minimalBeli')->first() : null;
            
            if ($bestRule) {
                $item->has_diskon = true;
                $item->diskon_rule = $bestRule;
                $item->diskon_nominal = $bestRule->diskon / 100 * $subtotalOriginal;
                $item->subtotal_discounted = max(0, $subtotalOriginal - $item->diskon_nominal);
                $total += $item->subtotal_discounted;
            } else {
                $item->has_diskon = false;
                $item->diskon_nominal = 0;
                $item->subtotal_discounted = $subtotalOriginal;
                $total += $subtotalOriginal;
            }
            
            $nextRule = $allRules ? $allRules->where('minimalBeli', '>', $item->jumlah)->sortBy('minimalBeli')->first() : null;
            $item->next_diskon_rule = $nextRule;
        }
        
        return view('user.keranjang', compact('items', 'total', 'pemesananPending'));
    }

    public function dashboard()
    {
        $pemesananLunas = Pemesanan::where('status', 'Lunas')->get();
        $totalPendapatan = $pemesananLunas->sum('totalHarga');

        $totalTransaksiHariIni = Pemesanan::where('status', 'Lunas')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $totalProdukTerjual = DetailPemesanan::whereHas('pemesanan', function ($query) {
            $query->where('status', 'Lunas');
        })->sum('jumlahBeli');

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $pendapatanMingguan = $pemesananLunas->whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('totalHarga');

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $pendapatanBulanIni = $pemesananLunas->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('totalHarga');

        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        $pendapatanBulanLalu = $pemesananLunas->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum('totalHarga');

        $pertumbuhan = 0;
        if ($pendapatanBulanLalu > 0) {
            $pertumbuhan = (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100;
        } else if ($pendapatanBulanIni > 0) {
            $pertumbuhan = 100;
        }
        $pertumbuhan = round($pertumbuhan, 1);

        $totalPesanan = $pemesananLunas->count();
        $pelangganAktif = $pemesananLunas->pluck('idUser')->unique()->count();

        $dailyLabels = [];
        $dailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyLabels[] = $date->translatedFormat('D');
            $dailyData[] = Pemesanan::where('status', 'Lunas')
                ->whereDate('created_at', $date->toDateString())
                ->sum('totalHarga');
        }

        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->startOfMonth()->subMonths($i);
            $monthlyLabels[] = $date->translatedFormat('M');
            $monthlyData[] = Pemesanan::where('status', 'Lunas')
                ->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])
                ->sum('totalHarga');
        }

        // Data Grafik Tahunan (5 tahun terakhir)
        $yearlyLabels = [];
        $yearlyData = [];
        for ($i = 4; $i >= 0; $i--) {
            $date = Carbon::now()->startOfYear()->subYears($i);
            $yearlyLabels[] = $date->format('Y');
            $yearlyData[] = Pemesanan::where('status', 'Lunas')
                ->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])
                ->sum('totalHarga');
        }

        $topItems = DetailPemesanan::whereHas('pemesanan', function ($q) {
            $q->where('status', 'Lunas')->whereDate('created_at', Carbon::today());
        })
        ->select('idProduk', \DB::raw('SUM(jumlahBeli) as total_qty'))
        ->groupBy('idProduk')
        ->orderBy('total_qty', 'desc')
        ->take(3)
        ->with('produk')
        ->get();

        $topBuyers = Pemesanan::where('status', 'Lunas')
            ->whereDate('created_at', Carbon::today())
            ->select('idUser', \DB::raw('COUNT(*) as total_transaksi'))
            ->groupBy('idUser')
            ->orderBy('total_transaksi', 'desc')
            ->take(3)
            ->with('user')
            ->get();

        // Produk Unggulan Keseluruhan
        $produkUnggulan = DetailPemesanan::whereHas('pemesanan', function ($q) {
            $q->where('status', 'Lunas');
        })
        ->select('idProduk', \DB::raw('SUM(jumlahBeli) as total_terjual'))
        ->groupBy('idProduk')
        ->orderBy('total_terjual', 'desc')
        ->take(5)
        ->with('produk')
        ->get();

        // Rata-rata transaksi
        $rataRataTransaksi = $pemesananLunas->avg('totalHarga') ?? 0;

        // Kontribusi Kategori
        $kategoriKontribusi = \Illuminate\Support\Facades\DB::table('detailPemesanan')
            ->join('pemesanan', 'detailPemesanan.idPemesanan', '=', 'pemesanan.id')
            ->join('produk', 'detailPemesanan.idProduk', '=', 'produk.id')
            ->join('category', 'produk.idCategory', '=', 'category.id')
            ->where('pemesanan.status', 'Lunas')
            ->select('category.namaCategory', \Illuminate\Support\Facades\DB::raw('SUM(detailPemesanan.jumlahBeli * produk.harga) as total_penjualan'))
            ->groupBy('category.namaCategory')
            ->orderBy('total_penjualan', 'desc')
            ->get();

        $totalPenjualanSemuaKategori = $kategoriKontribusi->sum('total_penjualan');

        return view('admin.dashboard', compact(
            'totalPendapatan',
            'totalTransaksiHariIni',
            'totalProdukTerjual',
            'pendapatanMingguan',
            'pendapatanBulanIni',
            'pertumbuhan',
            'totalPesanan',
            'pelangganAktif',
            'dailyLabels',
            'dailyData',
            'monthlyLabels',
            'monthlyData',
            'yearlyLabels',
            'yearlyData',
            'topItems',
            'topBuyers',
            'produkUnggulan',
            'rataRataTransaksi',
            'kategoriKontribusi',
            'totalPenjualanSemuaKategori'
        ));
    }

    public function listProduk()
    {
        $produk = Produk::with('category')->get();
        $categories = Category::all();
        return view('admin.list.listProduk', compact('produk', 'categories'));
    }

    public function viewEditProduk($id)
    {
        $produk = Produk::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit.editProduk', compact('produk', 'categories'));
    }

    public function listAkun()
    {
        $users = User::all();
        $clinics = KodeKlinik::all();
        return view('admin.list.listAkun', compact('users', 'clinics'));
    }

    public function listUser()
    {
        $users = User::all();
        $clinics = KodeKlinik::all();
        return view('admin.list.listUser', compact('users', 'clinics'));
    }

    public function listKlinik()
    {
        $users = User::all();
        $clinics = KodeKlinik::all();
        return view('admin.list.listKlinik', compact('users', 'clinics'));
    }

    public function viewEditUser($id)
    {
        $users = User::findOrFail($id);
        $clinics = KodeKlinik::all();
        return view('admin.edit.editUser', compact('users', 'clinics'));
    }

    public function listCategory()
    {
        $categories = Category::all();
        return view('admin.list.listCategory', compact('categories'));
    }

    public function viewCreateCategory()
    {
        return view('admin.create.createCategory');
    }

    public function viewEditCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.edit.editCategory', compact('category'));
    }

    public function listTransaksi()
    {
        $pemesanan = Pemesanan::with('user.klinik')->orderBy('created_at', 'desc')->get();
        return view('admin.list.listTransaksi', compact('pemesanan'));
    }

    public function listPenjualan()
    {
        $pemesanan = Pemesanan::with('user.klinik')->orderBy('created_at', 'desc')->get();
        $totalPendapatan = $pemesanan->where('status', 'Lunas')->sum('totalHarga');
        $totalTransaksi = $pemesanan->count();
        $totalProdukTerjual = DetailPemesanan::whereHas('pemesanan', function ($query) {
            $query->where('status', 'Lunas');
        })->sum('jumlahBeli');
        $totalPelangganAktif = $pemesanan->pluck('idUser')->unique()->count();

        return view('admin.list.listPenjualan', compact(
            'totalPendapatan',
            'totalTransaksi',
            'totalProdukTerjual',
            'totalPelangganAktif',
            'pemesanan'
        ));
    }

    public function listProgram()
    {
        $buatProgram = BuatProgram::all();
        return view('admin.list.listProgram', compact('buatProgram'));
    }

    public function viewBuatProgram()
    {
        return view('admin.create.buatProgram');
    }

    public function viewEditProgram($id)
    {
        $buatProgram = BuatProgram::findOrFail($id);
        return view('admin.edit.editProgram', compact('buatProgram'));
    }

    public function listDiskon()
    {
        $buatDiskon = KuantitasDiskon::all();
        return view('admin.list.listDiskon', compact('buatDiskon'));
    }

    public function viewBuatDiskon()
    {
        $produk = Produk::all();
        return view('admin.create.buatDiskon', compact('produk'));
    }

    public function viewEditDiskon($id)
    {
        $produk = Produk::all();
        $buatDiskon = KuantitasDiskon::findOrFail($id);
        return view('admin.edit.editDiskon', compact('produk', 'buatDiskon'));
    }

    public function viewEditStok()
    {
        return view('admin.edit.editStok');
    }

    public function listInvoice()
    {
        $users = User::all();
        $clinics = KodeKlinik::all();

        if (auth()->user()->role === 'SuperAdmin') {
            $pemesanan = Pemesanan::with(['user.klinik', 'details.produk'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $clinicId = auth()->user()->idKlinik;
            $pemesanan = Pemesanan::whereHas('user', function ($query) use ($clinicId) {
                $query->where('idKlinik', $clinicId);
            })->with(['user.klinik', 'details.produk'])
              ->orderBy('created_at', 'desc')
              ->get();
        }

        return view('admin.list.listInvoice', compact('pemesanan', 'clinics', 'users'));
    }

    public function viewSettings()
    {
        return view('admin.list.settings');
    }

    public function viewActivityLogs()
    {
        $logs = \App\Models\ActivityLog::with('user.klinik')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        return view('admin.list.activityLogs', compact('logs'));
    }

    public function viewMaintenance()
    {
        return view('maintenance');
    }
}


