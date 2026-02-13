<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;



class SuperAdminController extends Controller
{
    // 🔹 Get All Owners List
    public function ownerList()
    {
        $owners = Owner::select(
            'id',
            'name as owner_name',
            'gym_name',
            'mobile',
            'email',
            'subscription_status'
        )->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Owner list fetched successfully',
            'data' => $owners
        ]);
    }

    // 🔹 View Single Owner
    public function viewOwner($id)
    {
        $owner = Owner::find($id);

        if (!$owner) {
            return response()->json([
                'status' => false,
                'message' => 'Owner not found'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $owner
        ]);
    }

    // 🔹 Update Subscription Status
    public function updateSubscription(Request $request, $id)
    {
        $owner = Owner::find($id);

        if (!$owner) {
            return response()->json([
                'status' => false,
                'message' => 'Owner not found'
            ]);
        }

        $request->validate([
            'subscription_status' => 'required|in:active,expired,trial'
        ]);

        $owner->subscription_status = $request->subscription_status;
        $owner->save();

        return response()->json([
            'status' => true,
            'message' => 'Subscription updated successfully'
        ]);
    }

    // 🔹 Delete Owner
    public function deleteOwner($id)
    {
        $owner = Owner::find($id);

        if (!$owner) {
            return response()->json([
                'status' => false,
                'message' => 'Owner not found'
            ]);
        }

        $owner->delete();

        return response()->json([
            'status' => true,
            'message' => 'Owner deleted successfully'
        ]);
    }
}