<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Provider;

class InquiryController extends Controller
{
    
    public function index(Request $request)
    {
        $inquiries = Inquiry::with('provider')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

              $providers = Provider::where('status', 'active')->get();

        return view('admin.messages.index', compact('inquiries','providers'));
    }
}
