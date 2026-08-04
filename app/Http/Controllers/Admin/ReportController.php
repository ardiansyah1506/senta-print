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
        $filterType = $request->input('filter_type', 'month');
        $month = (int) $request->input('month', date('n'));
        $year = (int) $request->input('year', date('Y'));
        $startDateStr = $request->input('start_date');
        $endDateStr = $request->input('end_date');

        if ($filterType === 'range' && $startDateStr && $endDateStr) {
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
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();
        }

        return [$startDate, $endDate, $filterType, $month, $year, $startDateStr, $endDateStr];
    }

    public function index(Request $request) {
        [$startDate, $endDate, $filterType, $month, $year, $startDateStr, $endDateStr] = $this->resolveDateRange($request);

        // Fetch Orders within range
        $ordersQuery = Order::with(['customer', 'items.product'])
            ->whereBetween('created_at', [$startDate, $endDate]);

        $allOrders = $ordersQuery->get();
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
        $daysCount = $startDate->diffInDays($endDate) + 1;
        
        $target = Target::where('start_date', $startDate->format('Y-m-d'))
            ->where('end_date', $endDate->format('Y-m-d'))
            ->first();

        $targetAmount = 0;
        
        if ($target) {
            $targetAmount = $target->target_amount;
        } else {
            $defaults = Target::whereNull('start_date')->get()->keyBy('type');
            
            if ($daysCount == 1) {
                if (isset($defaults['daily'])) $targetAmount = $defaults['daily']->target_amount;
                elseif (isset($defaults['monthly'])) $targetAmount = ($defaults['monthly']->target_amount / 30);
            } elseif ($daysCount == 7) {
                if (isset($defaults['weekly'])) $targetAmount = $defaults['weekly']->target_amount;
                elseif (isset($defaults['daily'])) $targetAmount = $defaults['daily']->target_amount * 7;
                elseif (isset($defaults['monthly'])) $targetAmount = ($defaults['monthly']->target_amount / 30) * 7;
            } elseif ($startDate->copy()->startOfMonth()->isSameDay($startDate) && $endDate->copy()->endOfMonth()->isSameDay($endDate)) {
                $monthsCount = $startDate->diffInMonths($endDate->copy()->addDay()); // diffInMonths needs the end date to be precisely 1 month apart, addDay ensures it counts full month
                if ($monthsCount == 0) $monthsCount = 1;
                
                if (isset($defaults['monthly'])) {
                    $targetAmount = $defaults['monthly']->target_amount * $monthsCount;
                } elseif (isset($defaults['daily'])) {
                    $targetAmount = $defaults['daily']->target_amount * $daysCount;
                }
            } elseif ($startDate->copy()->startOfYear()->isSameDay($startDate) && $endDate->copy()->endOfYear()->isSameDay($endDate)) {
                if (isset($defaults['yearly'])) $targetAmount = $defaults['yearly']->target_amount;
                elseif (isset($defaults['monthly'])) $targetAmount = $defaults['monthly']->target_amount * 12;
                elseif (isset($defaults['daily'])) $targetAmount = $defaults['daily']->target_amount * $daysCount;
            } else {
                if (isset($defaults['daily'])) {
                    $targetAmount = $defaults['daily']->target_amount * $daysCount;
                } elseif (isset($defaults['monthly'])) {
                    $targetAmount = ($defaults['monthly']->target_amount / 30) * $daysCount;
                } elseif (isset($defaults['yearly'])) {
                    $targetAmount = ($defaults['yearly']->target_amount / 365) * $daysCount;
                }
            }
        }

        $achievementPercentage = $targetAmount > 0 ? ($totalRevenue / $targetAmount) * 100 : 0;

        return view('admin.laporan', compact(
            'startDate',
            'endDate',
            'filterType',
            'month',
            'year',
            'startDateStr',
            'endDateStr',
            'allOrders',
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
            'type' => 'required|string',
            'target_amount' => 'required|numeric|min:0'
        ]);

        $type = $request->input('type');
        $targetAmount = $request->input('target_amount');

        if ($type === 'custom') {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date'
            ]);
            
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

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
        } else {
            $target = Target::where('type', $type)->whereNull('start_date')->first();
            if ($target) {
                $target->update(['target_amount' => $targetAmount]);
            } else {
                Target::create([
                    'type' => $type,
                    'start_date' => null,
                    'end_date' => null,
                    'target_amount' => $targetAmount
                ]);
            }
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

        $fileName = 'Laporan_Pesanan_SentaPrint_' . $startDate->format('Ymd') . '_' . $endDate->format('Ymd') . '.xls';

        $headers = [
            "Content-Type" => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($orders, $startDate, $endDate, $sumSubtotal, $sumGrandTotal, $countOrders, $countCompleted) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            echo '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Laporan Pesanan</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
            echo '<style>';
            echo 'th { background-color: #1E3A8A; color: #FFFFFF; font-weight: bold; border: 1px solid #000000; padding: 10px; text-align: center; font-family: Arial, sans-serif; font-size: 12px; }';
            echo 'td { border: 1px solid #D1D5DB; padding: 8px; vertical-align: top; font-family: Arial, sans-serif; font-size: 11px; }';
            echo '.text { mso-number-format:"\@"; }';
            echo '.num { mso-number-format:"\#\,\#\#0"; text-align: right; }';
            echo '.title { font-size: 18px; font-weight: bold; color: #1E3A8A; margin-bottom: 4px; font-family: Arial, sans-serif; }';
            echo '.subtitle { font-size: 12px; color: #4B5563; margin-bottom: 12px; font-family: Arial, sans-serif; }';
            echo '.rekap-total { background-color: #FEF3C7; font-weight: bold; color: #92400E; border-top: 2px solid #1E3A8A; font-size: 12px; }';
            echo '</style></head>';
            echo '<body>';
            echo '<div class="title">LAPORAN PENJUALAN & PESANAN SENTA PRINT</div>';
            echo '<div class="subtitle">Periode Laporan: <b>' . $startDate->format('d/m/Y') . '</b> s/d <b>' . $endDate->format('d/m/Y') . '</b> | Total Pesanan: <b>' . $countOrders . '</b></div>';
            
            // Executive Summary Table
            echo '<table border="1" style="margin-bottom: 16px; width: 100%; border-collapse: collapse;">';
            echo '<tr>';
            echo '<td style="background-color:#EFF6FF; font-weight:bold;">Total Transaksi: ' . $countOrders . ' Pesanan</td>';
            echo '<td style="background-color:#ECFDF5; font-weight:bold;">Pesanan Selesai: ' . $countCompleted . ' Pesanan</td>';
            echo '<td style="background-color:#FEF3C7; font-weight:bold;">Total Subtotal: Rp ' . number_format($sumSubtotal, 0, ',', '.') . '</td>';
            echo '<td style="background-color:#DBEAFE; font-weight:bold;">Total Omset (Grand Total): Rp ' . number_format($sumGrandTotal, 0, ',', '.') . '</td>';
            echo '</tr>';
            echo '</table><br/>';

            echo '<table border="1" style="width: 100%; border-collapse: collapse;">';
            echo '<thead><tr>';
            echo '<th>No Invoice</th>';
            echo '<th>Tanggal Pesanan</th>';
            echo '<th>Nama Customer</th>';
            echo '<th>No WhatsApp</th>';
            echo '<th>Detail Produk & Qty</th>';
            echo '<th>Subtotal (Rp)</th>';
            echo '<th>Grand Total (Rp)</th>';
            echo '<th>Status Pembayaran</th>';
            echo '<th>Status Pesanan</th>';
            echo '</tr></thead>';
            echo '<tbody>';

            foreach ($orders as $index => $order) {
                $itemsDetail = [];
                foreach ($order->items as $item) {
                    $prodName = $item->product_name ?? ($item->product->name ?? 'Produk');
                    $itemQty = $item->qty ?? ($item->quantity ?? 1);
                    $itemsDetail[] = $prodName . ' (' . $itemQty . ' pcs)';
                }
                $itemsStr = implode(', ', $itemsDetail);
                $custPhone = $order->customer->phone ?? '-';
                $rowBg = ($index % 2 == 1) ? 'background-color: #F9FAFB;' : '';

                echo '<tr style="' . $rowBg . '">';
                echo '<td class="text" style="font-weight: bold; color: #1E3A8A;">' . htmlspecialchars($order->invoice_no) . '</td>';
                echo '<td>' . htmlspecialchars($order->created_at->format('d/m/Y H:i')) . '</td>';
                echo '<td>' . htmlspecialchars($order->customer->name ?? '-') . '</td>';
                echo '<td class="text">' . htmlspecialchars($custPhone) . '</td>';
                echo '<td>' . htmlspecialchars($itemsStr) . '</td>';
                echo '<td class="num">' . number_format($order->subtotal, 0, ',', '.') . '</td>';
                echo '<td class="num" style="font-weight: bold;">' . number_format($order->grand_total, 0, ',', '.') . '</td>';
                echo '<td style="text-align: center;">' . htmlspecialchars(strtoupper($order->payment_status ?? 'PENDING')) . '</td>';
                echo '<td style="text-align: center;">' . htmlspecialchars(ucfirst($order->status)) . '</td>';
                echo '</tr>';
            }

            // REKAP TOTAL FOOTER ROW
            echo '<tr class="rekap-total">';
            echo '<td colspan="5" style="text-align: right; padding: 10px; font-weight: bold;">REKAP TOTAL (' . $countOrders . ' PESANAN) :</td>';
            echo '<td class="num" style="font-weight: bold;">' . number_format($sumSubtotal, 0, ',', '.') . '</td>';
            echo '<td class="num" style="font-weight: bold; font-size: 12px; color: #1E3A8A;">' . number_format($sumGrandTotal, 0, ',', '.') . '</td>';
            echo '<td colspan="2" style="text-align: center; font-size: 11px;">Omset Bersih Periode ini</td>';
            echo '</tr>';

            echo '</tbody></table></body></html>';
        };

        return response()->stream($callback, 200, $headers);
    }
}
