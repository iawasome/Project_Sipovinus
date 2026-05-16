# TODO - Detail Proker CRUD Task terintegrasi Anggaran

## Step 1: Tambah Migration (Schema)
- Buat migration untuk menambah `task_id` (nullable FK, onDelete cascade) pada tabel `anggarans`.
- Buat migration untuk menambah kolom pada tabel `tasks`: `nama_task`, `status` (enum), `anggaran_digunakan`.
- (Opsional) jika kolom lama masih ada: `task_name`, `is_completed`—tidak dihapus dulu agar kompatibel.

## Step 2: Update Model Relasi
- `Task`:
  - tambahkan fillable/casts/status enum bila perlu
  - relasi: belongsTo ProgramKerja
  - relasi: hasMany Anggaran (opsional)
- `Anggaran`:
  - relasi: belongsTo Task (task_id)
  - update relasi agar sesuai column naming yang dipakai
- `ProgramKerja`:
  - pastikan relasi tasks tetap benar

## Step 3: Update Controller Back-End
- `ProgramKerjaController@show($id)`:
  - eager load tasks + anggarans
  - hitung `dana_dialokasikan` = budget_estimate
  - hitung `dana_terpakai` = SUM anggarans.amount where type=expense
  - hitung `sisa_dana` = dana_dialokasikan - dana_terpakai
  - kirim ke view
- `storeTask(Request $request, $prokerId)`:
  - validasi (nama_task, status, anggaran_digunakan)
  - simpan Task
  - simpan Anggaran type=expense, amount=anggaran_digunakan, program_id=prokerId, task_id=taskId
  - pakai DB::transaction
- `updateTask(Request $request, $taskId)`:
  - update Task
  - update Anggaran yang terhubung lewat task_id
  - pakai DB::transaction
- `destroyTask($taskId)`:
  - delete Task (cascade hapus anggaran)

## Step 4: Tambah Routes
- Tambahkan route POST/PUT/DELETE sesuai requirement di `routes/web.php`.

## Step 5: Front-End View
- Buat `resources/views/pages/program-kerja/show.blade.php`:
  - card ringkasan proker (Nama, Divisi, Dana Awal, Dana Terpakai, Sisa)
  - tabel list Task dengan tombol edit & hapus
  - modal Tailwind untuk tambah task
  - modal untuk edit task
  - gunakan endpoint route sesuai Step 4

## Step 6: Integrasi + Testing Manual
- Jalankan migrate
- Cek:
  - tambah task → baris anggaran expense dibuat
  - edit task → nominal expense ikut berubah
  - hapus task → baris anggaran expense ikut terhapus


