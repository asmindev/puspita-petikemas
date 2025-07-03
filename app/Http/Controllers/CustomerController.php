<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('containers')
            ->with(['containers' => function ($query) {
                $query->whereNotNull('exit_date');
            }]);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Container filter
        if ($request->filled('container_filter')) {
            switch ($request->input('container_filter')) {
                case 'has_containers':
                    $query->has('containers');
                    break;
                case 'no_containers':
                    $query->doesntHave('containers');
                    break;
            }
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->input('date_to') . ' 23:59:59');
        }

        // Sorting
        $sort = $request->input('sort', 'name_asc');
        switch ($sort) {
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'created_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'containers_desc':
                $query->orderBy('containers_count', 'desc');
                break;
            case 'containers_asc':
                $query->orderBy('containers_count', 'asc');
                break;
            default: // name_asc
                $query->orderBy('name', 'asc');
                break;
        }

        // Pagination with custom per page
        $perPage = $request->input('per_page', 5);
        $allowedPerPage = [5, 10, 15, 25, 50];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 5;
        }

        $customers = $query->paginate($perPage);

        // Calculate penalty for each customer
        foreach ($customers as $customer) {
            $totalPenalty = 0;
            foreach ($customer->containers as $container) {
                $penaltyInfo = \App\Services\PenaltyCalculationService::calculateDeliveryPenalty($container);
                $totalPenalty += $penaltyInfo['total_amount'];
            }
            $customer->total_penalty = $totalPenalty;
        }

        // Apply penalty filter after calculation (since it's calculated dynamically)
        if ($request->filled('penalty_filter')) {
            $filteredCustomers = $customers->getCollection()->filter(function ($customer) use ($request) {
                switch ($request->input('penalty_filter')) {
                    case 'has_penalty':
                        return isset($customer->total_penalty) && $customer->total_penalty > 0;
                    case 'no_penalty':
                        return !isset($customer->total_penalty) || $customer->total_penalty == 0;
                    default:
                        return true;
                }
            });

            // Update the paginator with filtered results
            $customers->setCollection($filteredCustomers);
        }

        // Preserve query parameters for pagination
        $customers->appends($request->query());

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Customer::create([
            'name' => $request->name,
            'container_count' => 0,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        $customer->load('containers');
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $customer->update([
            'name' => $request->name,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
