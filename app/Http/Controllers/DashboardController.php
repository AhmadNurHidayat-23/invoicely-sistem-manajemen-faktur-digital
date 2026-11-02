<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = Invoice::query()->selectRaw(
            "COUNT(*) as total_count, COALESCE(SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END), 0) as paid_count,
            COALESCE(SUM(CASE WHEN status = 'unpaid' THEN 1 ELSE 0 END), 0) as unpaid_count,
            COALESCE(SUM(total), 0) as total_value"
        )->first();

        return view('dashboard', [
            'stats' => $stats,
            'invoices' => Invoice::latest('id')->limit(6)->get(),
            'overdueCount' => Invoice::where('status', 'unpaid')->whereDate('due_date', '<', today())->count(),
        ]);
    }
}
