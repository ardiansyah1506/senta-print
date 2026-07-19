@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 mt-2 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-blue/5 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl pointer-events-none"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-2">
                <span class="bg-brand-blue/10 text-brand-blue px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Modul Akses</span>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2 mt-2">Manajemen User</h1>
            <p class="text-gray-500 font-medium text-sm max-w-xl leading-relaxed">Kelola data seluruh *Admin* dan *Operator* tersertifikasi yang diizinkan mengakses dan mengoperasikan Senta Print CMS.</p>
        </div>
        <div class="relative z-10 shrink-0">
            <button onclick="document.getElementById('modalTambahUser').classList.remove('hidden')" class="bg-brand-blue text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:shadow-indigo-500/40 transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Karyawan Baru
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm font-semibold mb-6 flex items-start gap-3 border border-green-100">
            <i class="fa-solid fa-circle-check mt-0.5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    
    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-semibold mb-6 border border-red-100">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden mb-12">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50/50">
            <div class="flex items-center gap-4 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-72">
                    <input type="text" placeholder="Cari karyawan..." class="w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-white shadow-sm font-medium">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white">
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">ID</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Nama Pegawai</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">No. WhatsApp / Login</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Hak Akses (Role)</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm font-medium text-gray-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="py-4 px-6 font-bold text-gray-400">#{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6">
                            <div class="text-gray-900 font-bold">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">Ditambahkan {{ $user->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="py-4 px-6 text-brand-blue font-bold tracking-wide">{{ $user->phone }}</td>
                        <td class="py-4 px-6">
                            @if($user->role === 'admin')
                                <span class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider border border-indigo-100 inline-block"><i class="fa-solid fa-shield-halved mr-1"></i> Admin</span>
                            @else
                                <span class="bg-amber-50 text-amber-600 px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider border border-amber-100 inline-block"><i class="fa-solid fa-clipboard-user mr-1"></i> Operator</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <form action="{{ route('admin.manajemen-user.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center border border-transparent hover:border-red-100" title="Hapus User">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-users-slash text-4xl mb-3 text-gray-300"></i>
                                <span class="font-semibold text-gray-500">Belum ada user terdaftar.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div id="modalTambahUser" class="fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center hidden opacity-100 transition-opacity backdrop-blur-sm">
    <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-lg mx-4 overflow-hidden border border-gray-100">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-gray-900">Tambah Karyawan Baru</h2>
            <button onclick="document.getElementById('modalTambahUser').classList.add('hidden')" class="text-gray-400 hover:text-gray-900 transition w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        
        <!-- Body -->
        <div class="px-8 py-6">
            <form action="{{ route('admin.manajemen-user.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Role / Hak Akses <span class="text-red-500">*</span></label>
                    <select name="role" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue appearance-none bg-gray-50/50">
                        <option value="operator">Operator Produksi</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Nama Pegawai <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white shadow-sm" placeholder="Contoh: Riko Wijaya">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">No. WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white shadow-sm" placeholder="Contoh: 081234567890">
                    <p class="text-[10px] text-gray-400 font-medium mt-1">Nomor ini digunakan untuk Login ke sistem.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Password Akses <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white shadow-sm" placeholder="Minimal 6 Karakter">
                </div>
                
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 mt-6">
                    <button type="button" onclick="document.getElementById('modalTambahUser').classList.add('hidden')" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition text-sm font-bold flex-1 text-center">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-blue text-white hover:bg-indigo-700 transition shadow-[0_4px_12px_-4px_rgba(79,70,229,0.5)] text-sm font-bold flex-1 text-center whitespace-nowrap">
                        Simpan Kredensial
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
