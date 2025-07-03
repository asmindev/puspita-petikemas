<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Container;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalContainers = Container::count();
        $pendingContainers = Container::where('status', 'pending')->count();
        $completedContainers = Container::where('status', 'completed')->count();

        $recentContainers = Container::with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalCustomers',
            'totalContainers',
            'pendingContainers',
            'completedContainers',
            'recentContainers'
        ));
    }
}
