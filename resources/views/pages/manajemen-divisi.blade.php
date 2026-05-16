@extends('layouts.app')

@section('content')
  <div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12">
      <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Manajemen Divisi</h2>
        <p class="text-gray-600 dark:text-gray-300">Menu ini tampil khusus admin (role_id == 1). Isi sesuai kebutuhan modul manajemen divisi Anda.</p>
      </div>
    </div>
  </div>
@endsection

