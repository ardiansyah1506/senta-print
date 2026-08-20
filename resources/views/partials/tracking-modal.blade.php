<!-- Order Success Modal (Triggered when session('order_success') is set) -->
@if(session('order_success'))
@php
    $waName = session('order_success.nama_pemesan');
    $waInv = session('order_success.invoice_no');
    $waPhone = session('order_success.no_whatsapp');
    $waTotal = 'Rp ' . number_format(session('order_success.total_price'), 0, ',', '.');
    $waText = "Halo Kak {$waName}, Terima kasih telah memesan di Senta Print!\nNomor Invoice Anda: *{$waInv}*\n\n🔑 *Informasi Akun Member Anda:*\nAnda dapat login ke website kami menggunakan:\n• Username (No. WA): *{$waPhone}*\n• Password Default: *password*\n\nTotal Biaya: *{$waTotal}*\nSilakan melakukan pembayaran/DP agar pesanan Anda dapat segera kami proses ke tahap produksi. Anda dapat melacak pesanan kapan saja di website kami dengan Nomor Invoice & WA ini. Terima kasih!";
    $waUrl = "https://wa.me/6281380069798?text=" . urlencode($waText);
@endphp
<div id="orderSuccessModal" class="fixed inset-0 z-[100] bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8 text-center relative transform transition-all scale-100 border border-gray-100">
        <button type="button" onclick="document.getElementById('orderSuccessModal').remove()" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
            <i data-lucide="check-circle-2" class="w-8 h-8"></i>
        </div>

        <h3 class="text-2xl font-extrabold text-gray-900 mb-1">Pesanan Berhasil Dibuat!</h3>
        <p class="text-xs text-gray-500 font-medium mb-6">Terima kasih <span class="font-extrabold text-gray-800">{{ session('order_success.nama_pemesan') }}</span>, pesanan Anda telah masuk ke sistem kami.</p>

        <!-- Invoice Box with 1-click Copy -->
        <div class="bg-indigo-50/70 border border-indigo-100 rounded-2xl p-4 mb-6 text-center">
            <span class="block text-[10px] font-extrabold text-brand-blue uppercase tracking-wider mb-1">Nomor Invoice Pesanan Anda</span>
            <div class="flex items-center justify-center gap-2">
                <span id="createdInvoiceNo" class="font-extrabold text-xl text-gray-900 tracking-wide">{{ session('order_success.invoice_no') }}</span>
                <button type="button" onclick="copyCreatedInvoice()" class="bg-white border border-indigo-200 text-brand-blue hover:bg-brand-blue hover:text-white px-3 py-1.5 rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                    <i data-lucide="copy" class="w-3.5 h-3.5"></i> Salin
                </button>
            </div>
        </div>

        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 text-left space-y-2 mb-6 text-xs">
            <div class="flex justify-between items-center text-gray-600">
                <span>No. WhatsApp:</span>
                <span class="font-extrabold text-gray-800">{{ session('order_success.no_whatsapp') }}</span>
            </div>
            <div class="flex justify-between items-center text-gray-600">
                <span>Username Akun:</span>
                <span class="font-extrabold text-gray-800">{{ session('order_success.no_whatsapp') }}</span>
            </div>
            <div class="flex justify-between items-center text-gray-600">
                <span>Password Default:</span>
                <span class="font-extrabold text-brand-blue">password</span>
            </div>
            <div class="flex justify-between items-center text-gray-600">
                <span>Total Items:</span>
                <span class="font-extrabold text-gray-800">{{ session('order_success.total_qty') }} pcs</span>
            </div>
            <div class="flex justify-between items-center text-gray-600 border-t border-gray-200/60 pt-2">
                <span>Estimasi Biaya:</span>
                <span class="font-extrabold text-brand-blue text-sm">Rp {{ number_format(session('order_success.total_price'), 0, ',', '.') }}</span>
            </div>
        </div>

        <a href="{{ $waUrl }}" target="_blank" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl py-3 text-xs transition shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2 mb-4">
            <i data-lucide="message-circle" class="w-4 h-4"></i> Konfirmasi Pesanan Via WhatsApp
        </a>

        <p class="text-[11px] text-gray-400 font-medium mb-6 leading-relaxed">
            💡 Akun Anda telah dibuat secara otomatis di sistem kami dengan Username (Nomor WhatsApp) dan Password: <b>password</b>. Simpan nomor invoice ini untuk melacak status pengerjaan pesanan Anda kapan saja.
        </p>

        <div class="flex flex-col sm:flex-row gap-3">
            <button type="button" onclick="openPublicTrackingModal('{{ session('order_success.invoice_no') }}')" class="w-full sm:w-1/2 bg-brand-blue text-white rounded-xl py-3 font-bold text-xs hover:bg-indigo-700 transition shadow-md shadow-brand-blue/20 flex items-center justify-center gap-1">
                Lacak Pesanan Ini <i data-lucide="crosshair" class="w-3.5 h-3.5"></i>
            </button>
            <button type="button" onclick="document.getElementById('orderSuccessModal').remove()" class="w-full sm:w-1/2 bg-gray-100 text-gray-700 rounded-xl py-3 font-bold text-xs hover:bg-gray-200 transition">
                Tutup Window
            </button>
        </div>
    </div>
