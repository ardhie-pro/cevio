<?php

use App\Http\Controllers\KumpulanModulController;
use App\Http\Controllers\GrupKolomConntroller;
use App\Http\Controllers\KodeLoginController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KodeGeneratorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SoalMultipleChoiceController;
use App\Http\Controllers\KelompokSoalController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\TarikModulController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EventController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;


Route::get('/menunggu-konfirmasi', function () {
    return view('auth.menunggu-konfirmasi');
})->name('menunggu.konfirmasi');
Route::get('/akses', function () {
    return view('utama.sits');
});
Route::get('/pendahuluan', function () {
    return view('utama.pagependahuluan');
});

Route::get('/download-template-soal', function () {
    // Path ke file template Word kamu di folder resources/views/template
    $path = resource_path('views/template/soal.docx');
    // Pastikan file-nya ada
    if (!file_exists($path)) {
        abort(404, '⚠️ Template tidak ditemukan di: ' . $path);
    }
    // Kirim file untuk di-download
    return Response::download(
        $path,
        'Template_Soal.docx',
        ['Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
    );
})->name('download.template.soal');



Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/dashboard', function () {
    return redirect()->route('event.index');
});
Route::get('/history', [KodeLoginController::class, 'history'])->name('history.login');
Route::get('/hasiluser/{kode}', [LaporanController::class, 'hasiluser'])->name('hasiluser.show');
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/kode', [KodeLoginController::class, 'index'])->name('kode.login');
    Route::post('/kode/check', [KodeLoginController::class, 'check'])->name('kode.check');
    Route::post('/akun/update', [KodeLoginController::class, 'update'])->name('akun.update');
});



Route::middleware(['auth', 'role:project-manajer,manajer'])->group(function () {
    // halaman event input update delete
    Route::get('event', [EventController::class, 'index'])->name('event.index');
    Route::post('event', [EventController::class, 'store'])->name('event.store');
    Route::put('event/{event}', [EventController::class, 'update'])->name('event.update');
    Route::post('/event/{event}/status', [EventController::class, 'updateStatus'])
        ->name('event.update.status');
    Route::delete('event/{event}', [EventController::class, 'destroy'])->name('event.destroy');

    // pusat data
    Route::get('/event/{id}/pdf', [EventController::class, 'pdfSemua'])
        ->name('event.pdfSemua');


    //detail event
    Route::resource('event', EventController::class);

    // pemasukan & pengeluaran
    Route::get('/event/{id}/keuangan', [EventController::class, 'keuangan'])->name('event.keuangan');
    Route::post('/event/{id}/pemasukan', [EventController::class, 'tambahPemasukan'])->name('event.pemasukan');
    Route::post('/event/{id}/pengeluaran', [EventController::class, 'tambahPengeluaran'])->name('event.pengeluaran');

    // tambah kru
    Route::get('/event/{id}/kru', [EventController::class, 'kru'])->name('event.kru');
    Route::post('/event/{id}/kru', [EventController::class, 'tambahKru'])->name('event.kru');
    Route::get(
        '/event/{event}/kru/{user}/invoice-total',
        [EventController::class, 'invoiceTotal']
    )
        ->name('event.kru.invoice.total');

    Route::get('/event/{id}/kru/rekap-invoice', [EventController::class, 'rekapInvoice'])
        ->name('event.kru.rekap.invoice');


    // role
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');

    Route::post('/role/{id}/shift/store', [RoleController::class, 'tambahShift'])->name('shift.store');
    Route::delete('/shift/{id}/delete', [RoleController::class, 'deleteShift'])->name('shift.delete');
    Route::get('/role/{id}/shifts', [EventController::class, 'getShifts']);

    Route::delete('/role/{id}/delete', [RoleController::class, 'deleteRole'])->name('role.delete');


    // halaman review
    Route::get('/tampilkankode', [App\Http\Controllers\ReviewController::class, 'tampilkankode'])->name('tampilkankode.index');
    Route::get('/review', [App\Http\Controllers\ReviewController::class, 'index'])->name('review.index');
    Route::get('/review/{kode}', [App\Http\Controllers\ReviewController::class, 'show'])->name('review.show');
    Route::get('/review/{kode}/{modul}', [App\Http\Controllers\ReviewController::class, 'detail'])->name('review.detail');
});

