@extends('layouts.operator')
@section('content')
<div class="max-w-7xl mx-auto p-8">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('operator.production.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-700 hover:text-brand-blue transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl text-sm font-bold shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[20px] shadow-sm w-full border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-100">
            <h2 class="text-xl font-extrabold text-gray-900">Detail & Update: {{ $order->invoice_no }}</h2>
        </div>
        
        <!-- Body -->
        <div class="px-8 py-8 grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Left: Riwayat -->
            <div class="space-y-4">
                <h3 class="text-sm font-extrabold text-gray-900 border-b border-gray-100 pb-3">Riwayat Produksi</h3>
                @forelse($order->production->logs ?? [] as $log)
                    <div class="mb-4">
                        <div class="text-xs text-gray-500 font-bold mb-1">{{ $log->created_at->format('d M Y, H:i') }}</div>
                        <div class="font-bold text-brand-blue">{{ $log->step->name }} Selesai</div>
                        <div class="text-sm text-gray-600 mt-1">{{ $log->notes }}</div>
                    </div>
                @empty
                    <p class="text-sm font-medium text-gray-400 italic pt-1">Belum ada riwayat update.</p>
                @endforelse
            </div>
            
            <!-- Right: Form Update -->
            <div class="bg-gray-50/50 rounded-2xl border border-gray-100 p-6 shadow-sm self-start">
                <h3 class="text-sm font-extrabold text-gray-900 mb-5">Form Update Baru</h3>
                
                <form action="{{ route('operator.tracking.store', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Tahap Selesai <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="production_step_id" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue appearance-none transition bg-white">
                                <option value="">Pilih tahap...</option>
                                @foreach($steps as $step)
                                    <option value="{{ $step->id }}">{{ $step->name }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down text-gray-400 text-xs absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Keterangan <span class="text-red-500">*</span></label>
                        <textarea name="notes" rows="3" required placeholder="Deskripsikan pekerjaan yang telah selesai..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition resize-none"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Foto Bukti Pengerjaan</label>
                        <input type="file" name="photo" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-brand-blue hover:file:bg-indigo-100 transition">
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-blue text-white hover:bg-indigo-700 transition shadow-[0_4px_12px_-4px_rgba(79,70,229,0.5)] text-sm font-bold w-full text-center whitespace-nowrap">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
