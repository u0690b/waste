<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the Customer.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $customers = Customer::filter(Request::all(["search", ...Customer::$searchIn]))
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($customers->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/customers/Index', [
            'filters' => Request::only(["search", ...Customer::$searchIn, 'orderBy', 'dir']),
            'datas' => $customers
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new Customer.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/customers/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Customer in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Customer::$rules;
        $input =  Request::validate($rule);
        $customer = Customer::create($input);
        return redirect(Request::header('back') ?? route('admin.customers.show', $customer->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Customer $customer
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Customer $customer)
    {
        $customer;
        return Inertia::render('Admin/customers/Show', [
            'data' =>  $customer,
        ]);
    }

    /**
     * Show the form for editing the specified Customer.
     *
     * @param Customer $customer
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Customer $customer)
    {
        $customer;
        return Inertia::render('Admin/customers/Edit', [
            'data' =>  $customer,
        ]);
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param Customer $customer
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Customer $customer)
    {
        $rule = Customer::$rules;
        $input =  Request::validate($rule);
        $customer->update($input);
        
        return redirect(Request::header('back') ?? route('admin.customers.show', $customer->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Customer from storage.
     *
     * @param Customer $customer
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect(Request::header('back') ?? route('admin.customers.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
