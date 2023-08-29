<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Models\Customer;
use ProtoneMedia\Splade\SpladeTable;
use Toast;

final class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::query()->paginate(5);

        return view("customer.index", [
            "customers" => SpladeTable::for($customers)
                ->column("first_name", "Nom")
                ->column("last_name", "Prenom")
                ->column("birthday", "Date d'anniversaire")
                ->column("contact")

        ]);
    }

    public function store(CreateCustomerRequest $request)
    {

        Customer::query()->create(
            array_merge(
                $request->payload()->toArray(),
                ["user_id" => auth()->id()]
            )
        );

        Toast::message("Client créer avec succès")->autoDismiss(5);
        return redirect()->route("administrative.index");
    }

    public function create()
    {
        $customers = Customer::query()->paginate();

        return view("customer.create");
    }
}
