<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AdminController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginInput = trim($request->input('username'));
        $password = $request->input('password');

        // 1. Coba login berdasarkan username
        if (Auth::attempt(['username' => $loginInput, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // 2. Coba login berdasarkan email (jika input berupa email)
        if (Auth::attempt(['email' => $loginInput, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // 3. Fallback Khusus Akun Demo / Administrator
        // Memastikan akun 'admin' dengan kata sandi 'password' atau 'skripsi123' selalu berhasil masuk
        $isDemoAdmin = in_array(strtolower($loginInput), ['admin', 'admin@salbai.com']);
        $isDemoPass = in_array($password, ['password', 'skripsi123']);

        if ($isDemoAdmin && $isDemoPass) {
            $adminUser = \App\Models\User::where('username', 'admin')
                ->orWhere('email', 'admin@salbai.com')
                ->orWhere('role', 'admin')
                ->first();

            if (!$adminUser) {
                $adminUser = \App\Models\User::create([
                    'name' => 'Administrator HOS',
                    'username' => 'admin',
                    'email' => 'admin@salbai.com',
                    'password' => Hash::make($password),
                    'role' => 'admin',
                ]);
            } else {
                $adminUser->password = Hash::make($password);
                $adminUser->username = 'admin';
                $adminUser->save();
            }

            Auth::login($adminUser);
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'Informasi login tidak cocok dengan data kami.',
        ])->onlyInput('username');
    }

    public function dashboard(Request $request)
    {
        $inventories = \App\Models\Inventory::all();
        $albums = \App\Models\Album::with('galleries')->get();
        $manifests = \App\Models\Manifest::with('items.inventory')->latest()->get();
        $vendors = \App\Models\Vendor::all();
        $settings = \App\Models\ContentManagementSystem::all()->pluck('value', 'key');

        // 1. Data Filter Laporan Bulanan
        $reportMonth = $request->query('report_month', date('m'));
        $reportYear = $request->query('report_year', date('Y'));

        // Query manifes terfilter
        $reportManifests = \App\Models\Manifest::with('items.inventory')
            ->whereMonth('tanggal_loading', $reportMonth)
            ->whereYear('tanggal_loading', $reportYear)
            ->latest()
            ->get();

        // Hitung statistik laporan bulanan
        $monthlyStats = [
            'total_manifests' => $reportManifests->count(),
            'completed' => $reportManifests->where('status', 'Alat Kembali')->count(),
            'ongoing' => $reportManifests->where('status', 'Alat Diluar')->count(),
            'total_items_qty' => 0,
            'top_items' => []
        ];

        // Hitung total unit alat yang keluar dan kumpulkan untuk Top Items
        $itemCounts = [];
        foreach ($reportManifests as $manifest) {
            foreach ($manifest->items as $item) {
                $monthlyStats['total_items_qty'] += $item->qty;
                if ($item->inventory) {
                    $name = $item->inventory->nama_alat;
                    $itemCounts[$name] = ($itemCounts[$name] ?? 0) + $item->qty;
                }
            }
            // Add additional items too
            if (is_array($manifest->additional_items)) {
                foreach ($manifest->additional_items as $add) {
                    $qty = isset($add['qty']) ? (int) $add['qty'] : 1;
                    $monthlyStats['total_items_qty'] += $qty;
                    $name = $add['name'] ?? 'Alat Lainnya';
                    $itemCounts[$name] = ($itemCounts[$name] ?? 0) + $qty;
                }
            }
        }

        // Urutkan untuk mendapatkan Top 5 Alat
        arsort($itemCounts);
        $monthlyStats['top_items'] = array_slice($itemCounts, 0, 5, true);

        // Daftar semua user admin
        $adminUsers = \App\Models\User::orderBy('name')->get();

        // Paksa browser TIDAK menyimpan cache halaman ini
        return view('dashboard', compact(
            'inventories',
            'albums',
            'settings',
            'manifests',
            'vendors',
            'reportManifests',
            'reportMonth',
            'reportYear',
            'monthlyStats',
            'adminUsers'
        ));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Paksa browser untuk tidak menyimpan cache dashboard
        return redirect('/login')->with('success', 'Anda telah keluar dan sesi telah diamankan.');
    }

    public function updateAlbum(Request $request, $id)
    {
        $request->validate([
            'judul_event' => 'required|string|max:255',
            'tanggal_event' => 'required|date',
            'cover_album' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
            'dokumentasi.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi,webm|max:51200',
        ]);

        $album = \App\Models\Album::findOrFail($id);

        $data = [
            'judul_event' => $request->judul_event,
            'tanggal_event' => $request->tanggal_event,
            'tanggal_selesai' => $request->tanggal_selesai ?: null,
            'deskripsi_event' => $request->deskripsi_event
        ];

        // Handle cover album upload
        if ($request->hasFile('cover_album')) {
            // Delete old cover if it was a file (not '-')
            if ($album->cover_album && $album->cover_album !== '-' && file_exists(public_path($album->cover_album))) {
                @unlink(public_path($album->cover_album));
            }
            $coverFile = $request->file('cover_album');
            $coverName = 'cover_' . time() . '_' . Str::random(6) . '.' . $coverFile->getClientOriginalExtension();
            $coverFile->move(public_path('uploads/albums'), $coverName);
            $data['cover_album'] = 'uploads/albums/' . $coverName;
        }

        // If previously rejected, resubmitting resets status to pending & clears rejection note
        if ($album->approval_status === 'rejected') {
            $data['approval_status'] = (Auth::user() && Auth::user()->isPegawai()) ? 'pending' : 'approved';
            $data['catatan_penolakan'] = null;
        }

        $album->update($data);

        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                $fileType = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';
                $filename = time() . rand(100, 999) . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
                $file->move(public_path('uploads/albums'), $filename);

                \App\Models\Gallery::create([
                    'album_id' => $album->id,
                    'file_path' => 'uploads/albums/' . $filename,
                    'file_type' => $fileType
                ]);
            }
        }

        $msg = (Auth::user() && Auth::user()->isPegawai() && $data['approval_status'] === 'pending')
            ? 'Album telah diperbarui dan diajukan ulang untuk persetujuan Admin!'
            : 'Album Berhasil Diperbarui!';

        return redirect('/dashboard')->with('success', $msg);
    }

    // ASET / INVENTORY LOGIC
    public function storeAset(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'stok_tersedia' => 'required|integer|min:0',
            'kondisi_alat' => 'nullable|string|max:50',
            'foto_alat' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $fotoPath = '-';
        if ($request->hasFile('foto_alat')) {
            $file = $request->file('foto_alat');
            $filename = 'inv_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/inventory'), $filename);
            $fotoPath = 'uploads/inventory/' . $filename;
        }

        $status = (Auth::user() && Auth::user()->isPegawai()) ? 'pending' : 'approved';

        \App\Models\Inventory::create([
            'nama_alat' => $request->nama_alat,
            'kategori' => $request->kategori,
            'stok_tersedia' => $request->stok_tersedia,
            'kondisi_alat' => $request->kondisi_alat ?? 'Baik',
            'foto_alat' => $fotoPath,
            'deskripsi' => $request->deskripsi ?? '-',
            'approval_status' => $status
        ]);

        $msg = (Auth::user() && Auth::user()->isPegawai())
            ? 'Aset berhasil diusulkan dan sedang menunggu persetujuan Admin!'
            : 'Aset Berhasil Ditambahkan!';

        return redirect('/dashboard')->with('success', $msg);
    }

    public function updateAset(Request $request, $id)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'stok_tersedia' => 'required|integer|min:0',
            'kondisi_alat' => 'nullable|string|max:50',
            'foto_alat' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $aset = \App\Models\Inventory::findOrFail($id);

        $data = [
            'nama_alat' => $request->nama_alat,
            'kategori' => $request->kategori,
            'stok_tersedia' => $request->stok_tersedia,
            'kondisi_alat' => $request->kondisi_alat ?? 'Baik',
        ];

        if ($request->hasFile('foto_alat')) {
            // Delete old file if exists
            if ($aset->foto_alat && $aset->foto_alat != '-' && file_exists(public_path($aset->foto_alat))) {
                @unlink(public_path($aset->foto_alat));
            }

            $file = $request->file('foto_alat');
            $filename = 'inv_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/inventory'), $filename);
            $data['foto_alat'] = 'uploads/inventory/' . $filename;
        }

        // If previously rejected, resubmitting resets status to pending & clears rejection note
        if ($aset->approval_status === 'rejected') {
            $data['approval_status'] = (Auth::user() && Auth::user()->isPegawai()) ? 'pending' : 'approved';
            $data['catatan_penolakan'] = null;
        }

        $aset->update($data);

        $msg = (Auth::user() && Auth::user()->isPegawai() && isset($data['approval_status']) && $data['approval_status'] === 'pending')
            ? 'Data Aset telah diperbarui dan diajukan ulang untuk persetujuan Admin!'
            : 'Data Aset Telah Diperbarui!';

        return redirect('/dashboard')->with('success', $msg);
    }

    public function dismissRejectionAset($id)
    {
        $aset = \App\Models\Inventory::findOrFail($id);
        $aset->update(['catatan_penolakan' => null]);
        return redirect('/dashboard')->with('success', 'Catatan penolakan untuk aset "' . $aset->nama_alat . '" telah dibersihkan.');
    }

    public function dismissRejectionAlbum($id)
    {
        $album = \App\Models\Album::findOrFail($id);
        $album->update(['catatan_penolakan' => null]);
        return redirect('/dashboard')->with('success', 'Catatan penolakan untuk album "' . $album->judul_event . '" telah dibersihkan.');
    }

    public function deleteAset($id)
    {
        \App\Models\Inventory::destroy($id);
        return redirect('/dashboard')->with('success', 'Aset Berhasil Dihapus!');
    }

    // MANIFEST LOGIC
    public function storeManifes(Request $request)
    {
        $request->validate([
            'klien_event' => 'required',
            'tanggal_loading' => 'required',
            'crew_chief' => 'required',
            'inventory_ids' => 'nullable|array',
            'quantities' => 'nullable|array'
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Process Additional Items JSON
            $additionalItems = [];
            if ($request->has('manual_names')) {
                foreach ($request->manual_names as $k => $name) {
                    if (empty($name))
                        continue;
                    $additionalItems[] = [
                        'name' => $name,
                        'qty' => $request->manual_qtys[$k] ?? 1
                    ];
                }
            }

            $manifest = \App\Models\Manifest::create([
                'nomor_manifes' => 'MNF-' . date('ymd') . '-' . rand(100, 999),
                'klien_event' => $request->klien_event,
                'tanggal_loading' => $request->tanggal_loading,
                'crew_chief' => $request->crew_chief,
                'additional_items' => $additionalItems,
                'catatan' => $request->catatan,
                'daftar_alat' => '-', // Summary field
                'status' => 'Alat Diluar'
            ]);

            $summaryText = [];
            $stockErrors = [];

            if ($request->has('inventory_ids')) {
                foreach ($request->inventory_ids as $index => $inventory_id) {
                    if (empty($inventory_id))
                        continue;
                    $qty = $request->quantities[$index] ?? 0;
                    if ($qty <= 0)
                        continue;
                    $inventory = \App\Models\Inventory::find($inventory_id);
                    if (!$inventory)
                        continue;

                    if ($inventory->stok_tersedia <= 0) {
                        $stockErrors[] = "Stok habis untuk: " . $inventory->nama_alat . " (Tersedia: 0).";
                        continue;
                    }

                    if ($inventory->stok_tersedia < $qty) {
                        $stockErrors[] = "Stok tidak mencukupi untuk: " . $inventory->nama_alat . " (Diminta: {$qty}, tersedia: {$inventory->stok_tersedia}).";
                        continue;
                    }

                    \App\Models\ManifestItem::create(['manifest_id' => $manifest->id, 'inventory_id' => $inventory->id, 'qty' => $qty]);
                    $inventory->decrement('stok_tersedia', $qty);
                    $summaryText[] = "- " . $qty . " " . $inventory->nama_alat;
                }
            }

            if (!empty($stockErrors)) {
                \Illuminate\Support\Facades\DB::rollBack();
                return redirect('/dashboard')
                    ->with('error', 'Gagal menerbitkan manifes karena stok tidak mencukupi: ' . implode(' | ', $stockErrors))
                    ->withInput();
            }

            $manifest->update(['daftar_alat' => implode("\n", $summaryText)]);

            \Illuminate\Support\Facades\DB::commit();
            return redirect('/dashboard')->with('success', 'Manifes Berhasil Diterbitkan dan Stok Telah Dikurangi!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect('/dashboard')->with('error', 'Gagal menerbitkan manifes: ' . $e->getMessage());
        }
    }

    public function deleteManifes($id)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $manifest = \App\Models\Manifest::with('items')->findOrFail($id);
            foreach ($manifest->items as $item) {
                if ($item->inventory) {
                    $item->inventory->increment('stok_tersedia', $item->qty);
                }
            }
            $manifest->delete();
            \Illuminate\Support\Facades\DB::commit();
            return redirect('/dashboard')->with('success', 'Manifes Dihapus dan Stok Dikembalikan!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect('/dashboard')->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function updateManifes(Request $request, $id)
    {
        $request->validate([
            'klien_event' => 'required',
            'tanggal_loading' => 'required',
            'crew_chief' => 'required'
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $manifest = \App\Models\Manifest::with('items')->findOrFail($id);

            // Restore OLD stock only if status was still 'Alat Diluar'
            if ($manifest->status == 'Alat Diluar') {
                foreach ($manifest->items as $item) {
                    if ($item->inventory) {
                        $item->inventory->increment('stok_tersedia', $item->qty);
                    }
                }
            }
            $manifest->items()->delete();

            // Process Additional Items JSON
            $additionalItems = [];
            if ($request->has('manual_names')) {
                foreach ($request->manual_names as $k => $name) {
                    if (empty($name))
                        continue;
                    $additionalItems[] = [
                        'name' => $name,
                        'qty' => $request->manual_qtys[$k] ?? 1
                    ];
                }
            }

            $manifest->update([
                'klien_event' => $request->klien_event,
                'tanggal_loading' => $request->tanggal_loading,
                'crew_chief' => $request->crew_chief,
                'additional_items' => $additionalItems,
                'catatan' => $request->catatan,
                'status' => 'Alat Diluar' // Reset status on edit if changed
            ]);

            $summaryText = [];
            $stockErrors = [];

            if ($request->has('inventory_ids')) {
                foreach ($request->inventory_ids as $index => $inventory_id) {
                    if (empty($inventory_id))
                        continue;
                    $qty = $request->quantities[$index] ?? 0;
                    if ($qty <= 0)
                        continue;
                    $inventory = \App\Models\Inventory::find($inventory_id);
                    if (!$inventory)
                        continue;

                    if ($inventory->stok_tersedia <= 0) {
                        $stockErrors[] = "Stok habis untuk: " . $inventory->nama_alat . " (Tersedia: 0).";
                        continue;
                    }

                    if ($inventory->stok_tersedia < $qty) {
                        $stockErrors[] = "Stok tidak mencukupi untuk: " . $inventory->nama_alat . " (Diminta: {$qty}, tersedia: {$inventory->stok_tersedia}).";
                        continue;
                    }

                    \App\Models\ManifestItem::create(['manifest_id' => $manifest->id, 'inventory_id' => $inventory->id, 'qty' => $qty]);
                    $inventory->decrement('stok_tersedia', $qty);
                    $summaryText[] = "- " . $qty . " " . $inventory->nama_alat;
                }
            }

            if (!empty($stockErrors)) {
                \Illuminate\Support\Facades\DB::rollBack();
                return redirect('/dashboard')
                    ->with('error', 'Gagal memperbarui manifes karena stok tidak mencukupi: ' . implode(' | ', $stockErrors))
                    ->withInput();
            }

            $manifest->update(['daftar_alat' => implode("\n", $summaryText)]);
            \Illuminate\Support\Facades\DB::commit();

            return redirect('/dashboard')->with('success', 'Manifes Berhasil Diperbarui dan Stok Telah Disinkronkan!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect('/dashboard')->with('error', 'Gagal memperbarui manifes: ' . $e->getMessage());
        }
    }

    public function returnManifes($id)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $manifest = \App\Models\Manifest::with('items')->findOrFail($id);

            // If already returned, skip
            if ($manifest->status == 'Alat Kembali') {
                return redirect('/dashboard')->with('error', 'Barang sudah berstatus Kembali.');
            }

            // Restore Inventory stock
            foreach ($manifest->items as $item) {
                if ($item->inventory) {
                    $item->inventory->increment('stok_tersedia', $item->qty);
                }
            }

            $manifest->update(['status' => 'Alat Kembali']);

            \Illuminate\Support\Facades\DB::commit();
            return redirect('/dashboard')->with('success', 'Barang dinyatakan Kembali dan Stok Gudang telah Bertambah!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect('/dashboard')->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    // PRINT LAPORAN BULANAN
    public function printLaporanBulanan(Request $request)
    {
        $reportMonth = $request->query('month', date('m'));
        $reportYear = $request->query('year', date('Y'));
        $settings = \App\Models\ContentManagementSystem::all()->pluck('value', 'key');

        $reportManifests = \App\Models\Manifest::with('items.inventory')
            ->whereMonth('tanggal_loading', $reportMonth)
            ->whereYear('tanggal_loading', $reportYear)
            ->latest()
            ->get();

        $monthlyStats = [
            'total_manifests' => $reportManifests->count(),
            'completed' => $reportManifests->where('status', 'Alat Kembali')->count(),
            'ongoing' => $reportManifests->where('status', 'Alat Diluar')->count(),
            'total_items_qty' => 0
        ];

        foreach ($reportManifests as $manifest) {
            foreach ($manifest->items as $item) {
                $monthlyStats['total_items_qty'] += $item->qty;
            }
            if (is_array($manifest->additional_items)) {
                foreach ($manifest->additional_items as $add) {
                    $monthlyStats['total_items_qty'] += (int) ($add['qty'] ?? 1);
                }
            }
        }

        return view('print_laporan_bulanan', compact('reportManifests', 'reportMonth', 'reportYear', 'settings', 'monthlyStats'));
    }

    // FORGOT PASSWORD
    public function forgotPasswordForm()
    {
        return view('forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Alamat email tidak terdaftar.'])->withInput();
        }

        if ($user->role !== 'admin') {
            return back()->withErrors(['email' => 'Pemulihan mandiri lewat email hanya diizinkan untuk Administrator. Jika Anda adalah Staff, silakan hubungi Admin secara langsung untuk mereset password Anda.'])->withInput();
        }

        // Generate token reset
        $token = Str::random(60);

        // Hapus token lama jika ada, lalu simpan yang baru
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // URL Reset
        $baseUrl = env('APP_PUBLIC_URL', $request->getSchemeAndHttpHost());
        $resetUrl = rtrim($baseUrl, '/') . '/reset-password/' . $token . '?email=' . urlencode($request->email);

        // Pengiriman email asli / logging
        try {
            Mail::send('emails.reset_password', ['url' => $resetUrl, 'name' => $user->name], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('🔐 Reset Password Administrator - House of Salbai');
            });
        } catch (\Exception $e) {
            // Simpan link pemulihan ke session sebagai cadangan jika port SMTP Gmail di-block oleh Firewall/ISP lokal
            session()->flash('demo_reset_url', $resetUrl);
            session()->flash('demo_email_sent_to', $user->email);

            return redirect('/login')->with('warning', 'Token pemulihan berhasil dibuat! Namun jaringan/port SMTP Gmail di PC Anda mengalami kendala koneksi (' . Str::limit($e->getMessage(), 100) . '). Anda dapat menggunakan Link Pemulihan Darurat yang tampil di bawah!');
        }

        return redirect('/login')->with('success', 'Link pemulihan password berhasil dikirim ke email ' . $request->email . '. Silakan periksa kotak masuk Gmail Anda!');
    }

    public function resetPasswordForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('reset_password', compact('token', 'email'));
    }

    public function resetPasswordProcess(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            return redirect('/forgot-password')->withErrors(['email' => 'Permintaan reset tidak valid atau telah kedaluwarsa.']);
        }

        // Cek token cocok
        if (!Hash::check($request->token, $record->token)) {
            return redirect('/forgot-password')->withErrors(['email' => 'Token reset tidak valid atau tidak cocok.']);
        }

        // Cek kedaluwarsa (1 jam)
        if (\Carbon\Carbon::parse($record->created_at)->addHour()->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect('/forgot-password')->withErrors(['email' => 'Link reset telah kedaluwarsa (berlaku maksimal 1 jam).']);
        }

        // Update password
        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // Hapus token setelah berhasil digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password admin berhasil diperbarui! Silakan masuk dengan password baru Anda.');
    }

    // MANAGE USERS (Tambah/Hapus/Update pengguna lain)
    public function storeAdminUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,pegawai',
            'password' => 'required|string|min:6',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect('/dashboard')->with('success', 'Pengguna ' . $request->name . ' (' . $request->role . ') berhasil ditambahkan!');
    }

    public function deleteAdminUser($id)
    {
        if (\App\Models\User::count() <= 1) {
            return redirect('/dashboard')->with('error', 'Tidak bisa menghapus satu-satunya admin.');
        }
        if ($id == Auth::id()) {
            return redirect('/dashboard')->with('error', 'Tidak bisa menghapus akun Anda sendiri.');
        }
        \App\Models\User::destroy($id);
        return redirect('/dashboard')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function updateAdminUserPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $user = \App\Models\User::findOrFail($id);
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect('/dashboard')->with('success', 'Password untuk pengguna ' . $user->name . ' berhasil diubah!');
    }

    public function updateAdminUsername(Request $request, $id)
    {
        $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9_]+$/',
                \Illuminate\Validation\Rule::unique('users', 'username')->ignore($id),
            ],
        ], [
            'username.regex' => 'Username hanya boleh mengandung huruf, angka, dan underscore (_).',
            'username.unique' => 'Username ini sudah digunakan oleh pengguna lain.',
        ]);

        $user = \App\Models\User::findOrFail($id);
        $oldUsername = $user->username;
        $user->update(['username' => $request->username]);

        return redirect('/dashboard')->with('success', 'Username "' . $oldUsername . '" berhasil diubah menjadi "' . $request->username . '"!');
    }

    public function updateAdminUserEmail(Request $request, $id)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                \Illuminate\Validation\Rule::unique('users', 'email')->ignore($id),
            ],
        ], [
            'email.unique' => 'Alamat email ini sudah terdaftar untuk pengguna lain.',
        ]);

        $user = \App\Models\User::findOrFail($id);
        $oldEmail = $user->email;
        $user->update(['email' => $request->email]);

        return redirect('/dashboard')->with('success', 'Email untuk pengguna ' . $user->name . ' berhasil diubah menjadi "' . $request->email . '"!');
    }

    // APPROVAL ACTIONS
    public function approveAset($id)
    {
        $aset = \App\Models\Inventory::findOrFail($id);
        $aset->update(['approval_status' => 'approved']);
        return redirect('/dashboard')->with('success', 'Aset "' . $aset->nama_alat . '" berhasil disetujui!');
    }

    public function rejectAset(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string|max:1000',
        ], [
            'catatan_penolakan.required' => 'Alasan penolakan wajib diisi!'
        ]);

        $aset = \App\Models\Inventory::findOrFail($id);
        $aset->update([
            'approval_status' => 'rejected',
            'catatan_penolakan' => $request->catatan_penolakan
        ]);
        return redirect('/dashboard')->with('success', 'Aset "' . $aset->nama_alat . '" ditolak dengan alasan!');
    }

    public function approveAlbum($id)
    {
        $album = \App\Models\Album::findOrFail($id);
        $album->update(['approval_status' => 'approved']);
        return redirect('/dashboard')->with('success', 'Album "' . $album->judul_event . '" berhasil disetujui dan dipublikasikan!');
    }

    public function rejectAlbum(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string|max:1000',
        ], [
            'catatan_penolakan.required' => 'Alasan penolakan wajib diisi!'
        ]);

        $album = \App\Models\Album::findOrFail($id);
        $album->update([
            'approval_status' => 'rejected',
            'catatan_penolakan' => $request->catatan_penolakan
        ]);
        return redirect('/dashboard')->with('success', 'Album "' . $album->judul_event . '" ditolak dengan alasan!');
    }
}
