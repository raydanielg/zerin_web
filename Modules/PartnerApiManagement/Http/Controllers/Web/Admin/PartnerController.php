<?php

namespace Modules\PartnerApiManagement\Http\Controllers\Web\Admin;

use App\Http\Controllers\BaseController;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\PartnerApiManagement\Entities\Partner;
use Modules\UserManagement\Service\Interfaces\CustomerServiceInterface;

class PartnerController extends BaseController
{
    use AuthorizesRequests;

    protected CustomerServiceInterface $customerService;

    public function __construct(CustomerServiceInterface $customerService)
    {
        parent::__construct($customerService);
        $this->customerService = $customerService;
    }

    public function index(?Request $request, ?string $type = null): View|Collection|LengthAwarePaginator|null|callable|RedirectResponse
    {
        $this->authorize('partner_view');

        $query = Partner::query()->with('customer');

        if ($request->get('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->get('status') === 'inactive') {
            $query->where('is_active', false);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('api_key', 'like', "%{$search}%");
            });
        }

        $partners = $query->orderBy('created_at', 'desc')
            ->paginate(paginationLimit());

        return view('partnerapimanagement::admin.partners.index', compact('partners'));
    }

    public function create(): View
    {
        $this->authorize('partner_add');
        return view('partnerapimanagement::admin.partners.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('partner_add');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'webhook_url' => 'nullable|url|max:500',
        ]);

        $apiKey = 'pk_' . Str::random(24);
        $apiSecret = Str::random(40);
        $webhookSecret = Str::random(40);

        [$firstName, $lastName] = $this->splitName($validated['name']);

        $customer = $this->customerService->createExternalCustomer([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? ('00000000000' . random_int(0, 999)),
        ]);

        $partner = Partner::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'api_key' => $apiKey,
            'api_secret' => Hash::make($apiSecret),
            'customer_id' => $customer->id,
            'webhook_url' => $validated['webhook_url'] ?? null,
            'webhook_secret' => $webhookSecret,
            'is_active' => true,
        ]);

        Toastr::success(ucfirst(PARTNER_STORE_200['message']));

        return redirect()->route('admin.partner.show', $partner->id)
            ->with('api_secret', $apiSecret)
            ->with('webhook_secret', $webhookSecret);
    }

    public function show(string $id): View
    {
        $this->authorize('partner_view');

        $partner = Partner::with('customer')->findOrFail($id);
        $apiSecret = session('api_secret');
        $webhookSecret = session('webhook_secret');

        return view('partnerapimanagement::admin.partners.show', compact('partner', 'apiSecret', 'webhookSecret'));
    }

    public function edit(string $id): View
    {
        $this->authorize('partner_edit');

        $partner = Partner::with('customer')->findOrFail($id);
        return view('partnerapimanagement::admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $this->authorize('partner_edit');

        $partner = Partner::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'webhook_url' => 'nullable|url|max:500',
            'is_active' => 'boolean',
        ]);

        $partner->update([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'webhook_url' => $validated['webhook_url'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        Toastr::success(PARTNER_UPDATE_200['message']);
        return redirect()->route('admin.partner.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->authorize('partner_delete');

        $partner = Partner::findOrFail($id);
        $partner->delete();

        Toastr::success(PARTNER_DESTROY_200['message']);
        return redirect()->route('admin.partner.index');
    }

    public function status(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('partner_edit');

        $partner = Partner::findOrFail($request->id);
        $partner->update(['is_active' => $request->boolean('status')]);

        return response()->json(['success' => true]);
    }

    public function regenerateSecret(string $id): RedirectResponse
    {
        $this->authorize('partner_edit');

        $partner = Partner::findOrFail($id);
        $newSecret = Str::random(40);
        $partner->update(['api_secret' => Hash::make($newSecret)]);

        Toastr::success('API secret regenerated. Save it now - it won\'t be shown again.');
        return redirect()->route('admin.partner.show', $partner->id)
            ->with('api_secret', $newSecret);
    }

    public function regenerateWebhookSecret(string $id): RedirectResponse
    {
        $this->authorize('partner_edit');

        $partner = Partner::findOrFail($id);
        $newSecret = Str::random(40);
        $partner->update(['webhook_secret' => $newSecret]);

        Toastr::success('Webhook secret regenerated. Save it now - it won\'t be shown again.');
        return redirect()->route('admin.partner.show', $partner->id)
            ->with('webhook_secret', $newSecret);
    }

    private function splitName(string $name): array
    {
        $parts = preg_split('/\s+/', trim($name), 2);
        return [$parts[0], $parts[1] ?? $parts[0]];
    }
}
