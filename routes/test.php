<?php

use Illuminate\Support\Facades\Route;
use App\Models\Permission;

Route::get('/test-permission-update/{id}', function($id) {
    $permission = Permission::findOrFail($id);
    
    echo "Before update: " . $permission->status . "\n";
    
    $result = $permission->update(['status' => 'accepted']);
    
    echo "Update result: " . ($result ? 'true' : 'false') . "\n";
    
    $permission->refresh();
    
    echo "After update: " . $permission->status . "\n";
    
    return response()->json([
        'success' => true,
        'before' => 'pending',
        'after' => $permission->status,
        'update_result' => $result
    ]);
});