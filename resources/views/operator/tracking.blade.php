@extends('layouts.operator')
@section('content')
<div class="max-w-7xl mx-auto p-8">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('operator.production.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-700 hover:text-brand-blue transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Produksi
        </a>
    </div>
    
    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl text-sm font-bold shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl text-sm font-bold shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-red-600"></i> {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-[20px] shadow-sm w-full border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">Detail & Progress Produksi: {{ $order->invoice_no }}</h2>
                <p class="text-xs text-gray-500 font-medium">Customer: <span class="font-bold text-gray-800">{{ $order->customer->name ?? '-' }}</span> ({{ $order->customer->phone ?? '-' }})</p>
            </div>
            <span class="px-3 py-1 bg-indigo-50 text-brand-blue font-extrabold text-xs rounded-full border border-indigo-100 self-start sm:self-auto">
                Status: {{ strtoupper($order->status) }}
            </span>
        </div>

        <!-- Sequential Steps Progress Bar Header -->
        <div class="px-8 py-5 bg-indigo-50/40 border-b border-indigo-100/60">
            <h4 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-3">Alur Tahap Produksi (Berurutan):</h4>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2">
                @foreach($allSteps as $idx => $st)
                    @php
                        $isCompleted = in_array($st->id, $completedStepIds);
                        $isCurrentNext = ($nextStep && $nextStep->id == $st->id);
                    @endphp
                    <div class="p-2.5 rounded-xl border text-center text-xs font-bold transition flex flex-col justify-between items-center gap-1 {{ $isCompleted ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : ($isCurrentNext ? 'bg-brand-blue text-white border-brand-blue shadow-sm' : 'bg-white border-gray-200 text-gray-400') }}">
                        <span class="text-[9px] uppercase tracking-wider font-extrabold opacity-80">Tahap {{ $idx + 1 }}</span>
                        <span class="truncate w-full">{{ $st->name }}</span>
                        @if($isCompleted)
                            <i class="fa-solid fa-circle-check text-emerald-600 text-xs mt-0.5"></i>
                        @elseif($isCurrentNext)
                            <span class="text-[9px] bg-white/20 px-2 py-0.5 rounded-full font-extrabold text-white">Aktif Now</span>
                        @else
                            <i class="fa-regular fa-circle text-gray-300 text-xs mt-0.5"></i>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Body -->
        <div class="px-8 py-8 grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Left: Riwayat Progress & Foto -->
            <div class="space-y-6">
                <h3 class="text-sm font-extrabold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-brand-blue"></i> Riwayat Tahap yang Telah Selesai
                </h3>
                
                <div class="space-y-4">
                    @forelse($order->production->logs ?? [] as $log)
                        <div class="p-4 border border-gray-200/80 rounded-2xl bg-gray-50/50 space-y-2.5">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-extrabold text-brand-blue text-sm flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-xs"></i> {{ $log->step->name ?? 'Tahap' }} Selesai
                                </span>
                                <span class="text-[10px] text-gray-400 font-bold">{{ $log->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            
                            <p class="text-xs text-gray-700 font-medium bg-white p-3 rounded-xl border border-gray-100">{{ $log->notes }}</p>
                            
                            <!-- Photos Gallery -->
                            @if($log->photos && $log->photos->count() > 0)
                            <div class="pt-1">
                                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider block mb-1.5">Foto Bukti Pengerjaan ({{ $log->photos->count() }}):</span>
                                <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                    @foreach($log->photos as $photo)
                                    <a href="{{ asset('storage/' . $photo->file_path) }}" target="_blank" class="w-full h-20 rounded-xl overflow-hidden border border-gray-200 bg-white block relative group shadow-2xs">
                                        <img src="{{ asset('storage/' . $photo->file_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs">
                                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-6 border-2 border-dashed border-gray-200 rounded-2xl text-center text-sm font-medium text-gray-400 italic">
                            Belum ada riwayat tahap produksi yang diselesaikan.
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Right: Form Input Tahap Selanjutnya (Strict Sequential Order) -->
            <div class="bg-gray-50/70 rounded-2xl border border-gray-200/80 p-6 shadow-sm self-start space-y-5">
                @if($nextStep)
                    <div class="bg-white border border-indigo-100 rounded-2xl p-4 space-y-2 shadow-xs">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-extrabold text-gray-400 uppercase tracking-wider">Tahap Produksi Berikunya</span>
                            <span class="bg-indigo-50 text-brand-blue px-3 py-1 rounded-full font-extrabold text-xs">Tahap {{ $nextStepIndex }} dari {{ $allSteps->count() }}</span>
                        </div>
                        <h4 class="text-lg font-extrabold text-brand-blue flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right-long"></i> {{ $nextStep->name }}
                        </h4>
                        <p class="text-xs text-gray-500 font-medium">Sistem menentukan tahap ini secara otomatis agar pengerjaan produksi berjalan runtut.</p>
                    </div>

                    <form action="{{ route('operator.tracking.store', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Catatan Pengerjaan Tahap {{ $nextStep->name }} <span class="text-red-500">*</span></label>
                            <textarea name="notes" rows="3" required placeholder="Jelaskan detail pengerjaan tahap {{ $nextStep->name }}..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition resize-none bg-white"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Upload Multi-Foto Bukti Pengerjaan</label>
                            <p class="text-[10px] text-gray-400 font-medium mb-2">Pilih foto bukti hasil {{ $nextStep->name }} (PNG, JPG, Max 10MB per foto)</p>
                            <input type="file" name="photos[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-brand-blue hover:file:bg-indigo-100 transition cursor-pointer border border-gray-200 rounded-xl bg-white p-2">
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" class="px-5 py-3.5 rounded-xl bg-brand-blue text-white hover:bg-indigo-700 transition shadow-md shadow-brand-blue/20 text-xs font-bold w-full text-center flex items-center justify-center gap-2">
                                Selesaikan Tahap {{ $nextStep->name }} <i class="fa-solid fa-check"></i>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="p-8 bg-emerald-50 border border-emerald-200 rounded-2xl text-center space-y-3">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto text-xl font-bold">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <h4 class="text-base font-extrabold text-emerald-900">Seluruh Tahap Produksi Selesai!</h4>
                        <p class="text-xs text-emerald-700 font-medium leading-relaxed">
                            Pesanan ini telah menyelesaikan 100% alur tahap produksi dan berstatus <span class="font-bold uppercase">SELESAI (COMPLETED)</span>.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
