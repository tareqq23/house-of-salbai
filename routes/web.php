<?php

use Illuminate\Support\Facades\Route;
use App\Models\Inventory;
use App\Models\Album;
use App\Models\ContentManagementSystem;
use App\Models\Manifest;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    $inventories = Inventory::where('approval_status', 'approved')->get();
    $albums = Album::with(['galleries','previewGallery'])
        ->where('approval_status', 'approved')
        ->get();
    $settings = ContentManagementSystem::all()->pluck('value', 'key');
    
    return view('welcome', compact('inventories', 'albums', 'settings'));
});

// Admin Routes
Route::redirect('/admin', '/login');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AdminController::class, 'authenticate'])->middleware('throttle:5,1');

// ——— Google OAuth routes removed ———

// Forgot Password & Reset Routes
Route::get('/forgot-password', [AdminController::class, 'forgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AdminController::class, 'sendResetLinkEmail'])->middleware('throttle:3,1')->name('password.email');
Route::get('/reset-password/{token}', [AdminController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AdminController::class, 'resetPasswordProcess'])->middleware('throttle:5,1')->name('password.update');

Route::middleware(['auth', 'nocache'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    
    // CRUD Aset (Open for addition, but status handled by role in controller)
    Route::post('/admin/aset', [AdminController::class, 'storeAset']);

    // CRUD Album (Open for addition, but status handled by role in controller)
    Route::post('/admin/album', function (Request $request) {
        $request->validate([
            'judul_event' => 'required|string|max:255',
            'tanggal_event' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_event',
            'deskripsi_event' => 'nullable|string',
            'cover_album' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:102400',
            'preview_video' => 'nullable|file|mimes:mp4,mov,avi,webm|max:102400',
            'dokumentasi.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,webm|max:102400',
        ]);

        $coverPath = '-';
        $uploadDir = public_path('uploads/albums');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if ($request->hasFile('cover_album')) {
            $coverFile = $request->file('cover_album');
            $coverName = 'cover_' . time() . '.' . $coverFile->getClientOriginalExtension();
            $coverFile->move($uploadDir, $coverName);
            $coverPath = 'uploads/albums/' . $coverName;
        }

        // Pegawai uploads default to pending approval
        $status = (Auth::user() && Auth::user()->isPegawai()) ? 'pending' : 'approved';

        $album = Album::create([
            'judul_event'    => $request->judul_event,
            'tanggal_event'  => $request->tanggal_event ?? now(),
            'tanggal_selesai' => $request->tanggal_selesai ?: null,
            'deskripsi_event' => $request->deskripsi_event,
            'cover_album'    => $coverPath,
            'approval_status' => $status
        ]);

        $firstImagePath = null;
        if ($request->hasFile('preview_video')) {
            $file = $request->file('preview_video');
            $filename = time() . rand(100,999) . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move($uploadDir, $filename);
            $previewGallery = \App\Models\Gallery::create([
                'album_id' => $album->id,
                'file_path' => 'uploads/albums/' . $filename,
                'file_type' => 'video'
            ]);
            $album->update(['preview_gallery_id' => $previewGallery->id]);
        }

        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                $fileType = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';
                $filename = time() . rand(100,999) . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
                $file->move($uploadDir, $filename);
                $gallery = \App\Models\Gallery::create([
                    'album_id'  => $album->id,
                    'file_path' => 'uploads/albums/' . $filename,
                    'file_type' => $fileType
                ]);
                if ($fileType === 'image' && $firstImagePath === null) {
                    $firstImagePath = 'uploads/albums/' . $filename;
                }
            }
        }

        if ($coverPath === '-' && $firstImagePath) {
            $album->update(['cover_album' => $firstImagePath]);
        }

        $msg = (Auth::user() && Auth::user()->isPegawai()) 
            ? 'Album berhasil diunggah dan sedang menunggu persetujuan Admin!' 
            : 'Album dan File Dokumentasi Berhasil Diunggah!';

        return redirect('/dashboard')->with('success', $msg);
    });

    // CRUD Manifest (Pegawai can create manifest too)
    Route::post('/admin/manifes', [AdminController::class, 'storeManifes']);

    Route::get('/admin/manifes/print/{id}', function ($id) {
        $m = Manifest::with('items.inventory')->findOrFail($id);
        $settings = ContentManagementSystem::all()->pluck('value', 'key');
        return view('print_manifest', compact('m', 'settings'));
    });

    // Update & Resubmit Aset/Album (Accessible by Pegawai & Admin)
    Route::post('/admin/aset/update/{id}', [AdminController::class, 'updateAset']);
    Route::post('/admin/album/update/{id}', [AdminController::class, 'updateAlbum']);

    // Dismiss Rejection Notes (Accessible by Pegawai & Admin)
    Route::post('/admin/aset/dismiss-rejection/{id}', [AdminController::class, 'dismissRejectionAset']);
    Route::post('/admin/album/dismiss-rejection/{id}', [AdminController::class, 'dismissRejectionAlbum']);

    // ADMIN ONLY ROUTES
    Route::middleware('admin.only')->group(function () {
        // Cetak Laporan Bulanan
        Route::get('/admin/laporan/print', [AdminController::class, 'printLaporanBulanan']);

        // CRUD Aset Admin Only
        Route::delete('/admin/aset/delete/{id}', [AdminController::class, 'deleteAset']);
        
        // Approval Aset
        Route::post('/admin/aset/approve/{id}', [AdminController::class, 'approveAset']);
        Route::post('/admin/aset/reject/{id}', [AdminController::class, 'rejectAset']);

        // Album Admin Only
        Route::delete('/admin/album/delete/{id}', function ($id) {
            $album = Album::find($id);
            if ($album) {
                foreach($album->galleries as $g) {
                    if(file_exists(public_path($g->file_path))) { @unlink(public_path($g->file_path)); }
                }
                $album->delete();
            }
            return redirect('/dashboard')->with('success', 'Album Berhasil Dihapus!');
        });
        
        // Approval Album
        Route::post('/admin/album/approve/{id}', [AdminController::class, 'approveAlbum']);
        Route::post('/admin/album/reject/{id}', [AdminController::class, 'rejectAlbum']);

        // Delete Gallery item
        Route::delete('/admin/gallery/delete/{id}', function ($id) {
            $g = \App\Models\Gallery::find($id);
            if ($g) {
                if(file_exists(public_path($g->file_path))) { @unlink(public_path($g->file_path)); }
                $album = $g->album;
                $g->delete();
                if ($album && $album->preview_gallery_id == $id) {
                    $album->update(['preview_gallery_id' => null]);
                }
                return response()->json(['success' => true, 'message' => 'File berhasil dihapus!']);
            }
            return response()->json(['success' => false, 'message' => 'File tidak ditemukan!'], 404);
        });

        // CRUD Manifest Admin Only
        Route::delete('/admin/manifes/delete/{id}', [AdminController::class, 'deleteManifes']);
        Route::post('/admin/manifes/update/{id}', [AdminController::class, 'updateManifes']);
        Route::post('/admin/manifes/return/{id}', [AdminController::class, 'returnManifes']);

        // CRUD Vendor (Private)
        Route::post('/admin/vendor', function (Request $request) {
            Vendor::create([
                'nama_vendor' => $request->nama_vendor,
                'kategori_layanan' => $request->kategori_layanan,
                'kontak_person' => $request->kontak_person,
                'nomor_telepon' => $request->nomor_telepon,
                'alamat' => $request->alamat
            ]);
            return redirect('/dashboard')->with('success', 'Data Vendor Berhasil Ditambahkan!');
        });
        Route::delete('/admin/vendor/delete/{id}', function ($id) {
            Vendor::destroy($id);
            return redirect('/dashboard')->with('success', 'Data Vendor Berhasil Dihapus!');
        });

        // CRUD Company Profile & Logo
        Route::post('/admin/setting', function (Request $request) {
            $request->validate([
                'company_name' => 'nullable|string|max:255',
                'company_logo' => 'nullable|file|mimes:png,jpg,jpeg,webp,svg|max:5120',
                'hero_image'   => 'nullable|file|mimes:png,jpg,jpeg,webp|max:8192',
                'about_image'  => 'nullable|file|mimes:png,jpg,jpeg,webp|max:8192',
            ]);

            ContentManagementSystem::updateOrCreate(['key' => 'company_name'], ['value' => $request->company_name]);
            ContentManagementSystem::updateOrCreate(['key' => 'hero_badge_text'], ['value' => $request->hero_badge_text]);
            ContentManagementSystem::updateOrCreate(['key' => 'hero_title'], ['value' => $request->hero_title]);
            ContentManagementSystem::updateOrCreate(['key' => 'company_description'], ['value' => $request->company_description]);
            ContentManagementSystem::updateOrCreate(['key' => 'phone'], ['value' => $request->phone]);
            ContentManagementSystem::updateOrCreate(['key' => 'email'], ['value' => $request->email]);
            ContentManagementSystem::updateOrCreate(['key' => 'address'], ['value' => $request->address]);
            ContentManagementSystem::updateOrCreate(['key' => 'whatsapp'], ['value' => $request->whatsapp]);
            
            ContentManagementSystem::updateOrCreate(['key' => 'hero_stat_1_label'], ['value' => $request->hero_stat_1_label]);
            ContentManagementSystem::updateOrCreate(['key' => 'hero_stat_1_val'], ['value' => $request->hero_stat_1_val]);
            ContentManagementSystem::updateOrCreate(['key' => 'hero_stat_2_label'], ['value' => $request->hero_stat_2_label]);
            ContentManagementSystem::updateOrCreate(['key' => 'hero_stat_2_val'], ['value' => $request->hero_stat_2_val]);

            // NEW DYNAMIC FIELDS
            ContentManagementSystem::updateOrCreate(['key' => 'catalog_header'], ['value' => $request->catalog_header]);
            ContentManagementSystem::updateOrCreate(['key' => 'portfolio_header'], ['value' => $request->portfolio_header]);
            ContentManagementSystem::updateOrCreate(['key' => 'cta_text'], ['value' => $request->cta_text]);
            ContentManagementSystem::updateOrCreate(['key' => 'wa_message'], ['value' => $request->wa_message]);
            ContentManagementSystem::updateOrCreate(['key' => 'sosmed_ig'], ['value' => $request->sosmed_ig]);
            ContentManagementSystem::updateOrCreate(['key' => 'sosmed_yt'], ['value' => $request->sosmed_yt]);
            ContentManagementSystem::updateOrCreate(['key' => 'sosmed_tk'], ['value' => $request->sosmed_tk]);
            
            ContentManagementSystem::updateOrCreate(['key' => 'hero_prefix'], ['value' => $request->hero_prefix]);
            ContentManagementSystem::updateOrCreate(['key' => 'hero_subtitle'], ['value' => $request->hero_subtitle]);

            ContentManagementSystem::updateOrCreate(['key' => 'about_header'], ['value' => $request->about_header]);
            ContentManagementSystem::updateOrCreate(['key' => 'about_point_1'], ['value' => $request->about_point_1]);
            ContentManagementSystem::updateOrCreate(['key' => 'about_point_2'], ['value' => $request->about_point_2]);
            
            // FILE HANDLING WITH CLEANUP
            if ($request->hasFile('company_logo')) {
                $old = ContentManagementSystem::where('key', 'company_logo')->first();
                if($old && $old->value && file_exists(public_path('img/'.$old->value))) { @unlink(public_path('img/'.$old->value)); }
                $file = $request->file('company_logo');
                $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img'), $filename);
                ContentManagementSystem::updateOrCreate(['key' => 'company_logo'], ['value' => $filename]);
            }

            if ($request->hasFile('hero_image')) {
                $old = ContentManagementSystem::where('key', 'hero_image')->first();
                if($old && $old->value && file_exists(public_path('img/'.$old->value))) { @unlink(public_path('img/'.$old->value)); }
                $file = $request->file('hero_image');
                $filename = 'hero_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img'), $filename);
                ContentManagementSystem::updateOrCreate(['key' => 'hero_image'], ['value' => $filename]);
            }

            if ($request->hasFile('about_image')) {
                $old = ContentManagementSystem::where('key', 'about_image')->first();
                if($old && $old->value && file_exists(public_path('img/'.$old->value))) { @unlink(public_path('img/'.$old->value)); }
                $file = $request->file('about_image');
                $filename = 'about_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img'), $filename);
                ContentManagementSystem::updateOrCreate(['key' => 'about_image'], ['value' => $filename]);
            }
            
            return redirect('/dashboard')->with('success', 'Profil & Visual Perusahaan Berhasil Diperbarui!');
        });

        // Reset/Delete Settings
        Route::get('/admin/setting/reset/{key}', function ($key) {
            $s = ContentManagementSystem::where('key', $key)->first();
            if ($s) {
                if (in_array($key, ['company_logo', 'hero_image', 'about_image'])) {
                    if(file_exists(public_path('img/'.$s->value))) { @unlink(public_path('img/'.$s->value)); }
                }
                $s->delete();
            }
            return redirect('/dashboard')->with('success', 'Konten berhasil direset ke standar!');
        });

        // MANAGE USERS
        Route::post('/admin/users', [AdminController::class, 'storeAdminUser']);
        Route::delete('/admin/users/delete/{id}', [AdminController::class, 'deleteAdminUser']);
        Route::post('/admin/users/{id}/password', [AdminController::class, 'updateAdminUserPassword']);
        Route::post('/admin/users/{id}/username', [AdminController::class, 'updateAdminUsername']);
        Route::post('/admin/users/{id}/email', [AdminController::class, 'updateAdminUserEmail']);
    });
});
