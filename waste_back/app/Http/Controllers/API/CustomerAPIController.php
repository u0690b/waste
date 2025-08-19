<?php

namespace App\Http\Controllers\API;


use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CustomerController
 * @package App\Http\Controllers\API
 */

class CustomerAPIController extends AppBaseController
{
    /**
     * Display a listing of the Customer.
     * GET|HEAD /customers
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = Customer::filter( $request->all(["search", ...Customer::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $customers = $query->get();

        return $customers->toJson();
    }

    /**
     * Store a newly created Customer in storage.
     * POST /customers
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(Customer::$rules);

        /** @var Customer $customer */
        $customer = Customer::create($input);

        return $customer->toJson();
    }

    /**
     * Display the specified Customer.
     * GET|HEAD /customers/{id}
     *
     * @param Customer $customers
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var Customer $customer */
        $customer = Customer::find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        return $customer->toJson();
    }

    /**
     * Update the specified Customer in storage.
     * PUT/PATCH /customers/{id}
     *
     * @param Customer $customers
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(Customer::$rules);
        /** @var Customer $customer */
        $customer = Customer::find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer->fill($input);
        $customer->save();

        return $customer->toJson();
    }

    /**
     * Remove the specified Customer from storage.
     * DELETE /customers/{id}
     *
     * @param Customer $customers
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var Customer $customer */
        $customer = Customer::find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer->delete();

        return $this->sendSuccess('Customer deleted successfully');
    }
}
