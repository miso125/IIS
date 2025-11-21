<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WineyardRow;
use App\Models\Harvest;
use App\Models\Treatment;
use App\Models\WineBatch;
use App\Models\Purchase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('winemaker')) {
            return $this->winemakerDashboard();
        } elseif ($user->hasRole('worker')) {
            return $this->workerDashboard();
        } elseif ($user->hasRole('customer')) {
            return $this->customerDashboard();
        }

        return view('dashboard');
    }

    /**
     * Admin Dashboard
     */
    private function adminDashboard()
    {
        return view('dashboard', [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('isActive', true)->count(),
            'totalVineyards' => WineyardRow::count(),
            'totalHarvests' => Harvest::count(),
            'recentUsers' => User::get(),
        ]);
    }

    /**
     * Vinar Dashboard
     */
    private function winemakerDashboard()
    {
        $user = auth()->user();

        return view('dashboard', [
            'myVineyards' => $user->wineyardrows()->count(),
            'myVineyardsList' => $user->wineyardrows()->paginate(5),
            'totalHarvests' => $user->harvests()->count(),
            'totalBatches' => WineBatch::whereHas('harvest.winerow', function($q) use ($user) {
                $q->where('user', $user->login);
            })->count(),
            'totalTreatments' => $user->treatments()->count(),
        ]);
    }

    /**
     * Worker Dashboard
     */
    private function workerDashboard()
    {
        return view('dashboard', [
            'recentTreatments' => Treatment::where('user', auth()->id())
                ->latest('date_time')
                ->limit(5)
                ->get(),
            'recentHarvests' => Harvest::where('user', auth()->id())
                ->latest('date_time')
                ->limit(5)
                ->get(),
        ]);
    }

    /**
     * Customer Dashboard
     */
    private function customerDashboard()
    {
        $user = auth()->user();

        return view('dashboard', [
            'myPurchases' => $user->purchases()->count(),
            'totalSpent' => $user->purchases()->sum('sum'),
            'availableWines' => WineBatch::where('number_of_bottles', '>', 0)->count(),
        ]);
    }
}