</div>
<script>
    function copyCreatedInvoice() {
        const inv = document.getElementById('createdInvoiceNo').innerText;
        navigator.clipboard.writeText(inv);
        if(typeof toastr !== 'undefined') toastr.success('Nomor Invoice berhasil disalin!');
        else alert('Nomor Invoice berhasil disalin: ' + inv);
    }
</script>
@endif

<!-- Public Order Tracking Modal -->
<div id="publicTrackingModal" class="fixed inset-0 z-[100] hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full p-8 relative transform transition-all scale-95 max-h-[90vh] overflow-y-auto" id="publicTrackingContent">
        <button type="button" onclick="closePublicTrackingModal()" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
            <div class="w-10 h-10 bg-indigo-50 text-brand-blue rounded-xl flex items-center justify-center text-lg">
                <i data-lucide="crosshair" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-xl font-extrabold text-gray-900">Lacak Status Pesanan</h3>
                <p class="text-xs text-gray-500 font-medium">Masukkan Nomor Invoice dan Nomor WhatsApp Anda</p>
            </div>
        </div>

        <!-- Step 1: Input Invoice -->
        <form id="trackStepInvoice" class="space-y-4" onsubmit="event.preventDefault(); submitTrackInvoice();">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Nomor Invoice Pesanan</label>
                <div class="relative">
                    <input type="text" id="trackInvoiceInput" placeholder="Contoh: INV-PUB-20260726-1234" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-extrabold uppercase text-gray-800 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition">
                    <i data-lucide="receipt" class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2"></i>
                </div>
            </div>
            <button type="submit" class="w-full bg-brand-blue text-white rounded-xl py-3 font-bold text-xs hover:bg-indigo-700 transition shadow-md shadow-brand-blue/20 flex items-center justify-center gap-2">
                Cari Pesanan <i data-lucide="search" class="w-4 h-4"></i>
            </button>
        </form>

        <!-- Step 2: Verification Phone (Hidden initially) -->
        <form id="trackStepVerifyPhone" class="hidden space-y-4 pt-2" onsubmit="event.preventDefault(); submitVerifyPhone();">
            <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs font-semibold flex items-center gap-2">
                <i data-lucide="shield" class="w-4 h-4 text-amber-600"></i>
                <span>Invoice ditemukan! Masukkan Nomor WhatsApp untuk verifikasi kepemilikan.</span>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Nomor WhatsApp Pemesan</label>
                <div class="relative">
                    <input type="text" id="trackPhoneInput" placeholder="081234567890" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-extrabold text-gray-800 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition">
                    <i data-lucide="message-square" class="w-4 h-4 text-emerald-500 absolute right-4 top-1/2 -translate-y-1/2"></i>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="backToTrackStep1()" class="w-1/3 border border-gray-200 text-gray-600 rounded-xl py-3 text-xs font-bold hover:bg-gray-50 transition">
                    Kembali
                </button>
                <button type="submit" class="w-2/3 bg-brand-blue text-white rounded-xl py-3 font-bold text-xs hover:bg-indigo-700 transition shadow-md shadow-brand-blue/20 flex items-center justify-center gap-1">
                    Verifikasi & Lacak <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </button>
            </div>
        </form>

        <!-- Step 3: Tracking Results Details (Hidden initially) -->
        <div id="trackStepResults" class="hidden space-y-6 pt-2">
            <!-- Header Status Info -->
            <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-5 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-200/60 pb-3">
                    <div>
                        <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Pemesan</span>
                        <h4 id="resCustomerName" class="font-extrabold text-base text-gray-900"></h4>
                        <p id="resInvoiceNo" class="text-xs font-extrabold text-brand-blue mt-0.5"></p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span id="resPaymentBadge" class="px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-700">PENDING</span>
                    </div>
                </div>

                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-500 font-medium">Tahap Produksi Aktif:</span>
                    <span id="resProductionStep" class="font-extrabold text-indigo-700 bg-indigo-50 border border-indigo-100 px-3 py-1 rounded-lg"></span>
                </div>
            </div>

            <!-- Production Log & Photos Progress -->
            <div id="resProductionSection" class="hidden">
                <h4 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                    <i data-lucide="camera" class="w-3.5 h-3.5 text-brand-blue"></i> Progress Foto Pengerjaan Produksi:
                </h4>
                <div id="resProductionLogs" class="space-y-3 mb-6"></div>
            </div>

            <!-- Items List Breakdown -->
            <div>
                <h4 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-3">Rincian List Pesanan:</h4>
                <div id="resItemsList" class="space-y-3"></div>
            </div>

            <!-- Pricing Total -->
            <div class="bg-indigo-50/60 border border-indigo-100 rounded-2xl p-4 flex justify-between items-center">
                <span class="text-xs font-extrabold text-gray-700 uppercase">Estimasi Biaya Pesanan</span>
                <span id="resGrandTotal" class="text-lg font-extrabold text-brand-blue">Rp 0</span>
            </div>

            <button type="button" onclick="backToTrackStep1()" class="w-full border border-gray-200 text-gray-700 rounded-xl py-3 font-bold text-xs hover:bg-gray-50 transition">
                Cari Invoice Lain
            </button>
        </div>
    </div>
