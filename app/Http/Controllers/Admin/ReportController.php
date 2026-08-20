<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private function resolveDateRange(Request $request) {
        $filterType = $request->input('filter_type', 'all');
        $month = (int) $request->input('month', date('n'));
        $year = (int) $request->input('year', date('Y'));
        $startDateStr = $request->input('start_date');
        $endDateStr = $request->input('end_date');

        if ($filterType === 'all') {
            $startDate = Carbon::create(2024, 1, 1)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } elseif ($filterType === 'range' && $startDateStr && $endDateStr) {
            $startDate = Carbon::parse($startDateStr)->startOfDay();
            $endDate = Carbon::parse($endDateStr)->endOfDay();
        } elseif ($filterType === 'month') {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();
        } elseif ($startDateStr && $endDateStr) {
            $startDate = Carbon::parse($startDateStr)->startOfDay();
            $endDate = Carbon::parse($endDateStr)->endOfDay();
            $filterType = 'range';
        } else {
            $startDate = Carbon::create(2024, 1, 1)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
            $filterType = 'all';
        }

        return [$startDate, $endDate, $filterType, $month, $year, $startDateStr, $endDateStr];
    }

    public function index(Request $request) {
        [$startDate, $endDate, $filterType, $month, $year, $startDateStr, $endDateStr] = $this->resolveDateRange($request);
        
        $search = $request->input('search');
        $statusFilter = $request->input('status', 'all');

        // Fetch Orders within range
        $ordersQuery = Order::with(['customer', 'items.product'])
            ->whereBetween('created_at', [$startDate, $endDate]);

        if (!empty($search)) {
            $ordersQuery->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        if ($statusFilter !== 'all') {
            $ordersQuery->where('status', $statusFilter);
        }

        $allOrders = $ordersQuery->get();
        $paginatedOrders = $ordersQuery->latest()->paginate(5)->withQueryString();
        
        $totalOrdersCount = $allOrders->count();
        
        // Exclude rejected/cancelled for revenue? Let's say we only count non-rejected for revenue.
        $validOrders = $allOrders->where('status', '!=', 'rejected');
        
        $totalRevenue = $validOrders->sum('grand_total');
        $completedOrdersCount = $allOrders->where('status', 'completed')->count();
        $averageOrderValue = $validOrders->count() > 0 ? $totalRevenue / $validOrders->count() : 0;

        // Calculate Products popularity
        $productPopularity = [];
        foreach ($allOrders as $order) {
            foreach ($order->items as $item) {
                $name = $item->product_name ?? ($item->product->name ?? 'Produk');
                $qty = $item->qty ?? ($item->quantity ?? 1);
                if (!isset($productPopularity[$name])) {
                    $productPopularity[$name] = 0;
                }
                $productPopularity[$name] += $qty;
            }
        }
        arsort($productPopularity);
        $topProducts = array_slice($productPopularity, 0, 6, true);

        // Target calculation
        $target = Target::where('start_date', $startDate->format('Y-m-d'))
            ->where('end_date', $endDate->format('Y-m-d'))
            ->first();

        $targetAmount = $target ? $target->target_amount : 0;

        $achievementPercentage = $targetAmount > 0 ? ($totalRevenue / $targetAmount) * 100 : 0;

        return view('admin.laporan', compact(
            'startDate',
            'endDate',
            'filterType',
            'month',
            'year',
            'startDateStr',
            'endDateStr',
            'search',
            'statusFilter',
            'allOrders',
            'paginatedOrders',
            'totalOrdersCount',
            'totalRevenue',
            'completedOrdersCount',
            'averageOrderValue',
            'topProducts',
            'targetAmount',
            'achievementPercentage',
            'target'
        ));
    }

    public function setTarget(Request $request) {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'target_amount' => 'required|numeric|min:0'
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $targetAmount = $request->input('target_amount');

        $target = Target::where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->first();

        if ($target) {
            $target->update(['target_amount' => $targetAmount]);
        } else {
            Target::create([
                'type' => 'custom',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'target_amount' => $targetAmount
            ]);
        }

        return redirect()->back()->with('success', 'Target berhasil disimpan.');
    }

    public function exportExcel(Request $request) {
        [$startDate, $endDate] = $this->resolveDateRange($request);

        $orders = Order::with(['customer', 'items.product'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $validOrders = $orders->where('status', '!=', 'rejected');
        $sumSubtotal = $orders->sum('subtotal');
        $sumGrandTotal = $validOrders->sum('grand_total');
        $countOrders = $orders->count();
        $countCompleted = $orders->where('status', 'completed')->count();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pesanan');

        // Title Row
        $sheet->setCellValue('A1', 'LAPORAN PENJUALAN & PESANAN SENTA PRINT');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('1E3A8A'));
        
        $sheet->setCellValue('A2', 'Periode Laporan: ' . $startDate->format('d/m/Y') . ' s/d ' . $endDate->format('d/m/Y'));
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('4B5563'));

        // Executive Summary Box
        $sheet->setCellValue('A4', 'RINGKASAN EKSEKUTIF');
        $sheet->getStyle('A4')->getFont()->setBold(true);

        $sheet->setCellValue('A5', 'Total Transaksi:');
        $sheet->setCellValue('B5', $countOrders . ' Pesanan');
        $sheet->setCellValue('D5', 'Total Subtotal:');
        $sheet->setCellValue('E5', $sumSubtotal);

        $sheet->setCellValue('A6', 'Pesanan Selesai:');
        $sheet->setCellValue('B6', $countCompleted . ' Pesanan');
        $sheet->setCellValue('D6', 'Total Omset (Grand Total):');
        $sheet->setCellValue('E6', $sumGrandTotal);

        $sheet->getStyle('E5:E6')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('A5:E6')->getFont()->setBold(true);

        // Header Table
        $tableHeaders = [
            'No Invoice',
            'Tanggal Pesanan',
            'Nama Customer',
            'No WhatsApp',
            'Detail Produk & Qty',
            'Subtotal (Rp)',
            'Grand Total (Rp)',
            'Status Pembayaran',
            'Status Pesanan'
        ];

        $startRow = 9;
        $sheet->fromArray($tableHeaders, null, "A{$startRow}");

        // Style Table Header Row
        $headerRange = "A{$startRow}:I{$startRow}";
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E3A8A'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $currentRow = $startRow + 1;
        foreach ($orders as $order) {
            $itemsDetail = [];
            foreach ($order->items as $item) {
                $prodName = $item->product_name ?? ($item->product->name ?? 'Produk');
                $itemQty = $item->qty ?? ($item->quantity ?? 1);
                $itemsDetail[] = $prodName . ' (' . $itemQty . ' pcs)';
            }
            $itemsStr = implode(', ', $itemsDetail);
            $custPhone = $order->customer->phone ?? '-';

            $sheet->setCellValueExplicit("A{$currentRow}", $order->invoice_no, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue("B{$currentRow}", $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-');
            $sheet->setCellValue("C{$currentRow}", $order->customer->name ?? '-');
            $sheet->setCellValueExplicit("D{$currentRow}", $custPhone, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue("E{$currentRow}", $itemsStr);
            $sheet->setCellValue("F{$currentRow}", $order->subtotal);
            $sheet->setCellValue("G{$currentRow}", $order->grand_total);
            $sheet->setCellValue("H{$currentRow}", strtoupper($order->payment_status ?? 'PENDING'));
            $sheet->setCellValue("I{$currentRow}", ucfirst($order->status));

            // Alignments & Number formatting
            $sheet->getStyle("A{$currentRow}")->getFont()->setBold(true);
            $sheet->getStyle("F{$currentRow}:G{$currentRow}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("H{$currentRow}:I{$currentRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $currentRow++;
        }

        // Rekap Total Row
        $rekapRow = $currentRow;
        $sheet->setCellValue("A{$rekapRow}", "REKAP TOTAL ({$countOrders} PESANAN)");
        $sheet->mergeCells("A{$rekapRow}:E{$rekapRow}");
        $sheet->getStyle("A{$rekapRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        
        $sheet->setCellValue("F{$rekapRow}", $sumSubtotal);
        $sheet->setCellValue("G{$rekapRow}", $sumGrandTotal);
        $sheet->getStyle("F{$rekapRow}:G{$rekapRow}")->getNumberFormat()->setFormatCode('#,##0');

        $sheet->setCellValue("H{$rekapRow}", "Omset Bersih");
        $sheet->mergeCells("H{$rekapRow}:I{$rekapRow}");
        $sheet->getStyle("H{$rekapRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("A{$rekapRow}:I{$rekapRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '92400E'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FEF3C7'],
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                    'color' => ['rgb' => '1E3A8A'],
                ],
            ],
        ]);

        // Auto-fit column widths
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $fileName = 'Laporan_Pesanan_SentaPrint_' . $startDate->format('Ymd') . '_' . $endDate->format('Ymd') . '.xlsx';

        return response()->streamDownload(function() use ($spreadsheet) {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
