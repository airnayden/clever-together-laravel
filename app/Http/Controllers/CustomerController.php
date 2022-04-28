<?php

namespace App\Http\Controllers;

use App\Http\Actions\Customer\DeleteCustomer;
use App\Http\Enums\CustomerMetaCodeEnum;
use App\Http\Requests\Customer\CustomerCreateRequest;
use App\Http\Requests\Customer\CustomerDestroyRequest;
use App\Http\Requests\Customer\CustomerIndexRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Request;

/**
 * This is a cat. Nothing to see here...
 *
 *      /\       /\
 *     /  \_____/  \
 *    /             \
 *   (   ()    ()    )
 *   (       Y       )
 *   \    \_/\_/    /
 *    \____________/
 *
 */
class CustomerController extends BaseController
{
    /**
     * List Customers
     *
     * @param CustomerIndexRequest $request
     * @return View
     */
    public function index(CustomerIndexRequest $request): View
    {
        // Sort params
        extract($this->getQueryStringParams($request));

        // Results
        $query = Customer::orderBy($sort, $order);

        if (!empty($search)) {
            $query->where(function (Builder $query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%');
                $query->orWhere('last_name', 'like', '%' . $search . '%');
                $query->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $customers = $query->paginate($limit);

        // View
        return view(
            'customer.index',
            [
                'customers' => $customers,
                'pageTitle' => __('Customers'),
                'sort' => $sort,
                'order' => $order,
                'limit' => $limit,
                'page' => $page,
                'search' => $search
            ]
        );
    }

    /**
     * Show single Customer
     *
     * @param Request $request
     * @param int $customerId
     * @return View
     */
    public function show(Request $request, int $customerId): View
    {
        extract($this->getQueryStringParams($request));

        // Get our guy
        $customer = Customer::with(['roles', 'meta'])
            ->findOrFail($customerId)
            ->makeHidden('password');

        // VIew
        return view(
            'customer.show',
            [
                'customer' => $customer,
                'sort' => $sort,
                'order' => $order,
                'limit' => $limit,
                'page' => $page,
                'search' => $search
            ]
        );
    }

    public function store(CustomerCreateRequest $request)
    {

    }

    public function update(CustomerUpdateRequest $request)
    {

    }

    /**
     * Delete a Customer
     *
     * @param CustomerDestroyRequest $request
     * @param int $customerId
     * @return RedirectResponse
     */
    public function destroy(CustomerDestroyRequest $request, int $customerId): RedirectResponse
    {
        DeleteCustomer::execute(Customer::findOrFail($customerId));

        // Redirect back to our Customer Index
        extract($this->getQueryStringParams($request));

        return redirect(sprintf('customer?sort=%s&order=%s&limit=%s&page=%s&search=%s', $sort, $order, $limit, $page, $search));
    }

    /**
     * Render update form
     *
     * @param Request $request
     * @param int $customerId
     * @return View
     */
    public function updateForm(Request $request, int $customerId): View
    {
        // Get our guy
        $customer = Customer::with(['roles', 'meta'])
            ->findOrFail($customerId)
            ->makeHidden('password');

        // View
        return $this->getForm($request, $customer);
    }

    /**
     * Render Customer store form
     *
     * @param Request $request
     * @return View
     */
    public function storeForm(Request $request): View
    {
        // View
        return $this->getForm($request);
    }

    /**
     * Render store / update form
     *
     * @param $request
     * @param Customer|null $customer
     * @return View
     */
    private function getForm($request, ?Customer $customer = null): View
    {
        $data = [
            'allowed_roles' => Role::get(),
            'allowed_meta' => CustomerMetaCodeEnum::cases()
        ];

        if (!is_null($customer)) {
            $data['customer'] = $customer;
            $data['endpoint'] = route('customer.update', ['customer_id' => $customer->id]);
            $data['pageTitle'] = __('Update Customer');
        } else {
            $data['endpoint'] = route('customer.store');
            $data['pageTitle'] = __('Store Customer');
        }

        $data = array_merge($data, $this->getQueryStringParams($request));

        return view('customer.form', $data);
    }

    /**
     * @param $request
     * @return array
     */
    private function getQueryStringParams($request): array
    {
        // Sort params
        $sort = Arr::get($request, 'sort', 'id');
        $order = Arr::get($request, 'order', 'ASC');
        $limit = Arr::get($request, 'limit', 10);
        $page = Arr::get($request, 'page', 1);
        $search = Arr::get($request, 'search');

        return compact('sort', 'order', 'limit', 'page', 'search');
    }
}
