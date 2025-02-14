<?php

namespace App\Jobs;

use App\Models\Lifecycle;
use App\Models\User;
use App\Notifications\AutomaticRenewalFailed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessLifecycleRenewal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1; // Only try once, but keep retrying daily via command

    public function __construct(protected Lifecycle $lifecycle) {}

    public function handle()
    {
        DB::beginTransaction();
        try {
            // Mark as in progress
            $this->lifecycle->update(['renewal_in_progress' => true]);

            $oldDate = Carbon::parse($this->lifecycle->retirement_date);
            $newDate = $this->calculateNewRetirementDate($oldDate);

            // Create renewal record
            $this->lifecycle->renewals()->create([
                'old_retirement_date' => $oldDate,
                'new_retirement_date' => $newDate,
                'is_automatic' => true,
                'remarks' => 'Automatic renewal processed'
            ]);

            // Update lifecycle
            $this->lifecycle->update([
                'retirement_date' => $newDate,
                'renewal_in_progress' => false
            ]);

            DB::commit();

            Log::info('Automatic renewal processed', [
                'lifecycle_id' => $this->lifecycle->id,
                'old_date' => $oldDate,
                'new_date' => $newDate
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            // Disable auto-renewal and notify admins
            $this->lifecycle->update([
                'auto_renewal_enabled' => false,
                'renewal_in_progress' => false
            ]);

            Log::error('Automatic renewal failed', [
                'lifecycle_id' => $this->lifecycle->id,
                'error' => $e->getMessage()
            ]);

            // Notify all admin users
            User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->each(function ($admin) use ($e) {
                $admin->notify(new AutomaticRenewalFailed($this->lifecycle, $e->getMessage()));
            });

            throw $e;
        }
    }

    protected function calculateNewRetirementDate(Carbon $currentDate): Carbon
    {
        $licenseType = $this->lifecycle->asset->software->licenseType->license_type;

        if ($licenseType === 'Monthly Subscription') {
            // If it's the last day of the month, use the last day of the next month
            if ($currentDate->copy()->endOfMonth()->isSameDay($currentDate)) {
                return $currentDate->copy()->addMonth()->endOfMonth();
            }

            return $currentDate->copy()->addMonth();
        }

        // Annual Subscription
        return $currentDate->copy()->addYear();
    }
}
