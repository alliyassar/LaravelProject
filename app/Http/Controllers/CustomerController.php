<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Tüm müşterileri listeler.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    /**
     * Yeni müşteri ekleme sayfasını açar.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Yeni müşteriyi veritabanına kaydeder.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Müşteri başarıyla eklendi.');
    }

    /**
     * Müşteri düzenleme sayfasını açar.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Müşteri verilerini günceller.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Müşteri başarıyla güncellendi.');
    }

    /**
     * Müşteriyi veritabanından siler.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Müşteri başarıyla silindi.');
    }
}