<?php

namespace App\Jobs;

use App\Models\Asset;
use App\Models\AssetStatus;
use App\Models\Lifecycle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UpdateRetiredAssetsStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $limit;

    /**
     * Create a new job instance.
     */
    public function __construct($limit = null)
    {
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting UpdateRetiredAssetsStatus job');

        try {
            // Get the inactive status ID with fallback logic
            $inactiveStatusId = $this->getInactiveStatusId();

            if (!$inactiveStatusId) {
                Log::error('Could not find Inactive asset status. Job aborted.');
                return;
            }

            Log::info("Using asset status ID: {$inactiveStatusId} for Inactive status");

            // Find assets that have reached their retirement date
            $retiredAssets = $this->getRetiredAssets();

            if ($retiredAssets->isEmpty()) {
                Log::info('No assets found that need status update to Inactive');
                return;
            }

            Log::info("Found {$retiredAssets->count()} assets that need status update to Inactive");

            // Apply limit if specified
            if ($this->limit && $retiredAssets->count() > $this->limit) {
                $retiredAssets = $retiredAssets->take($this->limit);
                Log::info("Limited to {$this->limit} assets for testing");
            }

            $updatedCount = 0;
            $skippedCount = 0;

            DB::transaction(function () use ($retiredAssets, $inactiveStatusId, &$updatedCount, &$skippedCount) {
                foreach ($retiredAssets as $asset) {
                    // Skip if already inactive
                    if ($asset->asset_status == $inactiveStatusId) {
                        $skippedCount++;
                        Log::info("Asset ID {$asset->id} ({$asset->tag_number}) already has Inactive status. Skipping.");
                        continue;
                    }

                    // Get the old status name for logging
                    $oldStatusName = $asset->assetStatus?->asset_status ?? 'Unknown';

                    // Update the asset status
                    $asset->update(['asset_status' => $inactiveStatusId]);

                    $updatedCount++;

                    Log::info("Updated Asset ID {$asset->id} ({$asset->tag_number}) status from '{$oldStatusName}' to 'Inactive'. Retirement date: {$asset->lifecycle?->retirement_date}");
                }
            });

            Log::info("UpdateRetiredAssetsStatus job completed. Updated: {$updatedCount}, Skipped: {$skippedCount}");

        } catch (\Exception $e) {
            Log::error('UpdateRetiredAssetsStatus job failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Get the inactive status ID with fallback logic
     */
    private function getInactiveStatusId(): ?int
    {
        // Primary: Look for exact "Inactive" status
        $inactiveStatus = AssetStatus::where('asset_status', 'Inactive')->first();

        if ($inactiveStatus) {
            return $inactiveStatus->id;
        }

        // Fallback 1: Look for case variations
        $fallbackNames = ['inactive', 'INACTIVE', 'In Active'];

        foreach ($fallbackNames as $name) {
            $status = AssetStatus::where('asset_status', $name)->first();
            if ($status) {
                Log::warning("Found Inactive status with fallback name: '{$name}' (ID: {$status->id})");
                return $status->id;
            }
        }

        // Fallback 2: Look for status containing "inactive"
        $status = AssetStatus::whereRaw('LOWER(asset_status) LIKE ?', ['%inactive%'])->first();
        if ($status) {
            Log::warning("Found Inactive status with partial match: '{$status->asset_status}' (ID: {$status->id})");
            return $status->id;
        }

        // Fallback 3: If we know from the SQL dump that ID 2 is Inactive, use it
        $status = AssetStatus::find(2);
        if ($status && strtolower($status->asset_status) === 'inactive') {
            Log::warning("Using hardcoded ID 2 for Inactive status: '{$status->asset_status}'");
            return $status->id;
        }

        Log::error('Could not find any Inactive asset status. Available statuses: ' . AssetStatus::pluck('asset_status')->implode(', '));
        return null;
    }

    /**
     * Get assets that have reached their retirement date
     */
    private function getRetiredAssets()
    {
        $today = Carbon::today();

        return Asset::with(['lifecycle', 'assetStatus'])
            ->whereHas('lifecycle', function ($query) use ($today) {
                $query->whereNotNull('retirement_date')
                      ->whereDate('retirement_date', '<=', $today);
            })
            ->get();
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('UpdateRetiredAssetsStatus job failed permanently', [
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