Route::middleware(['auth', 'role:manajer'])->group(function () {
    // dasboard Admin
    Route::post('user/status/{id}', [AdminController::class, 'approveUser'])
        ->name('admin.updateUserStatus');
    // Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/dashboard/generate-user', [AdminController::class, 'generateUser'])
        ->name('admin.generateUser');
    Route::get('/akun', [AdminController::class, 'akun'])->name('admin.akun');
    Route::get('/user', [AdminController::class, 'user'])->name('admin.user');
    Route::post('/user/buatakun', [AdminController::class, 'buatakun'])->name('user.buatakun');
    Route::post('/user/buatgrup', [AdminController::class, 'buatgrup'])->name('user.buatgrup');
    Route::delete('/hapus-grup/{id}', [AdminController::class, 'hapusGrup'])->name('user.hapusgrup');
    Route::post('/user/update-grup/{id}', [AdminController::class, 'updateGrup'])->name('user.updateGrup');
    Route::post('/user/hapus-grup/{id}', [AdminController::class, 'hapusbGrup'])->name('user.hapusbGrup');



    Route::resource('kumpulan-modul', KumpulanModulController::class);
    // ✅ Halaman tabel user
    Route::get('/dashboard/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/dashboard/users/delete/{id}', [AdminController::class, 'deleteUser'])
        ->name('admin.deleteUser');
    Route::post('/dashboard/galeri', [AdminController::class, 'galeriStore'])->name('admin.galeri.store');
    Route::post('/dashboard/galeri/update/{id}', [AdminController::class, 'galeriUpdate'])->name('admin.galeri.update');
    Route::delete('/dashboard/galeri/delete/{id}', [AdminController::class, 'galeriDelete'])->name('admin.galeri.delete');
    // ✅ Update user — pakai method updateUser (bukan update)
    Route::post('/dashboard/users/update/{user}', [AdminController::class, 'updateUser'])
        ->name('admin.updateUser');
    // buat kode
    Route::get('/generate-kode', [KodeGeneratorController::class, 'index'])->name('generate-kode.index');
    Route::post('/generate-kode', [KodeGeneratorController::class, 'store'])->name('generate-kode.store');
    Route::delete('/generate-kode/{id}', [KodeGeneratorController::class, 'destroy'])->name('generate-kode.destroy');
    // admin view soal multiple
    Route::prefix('soal-multiple')->name('soal-multiple.')->group(function () {
        Route::get('/', [SoalMultipleChoiceController::class, 'index'])->name('index');
        Route::get('/create', [SoalMultipleChoiceController::class, 'create'])->name('create');
        Route::post('/store', [SoalMultipleChoiceController::class, 'store'])->name('store');
        Route::put('/{id}', [SoalMultipleChoiceController::class, 'update'])->name('update');
        Route::delete('/{id}', [SoalMultipleChoiceController::class, 'destroy'])->name('destroy');
    });
    // vie admin soal
    Route::get('/soal', [SoalController::class, 'index'])->name('soal.index');
    Route::post('/soal/import-preview', [SoalController::class, 'importPreview'])->name('soal.importPreview');
    Route::post('/soal/import-save', [SoalController::class, 'importSave'])->name('soal.importSave');
    Route::post('/soal/generate', [SoalController::class, 'generateSoal'])->name('soal.generate');
    Route::post('/soal', [SoalController::class, 'store'])->name('soal.store');
    Route::post('/soal/import-word', [SoalController::class, 'importWord'])->name('soal.importWord');
    Route::put('/soal/{id}', [SoalController::class, 'update'])->name('soal.update');
    Route::delete('/soal/{id}', [SoalController::class, 'destroy'])->name('soal.destroy');
    Route::post('/soal/delete-all', [SoalController::class, 'deleteAll'])
        ->name('soal.deleteAll');


    // kunci jawaban
    Route::get('/kunci-jawaban/{modul}/{type_template}', [SoalController::class, 'show'])->name('kunci-jawaban.show');
    Route::post('/kunci-jawaban/simpan', [SoalController::class, 'simpan'])->name('kunci-jawaban.simpan');
    Route::post('/kunci-jawaban/simpan-tanpa-kembali', [SoalController::class, 'simpanTanpaKembali'])
        ->name('kunci-jawaban.simpan-tanpa-kembali');
    // laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{kode}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::get('/laporan/{kode}/{user_id}', [LaporanController::class, 'detail'])->name('laporan.detail');
    // tarikmodul routes
    Route::get('/tarik-modul', [TarikModulController::class, 'index'])->name('tarik-modul.index');
    Route::post('/tarik-modul', [TarikModulController::class, 'store'])->name('tarik-modul.store');
    Route::post('/tarik-modul/update/{id}', [TarikModulController::class, 'update'])->name('tarik-modul.update');
    Route::delete('/tarik-modul/{id}', [TarikModulController::class, 'destroy'])->name('tarik-modul.destroy');
    // kelompok soal routes
    Route::get('/kelompok-soal', [KelompokSoalController::class, 'index'])->name('kelompok-soal.index');
    Route::post('/kelompok-soal', [KelompokSoalController::class, 'store']);
    Route::get('/kelompok-soal/{id}/edit', [KelompokSoalController::class, 'edit'])->name('kelompok-soal.edit');
    Route::resource('kelompok-soal', KelompokSoalController::class);
    Route::put('/kelompok-soal/{id}', [KelompokSoalController::class, 'update']);
    Route::delete('/kelompok-soal/{id}', [KelompokSoalController::class, 'destroy']);

    Route::get('/grupangkahilang', [GrupKolomConntroller::class, 'index'])->name('grupangkahilang.index');
    Route::get('/grupkolom/{nama}', [GrupKolomConntroller::class, 'detail'])->name('grup.detail');
    // UPDATE nama_grup (pakai modal)
    Route::put('/updategrup/{id}', [GrupKolomConntroller::class, 'updatek'])->name('grup.update');
    // DELETE nama_grup + hapus semua modul
    Route::delete('/destroy/{nama}', [GrupKolomConntroller::class, 'destroy'])->name('grup.destroy');

    // angka hilang grup
    Route::post('/grupkolom/generate', [GrupKolomConntroller::class, 'generate'])
        ->name('grupkolom.generate');
    Route::put('/modul/update/{id}', [GrupKolomConntroller::class, 'update'])->name('modul.update');
    Route::delete('/modul/delete/{id}', [GrupKolomConntroller::class, 'delete'])->name('modul.delete');
    Route::post('/grupkolom/tambah-kolom', [GrupKolomConntroller::class, 'tambahKolom'])
        ->name('grup.tambahKolom');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/get-soal-multiple/{modul}', [SoalMultipleChoiceController::class, 'getSoalByModul']);
Route::get('/get-soal/{modul}/{no}', [AdminController::class, 'getSoal']);
Route::post('/simpan-jawaban', [AdminController::class, 'simpanJawaban']);
// mengambil soal dan jawaban terakhir apabila ke logout dan login lagi
Route::get('/get-jawaban/{modul}/{kodeLogin}', [SoalMultipleChoiceController::class, 'getJawaban']);
Route::get('/logouttest', [KodeLoginController::class, 'logoutTest'])->name('logouttest');
Route::get('/ujian', [SoalMultipleChoiceController::class, 'ujian'])->name('ujian');
Route::post('/next-modul', [SoalMultipleChoiceController::class, 'nextModul'])->name('next.modul');

require __DIR__ . '/auth.php';
