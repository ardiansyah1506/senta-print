@extends('layouts.admin')
@section('content')
@php
    $progressWidth = min($achievementPercentage, 100);
    if ($achievementPercentage < 50) {
        $progressColor = 'bg-red-500';
        $textColor = 'text-red-500';
    } elseif ($achievementPercentage < 100) {
        $progressColor = 'bg-amber-500';
        $textColor = 'text-amber-500';
    } elseif ($achievementPercentage == 100) {
        $progressColor = 'bg-emerald-500';
        $textColor = 'text-emerald-500';
    } else {
        $progressColor = 'bg-indigo-500';
        $textColor = 'text-indigo-600';
    }
@endphp
<div class="max-w-7xl mx-auto space-y-6">
    
    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Page Header & Filters -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-2">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Laporan</h1>
            <p class="text-gray-500 text-sm font-medium">Analisis pesanan dan pendapatan</p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.report.index') }}" method="GET" class="flex items-center gap-2">
                <div class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm">
                    <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="w-36 text-sm font-semibold text-gray-700 outline-none px-3 py-2 bg-transparent text-center">
                    <span class="text-gray-400">-</span>
                    <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="w-36 text-sm font-semibold text-gray-700 outline-none px-3 py-2 bg-transparent text-center">
                </div>
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm font-bold transition shadow-sm">
                    Terapkan
                </button>
            </form>
            <button onclick="document.getElementById('targetModal').classList.remove('hidden')" class="flex items-center gap-2 border border-brand-blue text-brand-blue bg-blue-50/50 hover:bg-brand-bluelight transition px-4 py-2 rounded-lg text-sm font-bold shadow-sm">
                <i class="fa-solid fa-bullseye"></i> Atur Target
            </button>
            <button class="flex items-center gap-2 border border-brand-blue text-white bg-brand-blue hover:bg-blue-700 transition px-4 py-2 rounded-lg text-sm font-bold shadow-sm">
                <i class="fa-solid fa-download"></i> Export Excel
            </button>
        </div>
    </div>

    <!-- 4 Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_12px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col justify-between">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">TOTAL REVENUE (SELESAI)</p>
                    <p class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-wave text-lg"></i>
                </div>
            </div>
            
            @if($targetAmount > 0)
                <div class="flex items-center justify-between text-xs font-bold text-gray-500 mb-2">
                    <span>Target: Rp {{ number_format($targetAmount, 0, ',', '.') }}</span>
                    <span class="{{ $textColor }} font-extrabold">{{ number_format($achievementPercentage, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                    <div class="{{ $progressColor }} h-1.5 rounded-full" style="width: {{ $progressWidth }}%"></div>
                </div>
            @else
                <div class="text-xs font-bold text-gray-400 flex items-center justify-between mt-auto">
                    <span>Belum ada target di periode ini.</span>
                    <button onclick="document.getElementById('targetModal').classList.remove('hidden')" class="text-brand-blue hover:underline">Buat Target</button>
                </div>
            @endif
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_12px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex items-start justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">PESANAN SELESAI</p>
                <p class="text-2xl font-extrabold text-gray-900">{{ $completedOrdersCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center">
                <i class="fa-solid fa-cube text-lg"></i>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_12px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex items-start justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">RATA-RATA ORDER</p>
                <p class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-pink-50 text-pink-500 flex items-center justify-center">
                <i class="fa-solid fa-chart-column text-lg"></i>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_12px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex items-start justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">TOTAL (SEMUA STATUS)</p>
                <p class="text-2xl font-extrabold text-gray-900">{{ $totalOrdersCount }} Pesanan</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center">
                <i class="fa-solid fa-clock text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Middle Section: 2 Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Laporan Periode -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-gray-900">Laporan Periode</h2>
                <p class="text-xs text-gray-500 font-medium mb-6">Ringkasan per periode ini</p>
            </div>
            <div class="w-full">
                <div class="grid grid-cols-5 text-[10px] font-bold text-gray-400 border-b border-gray-100 pb-3 mb-4 uppercase tracking-wider">
                    <div class="col-span-1">Periode</div>
                    <div class="text-center">Jml Pesanan</div>
                    <div class="text-center">Target</div>
                    <div class="text-center">Pendapatan</div>
                    <div class="text-right">Pencapaian</div>
                </div>
                <div class="grid grid-cols-5 items-center text-sm">
                    <div class="col-span-1 text-gray-500 font-semibold text-xs pr-2">{{ $startDate->format('d M y') }} - <br> {{ $endDate->format('d M y') }}</div>
                    <div class="text-center text-gray-700 font-semibold">{{ $totalOrdersCount }} pesanan</div>
                    <div class="text-center text-gray-400 font-semibold">Rp {{ number_format($targetAmount, 0, ',', '.') }}</div>
                    <div class="text-center text-gray-900 font-extrabold whitespace-nowrap">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    @if($targetAmount > 0)
                        <div class="text-right {{ $textColor }} font-extrabold">{{ number_format($achievementPercentage, 1) }}%</div>
                    @else
                        <div class="text-right text-gray-400 font-bold">-</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Produk Terpopuler -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-full flex flex-col">
            <div>
                <h2 class="text-lg font-extrabold text-gray-900">Produk Terpopuler</h2>
                <p class="text-xs text-gray-500 font-medium mb-6">Distribusi pesanan per produk</p>
            </div>
            
            <div class="space-y-4 flex-1 overflow-y-auto">
                @forelse($topProducts as $name => $count)
                    @php 
                        $maxCount = (!empty($topProducts) && max($topProducts) > 0) ? max($topProducts) : 1; 
                        $percentage = ($count / $maxCount) * 100;
                    @endphp
                    <div class="flex items-center gap-4">
                        <div class="w-32 text-xs font-semibold text-gray-600 truncate" title="{{ $name }}">{{ $name }}</div>
                        <div class="flex-1 bg-gray-100 rounded-full h-2">
                            <div class="bg-brand-blue h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="text-xs font-extrabold text-gray-900 w-4 text-right">{{ $count }}</div>
                    </div>
                @empty
                    <div class="text-xs text-gray-400 italic">Belum ada data penjualan produk.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bottom Section: Daftar Pesanan -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-sm">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
            <div>
                <h2 class="text-lg font-extrabold text-gray-900 mb-1">Pesanan Periode Ini</h2>
                <p class="text-xs text-gray-500 font-medium">Daftar lengkap pesanan: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
            </div>
            <a href="{{ route('admin.order.index') }}" class="text-brand-blue font-bold text-sm hover:text-indigo-800 transition flex items-center gap-1">
                Kelola Pesanan <i class="fa-solid fa-arrow-right text-[10px] mt-0.5"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">ID Pesanan</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Produk & Jumlah</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Pendapatan Bersih</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-semibold text-gray-700 bg-white">
                    @forelse($allOrders as $order)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-3.5 px-6 font-extrabold text-brand-blue">{{ $order->invoice_no }}</td>
                        <td class="py-3.5 px-6">{{ $order->customer->name ?? 'Unknown' }}</td>
                        <td class="py-3.5 px-6">
                            @foreach($order->items as $item)
                                <div class="text-xs truncate max-w-[150px]" title="{{ $item->product->name ?? 'Unknown' }}">{{ $item->product->name ?? 'Unknown' }} ({{ $item->quantity }})</div>
                            @endforeach
                        </td>
                        <td class="py-3.5 px-6 font-bold text-gray-900">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                        <td class="py-3.5 px-6">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'production' => 'bg-indigo-50 text-brand-blue border-indigo-100',
                                    'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'rejected' => 'bg-red-50 text-red-600 border-red-100',
                                ];
                                $dotColors = [
                                    'pending' => 'bg-amber-500',
                                    'production' => 'bg-brand-blue',
                                    'completed' => 'bg-emerald-500',
                                    'rejected' => 'bg-red-500',
                                ];
                                $color = $statusColors[$order->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                $dot = $dotColors[$order->status] ?? 'bg-gray-500';
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $color }} text-xs font-bold border">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span> {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-6 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 px-6 text-center text-gray-400">Tidak ada pesanan di periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Target Modal -->
<div id="targetModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-extrabold text-gray-900">Atur Target Pendapatan</h3>
            <button onclick="document.getElementById('targetModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.report.target') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4 text-sm">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jenis Target</label>
                    <select name="type" id="targetType" onchange="toggleCustomDates()" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-gray-900 font-semibold focus:outline-none focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition">
                        <option value="custom">Spesifik Rentang Tanggal</option>
                        <option value="daily">Default Harian</option>
                        <option value="weekly">Default Mingguan</option>
                        <option value="monthly">Default Bulanan</option>
                        <option value="yearly">Default Tahunan</option>
                    </select>
                </div>
                <div id="customDateFields" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate->format('Y-m-d') }}" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-gray-900 font-semibold focus:outline-none focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate->format('Y-m-d') }}" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-gray-900 font-semibold focus:outline-none focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jumlah Target (Rp)</label>
                    <input type="number" name="target_amount" value="{{ $targetAmount > 0 ? (int)$targetAmount : '' }}" placeholder="Contoh: 50000000" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-gray-900 font-semibold focus:outline-none focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition" required>
                </div>
                <p class="text-xs text-gray-400 mt-2">
                    <i class="fa-solid fa-circle-info text-brand-blue mr-1"></i> Target default otomatis diakumulasi berdasarkan jumlah hari yang Anda pilih di laporan.
                </p>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('targetModal').classList.add('hidden')" class="px-4 py-2 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-brand-blue rounded-lg hover:bg-blue-700 transition shadow-sm">Simpan Target</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleCustomDates() {
    const type = document.getElementById('targetType').value;
    const customFields = document.getElementById('customDateFields');
    if(type === 'custom') {
        customFields.style.display = 'block';
        document.getElementById('start_date').required = true;
        document.getElementById('end_date').required = true;
    } else {
        customFields.style.display = 'none';
        document.getElementById('start_date').required = false;
        document.getElementById('end_date').required = false;
    }
}
// Run once on load to set initial state
toggleCustomDates();
</script>
@endsection
