<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Permission;

echo "Updating existing permissions to new status system...\n";

// Get all permissions
$permissions = Permission::all();
echo "Found " . $permissions->count() . " permissions to update\n";

foreach ($permissions as $permission) {
    // Check if permission has old is_accepted field data
    $oldData = \DB::table('permissions')->where('id', $permission->id)->first();
    
    if (isset($oldData->is_accepted)) {
        if ($oldData->is_accepted === null) {
            $newStatus = 'pending';
        } elseif ($oldData->is_accepted == 1) {
            $newStatus = 'accepted';
        } else {
            $newStatus = 'rejected';
        }
        
        echo "Updating permission ID {$permission->id} from is_accepted={$oldData->is_accepted} to status={$newStatus}\n";
        
        // Update to new status
        \DB::table('permissions')
            ->where('id', $permission->id)
            ->update(['status' => $newStatus]);
    }
}

echo "All permissions updated successfully!\n";

// Show final result
$finalPermissions = Permission::all();
echo "\nFinal status distribution:\n";
echo "Pending: " . $finalPermissions->where('status', 'pending')->count() . "\n";
echo "Review: " . $finalPermissions->where('status', 'review')->count() . "\n";
echo "Accepted: " . $finalPermissions->where('status', 'accepted')->count() . "\n";
echo "Rejected: " . $finalPermissions->where('status', 'rejected')->count() . "\n";