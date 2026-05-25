<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Lấy tất cả các log, sắp xếp mới nhất lên đầu
        $activities = Activity::with(['causer', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('activity_logs.index', compact('activities'));
    }
}
