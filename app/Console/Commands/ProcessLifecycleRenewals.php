<?php

namespace App\Console\Commands;

use App\Jobs\ProcessLifecycleRenewal;
use App\Models\Lifecycle;
use App\Models\User;
use App\Notifications\AutomaticRenewalFailed;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ProcessLifecycleRenewals extends Command
{
    protected $signature = 'lifecycles:process-renewals';
    protected $description = 'Process automatic renewals for lifecycles';

    public function handle()
    {
        $now = Carbon::now();

        // Get all lifecycles due for renewal (14 days before retirement)
        $lifecycles = Lifecycle::query()
            ->whereHas('asset', function ($query) {
                $query->where('asset_type', 'software');
            })
            ->whereHas('asset.software.licenseType', function ($query) {
                $query->whereIn('license_type', ['Monthly Subscription', 'Annual Subscription']);
            })
            ->where('auto_renewal_enabled', true)
            ->where('renewal_in_progress', false)
            ->whereDate('retirement_date', '<=', $now->copy()->addDays(14))
            ->whereDate('retirement_date', '>', $now)
            ->get();

        foreach ($lifecycles as $lifecycle) {
            ProcessLifecycleRenewal::dispatch($lifecycle);
        }

        $this->info("Dispatched renewal jobs for {$lifecycles->count()} lifecycles");
    }
}