</div>

<script>
    let activeTrackInvoice = '';

    function openDirectCustomerTrackingModal(invoiceNo) {
        const modal = document.getElementById('publicTrackingModal');
        const content = document.getElementById('publicTrackingContent');
        
        activeTrackInvoice = invoiceNo;

        document.getElementById('trackStepInvoice').classList.add('hidden');
        document.getElementById('trackStepVerifyPhone').classList.add('hidden');
        document.getElementById('trackStepResults').classList.remove('hidden');

        document.getElementById('resCustomerName').innerText = 'Memuat...';
        document.getElementById('resInvoiceNo').innerText = invoiceNo;
        document.getElementById('resProductionStep').innerText = 'Memuat...';
        document.getElementById('resGrandTotal').innerText = '...';
        document.getElementById('resItemsList').innerHTML = '<div class="text-center py-8 text-gray-400 font-bold"><i class="fa-solid fa-spinner fa-spin text-2xl text-brand-blue"></i><p class="mt-2 text-xs">Memuat detail pesanan...</p></div>';
        document.getElementById('resProductionSection').classList.add('hidden');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.style.opacity = '1';
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);

        fetch('{{ route("public.order.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                invoice_no: invoiceNo,
                no_whatsapp: ''
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const ord = data.order;
                document.getElementById('resCustomerName').innerText = ord.customer_name;
                document.getElementById('resInvoiceNo').innerText = ord.invoice_no;
                document.getElementById('resProductionStep').innerText = ord.current_production_step;
                document.getElementById('resGrandTotal').innerText = 'Rp ' + ord.grand_total.toLocaleString('id-ID');
                
                const payBadge = document.getElementById('resPaymentBadge');
                payBadge.innerText = ord.payment_status;
                if (ord.payment_status === 'PAID' || ord.payment_status === 'LUNAS') {
                    payBadge.className = 'px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-700';
                } else {
                    payBadge.className = 'px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-700';
                }

                let itemsHtml = '';
                ord.items.forEach(it => {
                    let addonsHtml = '';
                    if (it.addons && it.addons.length > 0) {
                        addonsHtml = it.addons.map(a => {
                            let priceFormatted = a.price < 0 
                                ? `<span class="text-red-600 font-bold">- Rp ${Math.abs(a.price).toLocaleString('id-ID')}</span>`
                                : `<span class="text-brand-blue font-bold">+ Rp ${a.price.toLocaleString('id-ID')}</span>`;
                            return `
                                <div class="flex justify-between items-center text-[11px] font-bold text-gray-700 bg-indigo-50/40 px-2.5 py-1 rounded-lg border border-indigo-100/60">
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-puzzle-piece text-brand-blue text-[10px]"></i> ${a.name}</span>
                                    ${priceFormatted}
                                </div>
                            `;
                        }).join('');
                    } else {
                        addonsHtml = `
                            <div class="flex items-center gap-1.5 text-[11px] font-medium text-gray-500 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-200/60">
                                <i class="fa-solid fa-minus text-gray-400 text-[10px]"></i>
                                <span>Standar (Tanpa Add-on)</span>
                            </div>
                        `;
                    }

                    itemsHtml += `
                        <div class="p-4 border border-gray-200/80 rounded-2xl bg-white space-y-3 shadow-2xs">
                            <div class="flex justify-between items-start border-b border-gray-100 pb-2">
                                <div>
                                    <h4 class="font-extrabold text-sm text-gray-900">${it.product_name} (${it.size_name ? 'Ukuran ' + it.size_name : 'All Size'})</h4>
                                    <span class="inline-block bg-indigo-50 text-brand-blue text-[10px] font-extrabold px-2.5 py-0.5 rounded-full mt-0.5">${it.qty} pcs</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Harga Dasar Baju</span>
                                    <span class="font-extrabold text-xs text-gray-800">Rp ${it.base_price.toLocaleString('id-ID')} /pcs</span>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider block">Rincian Layanan & Add-on:</span>
                                ${addonsHtml}
                            </div>

                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 text-xs space-y-1">
                                <div class="flex justify-between items-center text-gray-600">
                                    <span>Subtotal Baju (${it.qty} pcs x Rp ${it.base_price.toLocaleString('id-ID')}):</span>
                                    <span class="font-bold text-gray-800">Rp ${it.subtotal_baju.toLocaleString('id-ID')}</span>
                                </div>
                                ${it.total_addon !== 0 ? `
                                <div class="flex justify-between items-center text-gray-600">
                                    <span>Total Layanan Add-on:</span>
                                    <span class="font-bold ${it.total_addon < 0 ? 'text-red-600' : 'text-brand-blue'}">
                                        ${it.total_addon < 0 ? '-' : '+'} Rp ${Math.abs(it.total_addon).toLocaleString('id-ID')}
                                    </span>
                                </div>` : ''}
                                <div class="flex justify-between items-center border-t border-gray-200/80 pt-1.5 font-extrabold text-gray-900">
                                    <span>Total Item Ini:</span>
                                    <span class="text-brand-blue text-sm">Rp ${it.total_price.toLocaleString('id-ID')}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });
                document.getElementById('resItemsList').innerHTML = itemsHtml;

                if (ord.sequential_steps && ord.sequential_steps.length > 0) {
                    let stepsHtml = '';
                    ord.sequential_steps.forEach((st, idx) => {
                        let isDone = (st.status === 'completed');
                        let isActive = (st.status === 'active');

                        let iconHtml = isDone 
                            ? `<i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>` 
                            : (isActive ? `<span class="w-2.5 h-2.5 rounded-full bg-brand-blue animate-pulse"></span>` : `<i class="fa-regular fa-circle text-gray-300 text-xs"></i>`);

                        let bgStyle = isDone 
                            ? 'bg-emerald-50/60 border-emerald-200/80 text-emerald-900' 
                            : (isActive ? 'bg-indigo-50 border-brand-blue text-brand-blue shadow-2xs' : 'bg-white border-gray-200/60 text-gray-400 opacity-60');

                        let photosHtml = '';
                        if (isDone && st.photos && st.photos.length > 0) {
                            photosHtml = `
                                <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 pt-2">
                                    ${st.photos.map(p => `
                                        <a href="${p}" target="_blank" class="w-full h-16 rounded-xl overflow-hidden border border-gray-200 block shadow-2xs hover:opacity-90 transition">
                                            <img src="${p}" class="w-full h-full object-cover">
                                        </a>
                                    `).join('')}
                                </div>
                            `;
                        }

                        stepsHtml += `
                            <div class="p-3.5 border rounded-2xl ${bgStyle} space-y-1">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-extrabold flex items-center gap-2">
                                        ${iconHtml}
                                        <span>Tahap ${idx + 1}: ${st.name}</span>
                                    </span>
                                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full ${isDone ? 'bg-emerald-100 text-emerald-700' : (isActive ? 'bg-brand-blue text-white' : 'bg-gray-100 text-gray-400')}">
                                        ${isDone ? 'Selesai' : (isActive ? 'Proses Sekarang' : 'Pending')}
                                    </span>
                                </div>
                                ${st.notes ? `<p class="text-xs font-medium text-gray-700 bg-white p-2.5 rounded-xl border border-gray-100 mt-1">${st.notes}</p>` : ''}
                                ${photosHtml}
                            </div>
                        `;
                    });

                    document.getElementById('resProductionLogs').innerHTML = stepsHtml;
                    document.getElementById('resProductionSection').classList.remove('hidden');
                } else {
                    document.getElementById('resProductionSection').classList.add('hidden');
                }
            } else {
                if(typeof toastr !== 'undefined') toastr.error(data.message);
                else alert(data.message);
                closePublicTrackingModal();
            }
        })
        .catch(err => {
            if(typeof toastr !== 'undefined') toastr.error('Terjadi kesalahan sistem.');
            else alert('Terjadi kesalahan sistem.');
            closePublicTrackingModal();
        });
    }

    function openPublicTrackingModal(prefillInvoice = '') {
        const modal = document.getElementById('publicTrackingModal');
        const content = document.getElementById('publicTrackingContent');
        
        if (prefillInvoice) {
            document.getElementById('trackInvoiceInput').value = prefillInvoice;
        }

        backToTrackStep1();
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.style.opacity = '1';
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closePublicTrackingModal() {
        const modal = document.getElementById('publicTrackingModal');
        const content = document.getElementById('publicTrackingContent');
        modal.style.opacity = '0';
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function backToTrackStep1() {
        document.getElementById('trackStepInvoice').classList.remove('hidden');
        document.getElementById('trackStepVerifyPhone').classList.add('hidden');
        document.getElementById('trackStepResults').classList.add('hidden');
    }

    function startPublicTrackFromPage() {
        const pageInput = document.getElementById('pageInvoiceInput');
        const invInput = pageInput ? pageInput.value.trim() : '';
        if (!invInput) {
            if(typeof toastr !== 'undefined') toastr.warning('Masukkan Nomor Invoice terlebih dahulu.');
            else alert('Masukkan Nomor Invoice terlebih dahulu.');
            return;
        }

        const btn = document.querySelector('#pageTrackForm button[type="submit"]') || document.querySelector('button[onclick*="startPublicTrackFromPage"]');
        if (btn && window.setButtonLoading) window.setButtonLoading(btn, 'Memproses...');

        fetch('{{ route("public.order.search") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ invoice_no: invInput })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                activeTrackInvoice = data.invoice_no;
                document.getElementById('trackInvoiceInput').value = data.invoice_no;
                
                document.getElementById('trackStepInvoice').classList.add('hidden');
                document.getElementById('trackStepVerifyPhone').classList.remove('hidden');
                document.getElementById('trackStepResults').classList.add('hidden');

                const modal = document.getElementById('publicTrackingModal');
                const content = document.getElementById('publicTrackingContent');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.style.opacity = '1';
                    content.classList.remove('scale-95');
                    content.classList.add('scale-100');
                }, 10);
            } else {
                if(typeof toastr !== 'undefined') toastr.error(data.message);
                else alert(data.message);
            }
        })
        .catch(err => {
            if(typeof toastr !== 'undefined') toastr.error('Terjadi kesalahan sistem.');
            else alert('Terjadi kesalahan sistem.');
        })
        .finally(() => {
            if (btn && window.resetButtonLoading) window.resetButtonLoading(btn);
        });
    }

    function submitTrackInvoice() {
        const invInput = document.getElementById('trackInvoiceInput').value.trim();
        if (!invInput) {
            if(typeof toastr !== 'undefined') toastr.warning('Masukkan Nomor Invoice terlebih dahulu.');
            else alert('Masukkan Nomor Invoice terlebih dahulu.');
            return;
        }

        const btn = document.querySelector('#trackStepInvoice button[type="submit"]');
        if (btn && window.setButtonLoading) window.setButtonLoading(btn, 'Memproses...');

        fetch('{{ route("public.order.search") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ invoice_no: invInput })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                activeTrackInvoice = data.invoice_no;
                document.getElementById('trackStepInvoice').classList.add('hidden');
                document.getElementById('trackStepVerifyPhone').classList.remove('hidden');
            } else {
                if(typeof toastr !== 'undefined') toastr.error(data.message);
                else alert(data.message);
            }
        })
        .catch(err => {
            if(typeof toastr !== 'undefined') toastr.error('Terjadi kesalahan sistem.');
            else alert('Terjadi kesalahan sistem.');
        })
        .finally(() => {
            if (btn && window.resetButtonLoading) window.resetButtonLoading(btn);
        });
    }

    function submitVerifyPhone() {
        const phoneInput = document.getElementById('trackPhoneInput').value.trim();
        if (!phoneInput) {
            if(typeof toastr !== 'undefined') toastr.warning('Masukkan Nomor WhatsApp pemesan terlebih dahulu.');
            else alert('Masukkan Nomor WhatsApp pemesan terlebih dahulu.');
            return;
        }

        const btn = document.querySelector('#trackStepVerifyPhone button[type="submit"]');
        if (btn && window.setButtonLoading) window.setButtonLoading(btn, 'Verifikasi...');

        fetch('{{ route("public.order.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                invoice_no: activeTrackInvoice,
                no_whatsapp: phoneInput
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const ord = data.order;
                document.getElementById('resCustomerName').innerText = ord.customer_name;
                document.getElementById('resInvoiceNo').innerText = ord.invoice_no;
                document.getElementById('resProductionStep').innerText = ord.current_production_step;
                document.getElementById('resGrandTotal').innerText = 'Rp ' + ord.grand_total.toLocaleString('id-ID');
                
                const payBadge = document.getElementById('resPaymentBadge');
                payBadge.innerText = ord.payment_status;
                if (ord.payment_status === 'PAID' || ord.payment_status === 'LUNAS') {
                    payBadge.className = 'px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-700';
                } else {
                    payBadge.className = 'px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-700';
                }

                let itemsHtml = '';
                ord.items.forEach(it => {
                    itemsHtml += `
                        <div class="p-5 border border-gray-200/80 rounded-2xl bg-white space-y-4 shadow-2xs">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 border-b border-gray-100 pb-3">
                                <div>
                                    <h4 class="font-extrabold text-lg text-gray-900">${it.product_name} (${it.size_name ? 'Ukuran ' + it.size_name : 'All Size'})</h4>
                                    <span class="inline-block bg-indigo-50 text-brand-blue text-xs font-extrabold px-3 py-1 rounded-full mt-1.5">${it.qty} pcs</span>
                                </div>
                                <div class="text-left sm:text-right">
                                    <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-0.5">Harga Satuan</span>
                                    <span class="font-extrabold text-lg text-gray-800">Rp ${it.base_price.toLocaleString('id-ID')}</span>
                                </div>
                            </div>

                            <!-- Breakdown Calculations (No Addons as per request) -->
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-base space-y-2">
                                <div class="flex justify-between items-center text-gray-600">
                                    <span>Subtotal (${it.qty} pcs x Rp ${it.base_price.toLocaleString('id-ID')}):</span>
                                    <span class="font-bold text-gray-800">Rp ${it.subtotal_baju.toLocaleString('id-ID')}</span>
                                </div>
                                <div class="flex justify-between items-center border-t border-gray-200/80 pt-2.5 font-extrabold text-gray-900 mt-2">
                                    <span>Total Item Ini:</span>
                                    <span class="text-brand-blue text-lg">Rp ${(it.base_price * it.qty).toLocaleString('id-ID')}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });
                document.getElementById('resItemsList').innerHTML = itemsHtml;

                if (ord.sequential_steps && ord.sequential_steps.length > 0) {
                    let stepsHtml = '';
                    ord.sequential_steps.forEach((st, idx) => {
                        let isDone = (st.status === 'completed');
                        let isActive = (st.status === 'active');

                        let iconHtml = isDone 
                            ? `<i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>` 
                            : (isActive ? `<span class="w-2.5 h-2.5 rounded-full bg-brand-blue animate-pulse"></span>` : `<i class="fa-regular fa-circle text-gray-300 text-xs"></i>`);

                        let bgStyle = isDone 
                            ? 'bg-emerald-50/60 border-emerald-200/80 text-emerald-900' 
                            : (isActive ? 'bg-indigo-50 border-brand-blue text-brand-blue shadow-2xs' : 'bg-white border-gray-200/60 text-gray-400 opacity-60');

                        let logsHtml = '';
                        if (st.logs && st.logs.length > 0) {
                            let detailedLogs = '';
                            st.logs.forEach(log => {
                                let localPhotosHtml = '';
                                if (log.photos && log.photos.length > 0) {
                                    localPhotosHtml = `
                                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 pt-2">
                                            ${log.photos.map(p => `
                                                <a href="${p}" target="_blank" class="w-full h-16 rounded-xl overflow-hidden border border-gray-200 block shadow-2xs hover:opacity-90 transition">
                                                    <img src="${p}" class="w-full h-full object-cover">
                                                </a>
                                            `).join('')}
                                        </div>
                                    `;
                                }
                                detailedLogs += `
                                    <div class="mt-2 text-left pt-2 border-t border-black/5">
                                        <div class="flex justify-between items-center text-[10px] font-bold text-gray-400 mb-1 px-1">
                                            <span class="uppercase tracking-wider">${log.status === 'completed' ? 'Selesai' : 'Update Pengerjaan'}</span>
                                            <span>${log.created_at}</span>
                                        </div>
                                        ${log.notes ? `<p class="text-xs font-medium text-gray-700 bg-white p-2.5 rounded-xl border border-gray-100">${log.notes}</p>` : ''}
                                        ${localPhotosHtml}
                                    </div>
                                `;
                            });
                            
                            logsHtml = `
                                <details class="group mt-2 outline-none">
                                    <summary class="flex items-center justify-between cursor-pointer list-none text-[11px] bg-white/60 border border-white px-3 py-1.5 rounded-lg shadow-sm font-bold text-gray-500 hover:text-brand-blue select-none">
                                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Progress (${st.logs.length})</span>
                                        <i class="fa-solid fa-chevron-down shrink-0 transition-transform group-open:rotate-180 text-[10px]"></i>
                                    </summary>
                                    <div class="pt-1 opacity-0 group-open:opacity-100 transition-opacity duration-300">
                                        ${detailedLogs}
                                    </div>
                                </details>
                            `;
                        }

                        stepsHtml += `
                            <div class="p-3.5 border rounded-2xl ${bgStyle}">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-extrabold flex items-center gap-2">
                                        ${iconHtml}
                                        <span>Tahap ${idx + 1}: ${st.name}</span>
                                    </span>
                                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full ${isDone ? 'bg-emerald-100 text-emerald-700' : (isActive ? 'bg-brand-blue text-white' : 'bg-gray-100 text-gray-400')}">
                                        ${isDone ? 'Selesai' : (isActive ? 'Proses Sekarang' : 'Pending')}
                                    </span>
                                </div>
                                ${logsHtml}
                            </div>
                        `;
                    });

                    document.getElementById('resProductionLogs').innerHTML = stepsHtml;
                    document.getElementById('resProductionSection').classList.remove('hidden');
                } else {
                    document.getElementById('resProductionSection').classList.add('hidden');
                }

                document.getElementById('trackStepVerifyPhone').classList.add('hidden');
                document.getElementById('trackStepResults').classList.remove('hidden');
            } else {
                if(typeof toastr !== 'undefined') toastr.error(data.message);
                else alert(data.message);
            }
        })
        .catch(err => {
            if(typeof toastr !== 'undefined') toastr.error('Terjadi kesalahan verifikasi.');
            else alert('Terjadi kesalahan verifikasi.');
        })
        .finally(() => {
            if (btn && window.resetButtonLoading) window.resetButtonLoading(btn);
        });
    }
</script>
