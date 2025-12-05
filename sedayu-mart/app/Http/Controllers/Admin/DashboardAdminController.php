<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use Carbon\Carbon;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Counts
        $usersCount = User::count();
        $produkCount = Produk::count();
        $pesananCount = Pesanan::count();

        // Latest 5 pesanan
        $pesanans = Pesanan::with('user')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Monthly stats for current year (Jan-Dec) with labels
        $year = Carbon::now()->year;
        $diagramCollection = collect([]);
        for ($m = 1; $m <= 12; $m++) {
            $total = Pesanan::whereMonth('created_at', $m)
                ->whereYear('created_at', $year)
                ->count();

            $diagramCollection->push([
                'bulan' => $m,
                'tahun' => $year,
                'total' => (int) $total,
            ]);
        }

        $diagramData = [
            'labels' => $diagramCollection->map(function ($item) {
                return Carbon::create($item['tahun'], $item['bulan'])->translatedFormat('F');
            })->toArray(),
            'data' => $diagramCollection->pluck('total')->toArray(),
        ];

        return view('admin.index', compact(
            'usersCount',
            'produkCount',
            'pesananCount',
            'pesanans',
            'diagramData',
            'year'
        ));
    }
}
