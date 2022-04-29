<?php

namespace App\Http\Controllers;

use App\Http\Actions\Customer\DeleteCustomer;
use App\Http\DataFactories\CustomerDataFactory;
use App\Http\Enums\CustomerMetaCodeEnum;
use App\Http\Requests\Customer\CustomerCreateRequest;
use App\Http\Requests\Customer\CustomerDestroyRequest;
use App\Http\Requests\Customer\CustomerIndexRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\CustomerMeta;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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

    /**
     * @param CustomerCreateRequest $request
     * @return RedirectResponse|View
     */
    public function store(CustomerCreateRequest $request): RedirectResponse|View
    {
        $customerData = CustomerDataFactory::fromCreateRequest($request);

        dd($customerData);
    }

    /**
     * @param CustomerUpdateRequest $request
     * @return RedirectResponse|View
     */
    public function update(CustomerUpdateRequest $request): RedirectResponse|View
    {
        $customerData = CustomerDataFactory::fromCreateRequest($request);

        dd($customerData);
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
     * @param Request|CustomerDestroyRequest|CustomerIndexRequest|CustomerCreateRequest|CustomerUpdateRequest $request
     * @param Customer|null $customer
     * @return View
     */
    private function getForm(
        Request|CustomerDestroyRequest|CustomerIndexRequest|CustomerCreateRequest|CustomerUpdateRequest $request,
        ?Customer $customer = null
    ): View
    {
        $data = [
            'allowedRoles' => Role::get(),
            'allowedMeta' => collect(CustomerMetaCodeEnum::cases())->map(function (CustomerMetaCodeEnum $meta) {
                return [
                    'prettyName' => ucwords(Str::lower(str_replace('_', ' ', $meta->name))),
                    'name' => $meta->name,
                    'value' => $meta->value
                ];
            })->toArray()
        ];

        if (!is_null($customer)) {
            $additional = [
                'customer' => $customer,
                'customerRoles' => $customer->roles->pluck('id')->toArray(),
                'customerMeta' => $customer->meta->map(function (CustomerMeta $meta) {
                    return [
                        'code' => $meta->code->name,
                        'value' => $meta->value
                    ];
                })->keyBy('code')->toArray(),
                'endpoint' => route('customer.update', ['customer_id' => $customer->id]),
                'pageTitle' => __('Update Customer')
            ];
        } else {
            $additional = [
                'endpoint' => route('customer.store'),
                'pageTitle' => __('Store Customer')
            ];
        }

        return view('customer.form', array_merge($data, $additional, $this->getQueryStringParams($request)));
    }

    /**
     * @param Request|CustomerDestroyRequest|CustomerIndexRequest|CustomerCreateRequest|CustomerUpdateRequest $request
     * @return array
     */
    private function getQueryStringParams(Request|CustomerDestroyRequest|CustomerIndexRequest|CustomerCreateRequest|CustomerUpdateRequest $request): array
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
