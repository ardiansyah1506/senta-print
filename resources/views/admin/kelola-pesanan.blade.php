@extends('layouts.admin')
@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Kelola Pesanan</h1>
        <p class="text-gray-500 text-sm font-medium">Lihat, konfirmasi pembayaran, dan kirim notifikasi WhatsApp ke customer</p>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-sm flex flex-col">
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100">
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Invoice / No.</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Total Item</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Estimasi Biaya</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Status Bayar</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Tahap Produksi</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider text-center">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-semibold text-gray-700 bg-white">
                    @forelse($orders as $order)
                    @php
                        $payStatus = strtoupper($order->payment_status ?? 'PENDING');
                        $isPaid = ($payStatus === 'PAID' || $payStatus === 'LUNAS');
                        
                        $currentStepName = 'Menunggu Pembayaran';
                        if ($order->production && $order->production->logs->isNotEmpty()) {
                            $lastLog = $order->production->logs->last();
                            if ($lastLog && $lastLog->step) {
                                $currentStepName = $lastLog->step->name;
                            }
                        }
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-4 px-6">
                            <span class="font-extrabold text-brand-blue block text-sm">{{ $order->invoice_no }}</span>
                            <span class="text-[10px] text-gray-400 font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-extrabold text-gray-900 block">{{ $order->customer->name ?? '-' }}</span>
                            <span class="text-xs text-gray-500 font-medium flex items-center gap-1">
                                <i class="fa-brands fa-whatsapp text-emerald-500 text-xs"></i> {{ $order->customer->phone ?? '-' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-extrabold text-gray-800">{{ $order->items->sum('qty') }} pcs</span>
                            <span class="text-[10px] text-gray-400 block font-normal">{{ $order->items->first()->product_name ?? 'Produk' }}</span>
                        </td>
                        <td class="py-4 px-6 font-extrabold text-brand-blue text-sm">
                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6">
                            @if($isPaid)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> LUNAS (PAID)
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-50 text-amber-600 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> BELUM LUNAS
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <i class="fa-solid fa-list-check text-[10px]"></i> {{ $currentStepName }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Direct WhatsApp Link -->
                                <a href="{{ $order->wa_link }}" target="_blank" class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-600 hover:text-white px-3 py-1.5 rounded-xl text-xs font-bold transition shadow-2xs" title="Kirim Notifikasi WhatsApp dengan Template Autofill">
                                    <i class="fa-brands fa-whatsapp text-sm"></i> Chat WA
                                </a>

                                <!-- Confirm Payment Button -->
                                @if(!$isPaid)
                                <form action="{{ route('admin.order.confirmPayment', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Konfirmasi bahwa pembayaran untuk invoice {{ $order->invoice_no }} telah diterima? Pesanan akan langsung diteruskan ke tahap Produksi.')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 bg-brand-blue text-white hover:bg-indigo-700 px-3 py-1.5 rounded-xl text-xs font-bold transition shadow-2xs">
                                        <i class="fa-solid fa-check text-[10px]"></i> Konfirmasi Lunas
                                    </button>
                                </form>
                                @endif

                                <!-- Detail Link -->
                                <a href="{{ route('admin.order.show', $order->id) }}" class="w-8 h-8 rounded-xl border border-gray-200 text-gray-500 hover:text-brand-blue hover:bg-indigo-50 transition inline-flex items-center justify-center" title="Lihat Detail">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400 font-semibold text-xs">Belum ada data pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold">
            <div class="w-full">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
