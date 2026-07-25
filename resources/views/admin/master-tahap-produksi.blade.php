@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 mt-2 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-blue/5 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl pointer-events-none"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-2">
                <span class="bg-brand-blue/10 text-brand-blue px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Modul Produksi</span>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2 mt-2">Master Tahap Produksi</h1>
            <p class="text-gray-500 font-medium text-sm max-w-xl leading-relaxed">Kelola urutan dan nama langkah alur kerja produksi cetak yang digunakan oleh operator untuk update progress pesanan.</p>
        </div>
        <div class="relative z-10 shrink-0">
            <button onclick="document.getElementById('modalTambahTahap').classList.remove('hidden')" class="bg-brand-blue text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:shadow-indigo-500/40 transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Tahap Baru
            </button>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="bg-white rounded-3xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden mb-12">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="text-lg font-extrabold text-gray-900">Daftar Langkah Produksi</h2>
            <span class="text-xs text-gray-400 font-bold bg-white px-3 py-1.5 rounded-lg border border-gray-200">Diurutkan berdasarkan Sort Order</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white">
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 w-24 text-center">Urutan</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Nama Tahap Produksi</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Tanggal Dibuat</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-right w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm font-medium text-gray-700">
                    @forelse($steps as $step)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="py-4 px-6 text-center">
                            <span class="bg-indigo-50 text-brand-blue font-extrabold px-3 py-1 rounded-lg text-xs border border-indigo-100">
                                #{{ $step->sort_order }}
                            </span>
                        </td>
                        <td class="py-4 px-6 font-extrabold text-gray-900 text-base">
                            {{ $step->name }}
                        </td>
                        <td class="py-4 px-6 text-xs text-gray-400 font-semibold">
                            {{ $step->created_at ? $step->created_at->format('d M Y, H:i') : '-' }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openEditModal({{ $step->id }}, '{{ addslashes($step->name) }}', {{ $step->sort_order }})" title="Edit Tahap" class="text-gray-400 hover:text-brand-blue transition w-9 h-9 rounded-xl hover:bg-indigo-50 flex items-center justify-center border border-transparent hover:border-indigo-100">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('admin.tahap-produksi.destroy', $step->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tahap produksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Tahap" class="text-gray-400 hover:text-red-500 transition w-9 h-9 rounded-xl hover:bg-red-50 flex items-center justify-center border border-transparent hover:border-red-100">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-layer-group text-4xl mb-3 text-gray-300"></i>
                                <span class="font-semibold text-gray-500">Belum ada tahap produksi terdaftar.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($steps->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-center bg-gray-50/30">
            {{ $steps->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Tambah Tahap Produksi -->
<div id="modalTambahTahap" class="fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center hidden opacity-100 transition-opacity backdrop-blur-sm">
    <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-lg mx-4 overflow-hidden border border-gray-100">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-gray-900">Tambah Tahap Produksi Baru</h2>
            <button onclick="document.getElementById('modalTambahTahap').classList.add('hidden')" class="text-gray-400 hover:text-gray-900 transition w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="px-8 py-6">
            <form action="{{ route('admin.tahap-produksi.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Nama Tahap Produksi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white shadow-sm" placeholder="Contoh: Desain / File Check, Cetak, Finishing...">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Urutan (Sort Order)</label>
                    <input type="number" name="sort_order" min="0" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white shadow-sm" placeholder="Kosongkan untuk otomatis mengisi urutan berikutnya">
                    <p class="text-[10px] text-gray-400 font-medium mt-1">Angka lebih kecil akan ditampilkan lebih awal pada alur kerja operator.</p>
                </div>
                
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 mt-6">
                    <button type="button" onclick="document.getElementById('modalTambahTahap').classList.add('hidden')" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition text-sm font-bold flex-1 text-center">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-blue text-white hover:bg-indigo-700 transition shadow-[0_4px_12px_-4px_rgba(79,70,229,0.5)] text-sm font-bold flex-1 text-center whitespace-nowrap">
                        Simpan Tahap Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Tahap Produksi -->
<div id="modalEditTahap" class="fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center hidden opacity-100 transition-opacity backdrop-blur-sm">
    <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-lg mx-4 overflow-hidden border border-gray-100">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-gray-900">Edit Tahap Produksi</h2>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-900 transition w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="px-8 py-6">
            <form id="formEditTahap" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Nama Tahap Produksi <span class="text-red-500">*</span></label>
                    <input type="text" id="editName" name="name" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white shadow-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Urutan (Sort Order) <span class="text-red-500">*</span></label>
                    <input type="number" id="editSortOrder" name="sort_order" min="0" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white shadow-sm">
                </div>
                
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 mt-6">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition text-sm font-bold flex-1 text-center">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-blue text-white hover:bg-indigo-700 transition shadow-[0_4px_12px_-4px_rgba(79,70,229,0.5)] text-sm font-bold flex-1 text-center whitespace-nowrap">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(id, name, sortOrder) {
    const modal = document.getElementById('modalEditTahap');
    const form = document.getElementById('formEditTahap');
    const editName = document.getElementById('editName');
    const editSortOrder = document.getElementById('editSortOrder');

    form.action = "{{ url('admin/tahap-produksi') }}/" + id;
    editName.value = name;
    editSortOrder.value = sortOrder;

    modal.classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('modalEditTahap').classList.add('hidden');
}
</script>
@endsection
