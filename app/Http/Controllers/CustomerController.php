<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use ProtoneMedia\Splade\SpladeTable;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Toast;


final class CustomerController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $perPage = request()->get("perPage");
        $customers = Customer::query()->paginate($perPage ?? 5);

        return view("customer.index", [
            "customers" => SpladeTable::for($customers)
                ->column("first_name", "Nom")
                ->column("last_name", "Prenom")
                ->column("birthday", "Date d'anniversaire")
                ->column("contact")


        ]);
    }

    /**
     * @param CreateCustomerRequest $request
     * @return RedirectResponse
     */
    public function store(CreateCustomerRequest $request): RedirectResponse
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

    /**
     * @return View
     */
    public function create(): View
    {
        
        $customers = Customer::query()->paginate();
        return view("customer.create");
    }
}
