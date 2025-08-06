<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuditLogController extends Controller
{
    public function index(Request $request)
        {
             $query = \OwenIt\Auditing\Models\Audit::with('user')->latest();

                // Only show "updated" logs
                $query->where('event', 'updated');

                // Date filter
                if ($request->filled('from_date') && $request->filled('to_date')) {
                    $query->whereBetween('created_at', [
                        $request->from_date . ' 00:00:00',
                        $request->to_date . ' 23:59:59'
                    ]);
                }

                // Model filter
                if ($request->filled('model')) {
                    $query->where('auditable_type', $request->model);
                }

                // Event filter (optional)
                if ($request->filled('event')) {
                    $query->where('event', $request->event);
                }

                // Model list for dropdown
                $modelTypes = \OwenIt\Auditing\Models\Audit::select('auditable_type')->distinct()->pluck('auditable_type');

                // ✅ Get limit value or use default
                $limit = $request->input('limit', 20);
                $logs = $limit === 'all' ? $query->get() : $query->paginate($limit)->appends($request->all());


            $page_name = 'Audit Log';

            return view('backend.audit.index', compact('logs', 'modelTypes','limit'));
        }
}
