<?php

namespace App\Helpers;

use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\AssetStatus;
use App\Models\Color;
use Illuminate\Support\Facades\DB;

class StatusSynchronizationHelper
{
    /**
     * Get the most recent assignment for an asset
     * If multiple assignments have the same created_at, use the one with higher id
     */
    public static function getMostRecentAssignment(int $assetId): ?Assignment
    {
        return Assignment::where('asset_id', $assetId)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Check if an assignment is the most recent for its asset
     */
    public static function isMostRecentAssignment(Assignment $assignment): bool
    {
        $mostRecent = static::getMostRecentAssignment($assignment->asset_id);
        return $mostRecent && $mostRecent->id === $assignment->id;
    }

    /**
     * Find or create AssetStatus by matching AssignmentStatus value
     */
    public static function findOrCreateAssetStatusByAssignmentStatus(int $assignmentStatusId): int
    {
        $assignmentStatus = AssignmentStatus::find($assignmentStatusId);
        if (!$assignmentStatus) {
            throw new \Exception("AssignmentStatus with id {$assignmentStatusId} not found");
        }

        $assetStatus = AssetStatus::where('asset_status', $assignmentStatus->assignment_status)->first();

        if (!$assetStatus) {
            // Get color_id - try "gray" first, then get first available
            $grayColor = Color::where('name', 'gray')->first();
            $colorId = $grayColor ? $grayColor->id : Color::first()?->id;

            if (!$colorId) {
                throw new \Exception("No color found in database");
            }

            $assetStatus = AssetStatus::create([
                'asset_status' => $assignmentStatus->assignment_status,
                'color_id' => $colorId,
            ]);
        }

        return $assetStatus->id;
    }

    /**
     * Find or create AssignmentStatus by matching AssetStatus value
     */
    public static function findOrCreateAssignmentStatusByAssetStatus(int $assetStatusId): int
    {
        $assetStatus = AssetStatus::find($assetStatusId);
        if (!$assetStatus) {
            throw new \Exception("AssetStatus with id {$assetStatusId} not found");
        }

        $assignmentStatus = AssignmentStatus::where('assignment_status', $assetStatus->asset_status)->first();

        if (!$assignmentStatus) {
            $assignmentStatus = AssignmentStatus::create([
                'assignment_status' => $assetStatus->asset_status,
            ]);
        }

        return $assignmentStatus->id;
    }

    /**
     * Sync Asset Status from Assignment Status
     */
    public static function syncAssetStatusFromAssignment(Assignment $assignment): void
    {
        if (!static::isMostRecentAssignment($assignment)) {
            return; // Only sync if this is the most recent assignment
        }

        $assetStatusId = static::findOrCreateAssetStatusByAssignmentStatus($assignment->assignment_status);
        $assignment->asset->update(['asset_status' => $assetStatusId]);
    }

    /**
     * Sync Assignment Status from Asset Status
     */
    public static function syncAssignmentStatusFromAsset(int $assetId, int $assetStatusId): void
    {
        $mostRecentAssignment = static::getMostRecentAssignment($assetId);

        if (!$mostRecentAssignment) {
            return; // No assignment to sync
        }

        $assignmentStatusId = static::findOrCreateAssignmentStatusByAssetStatus($assetStatusId);
        $mostRecentAssignment->update(['assignment_status' => $assignmentStatusId]);
    }
}
