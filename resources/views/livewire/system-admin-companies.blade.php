@php($heading = 'System Admin')
<div class="space-y-8">
    @if (session('status'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-[28px] bg-brand p-6 text-white shadow-sm">
            <p class="text-sm text-white/70">Total companies</p>
            <p class="mt-2 text-4xl font-semibold">{{ $companies->count() }}</p>
        </div>
        <div class="rounded-[28px] bg-white/80 p-6 shadow-sm">
            <p class="text-sm text-slate-500">Active subscriptions</p>
            <p class="mt-2 text-4xl font-semibold text-slate-900">{{ $companies->where('is_active', true)->count() }}</p>
        </div>
        <div class="rounded-[28px] bg-white/80 p-6 shadow-sm">
            <p class="text-sm text-slate-500">Pending approvals</p>
            <p class="mt-2 text-4xl font-semibold text-amber-600">{{ $companies->where('subscription_status', 'pending')->count() }}</p>
        </div>
    </div>

    <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
        <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm text-slate-500">Company control panel</p>
                <h2 class="text-2xl font-semibold text-brand">All company subscriptions</h2>
            </div>
            <p class="text-sm text-slate-500">Only system admin can see this list and activate or deactivate access.</p>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead>
                    <tr class="text-left text-slate-500">
                        <th class="py-3 pr-4 font-medium">Company</th>
                        <th class="py-3 pr-4 font-medium">Owner</th>
                        <th class="py-3 pr-4 font-medium">Plan</th>
                        <th class="py-3 pr-4 font-medium">Payment</th>
                        <th class="py-3 pr-4 font-medium">Status</th>
                        <th class="py-3 pr-4 font-medium">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($companies as $company)
                        @php($registration = $company->registrations->first())
                        @php($owner = $company->users->firstWhere('role', 'super_admin'))
                        <tr class="align-top">
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-slate-900">{{ $company->name }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $company->phone ?: 'No phone' }}</p>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-medium text-slate-800">{{ $owner?->name ?? 'Not assigned' }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $owner?->email ?? 'No email' }}</p>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-medium text-slate-800">{{ $company->subscription_plan ?: 'No plan' }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $company->billing_cycle ?: 'No cycle' }}</p>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-medium text-slate-800">{{ $registration?->payment_method ? strtoupper($registration->payment_method) : 'N/A' }}</p>
                                <p class="mt-1 text-xs text-slate-500">TRX: {{ $registration?->transaction_id ?? 'N/A' }}</p>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $company->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $company->is_active ? 'Active' : ucfirst($company->subscription_status) }}
                                </span>
                            </td>
                            <td class="py-4 pr-4">
                                <button
                                    type="button"
                                    wire:click="toggleCompany({{ $company->id }})"
                                    class="rounded-2xl px-4 py-2 font-semibold text-white {{ $company->is_active ? 'bg-rose-500' : 'bg-emerald-500' }}"
                                >
                                    {{ $company->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-500">No companies found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
