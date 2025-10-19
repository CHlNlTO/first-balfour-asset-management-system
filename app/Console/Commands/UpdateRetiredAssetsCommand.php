<?php

namespace App\Console\Commands;

use App\Jobs\UpdateRetiredAssetsStatus;
use Illuminate\Console\Command;

class UpdateRetiredAssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assets:update-retired-status
                            {--dry-run : Show what would be updated without making changes}
                            {--force : Force the update even if no assets are found}
                            {--limit= : Limit the number of assets to update (useful for testing)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update asset statuses to Inactive for assets that have reached their retirement date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting asset retirement status update...');

        if ($this->option('dry-run')) {
            $this->info('DRY RUN MODE - No changes will be made');
            $this->showRetiredAssets();
            return;
        }

        try {
            $limit = $this->option('limit') ? (int) $this->option('limit') : null;

            if ($limit) {
                $this->info("Running job with limit of {$limit} assets...");
            } else {
                $this->info('Running job for all eligible assets...');
            }

            // Dispatch the job
            UpdateRetiredAssetsStatus::dispatch($limit);
            $this->info('Job dispatched successfully! Check the logs for details.');

            // Also run it immediately for testing
            $this->info('Running job immediately for testing...');
            $job = new UpdateRetiredAssetsStatus($limit);
            $job->handle();

            $this->info('Job completed! Check the logs for detailed results.');

        } catch (\Exception $e) {
            $this->error('Job failed: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Show assets that would be updated (dry run)
     */
    private function showRetiredAssets()
    {
        $limit = $this->option('limit') ? (int) $this->option('limit') : null;
        $job = new UpdateRetiredAssetsStatus($limit);

        // Use reflection to access private method
        $reflection = new \ReflectionClass($job);
        $method = $reflection->getMethod('getRetiredAssets');
        $method->setAccessible(true);

        $retiredAssets = $method->invoke($job);

        if ($retiredAssets->isEmpty()) {
            $this->info('No assets found that need status update to Inactive');
            return;
        }

        // Apply limit if specified
        if ($limit && $retiredAssets->count() > $limit) {
            $retiredAssets = $retiredAssets->take($limit);
            $this->info("Found {$retiredAssets->count()} assets that would be updated (limited to {$limit} for testing):");
        } else {
            $this->info("Found {$retiredAssets->count()} assets that would be updated:");
        }

        $headers = ['ID', 'Tag Number', 'Asset Type', 'Current Status', 'Retirement Date'];
        $rows = [];

        foreach ($retiredAssets as $asset) {
            $rows[] = [
                $asset->id,
                $asset->tag_number ?? 'N/A',
                $asset->asset_type,
                $asset->assetStatus?->asset_status ?? 'Unknown',
                $asset->lifecycle?->retirement_date ?? 'N/A'
            ];
        }

        $this->table($headers, $rows);
    }
}
