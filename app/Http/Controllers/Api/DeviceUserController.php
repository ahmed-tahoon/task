<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DeviceUserController extends Controller
{
    public function registerDevicesByUser(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $devices = $request->input('devices', []);

        $user->devices()->sync($devices);

        return response()->json(['message' => 'Devices registered successfully.']);
    }

    public function getDeviceUsers($device_id)
    {
        $device = Device::findOrFail($device_id);

        $users = $device->users;

        return response()->json(['users' => $users]);
    }

    public function getUserDevices($user_id)
    {
        $user = User::findOrFail($user_id);

        $devices = $user->devices;

        return response()->json(['devices' => $devices]);
    }

}
