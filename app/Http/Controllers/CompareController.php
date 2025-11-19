<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CompareController extends Controller
{
    public function toggle(Provider $provider)
    {
        $compareList = Session::get('compare_list', []);
        
        if (in_array($provider->id, $compareList)) {
            // Remove from compare
            $compareList = array_diff($compareList, [$provider->id]);
            Session::put('compare_list', $compareList);
            
            return response()->json([
                'in_compare' => false,
                'message' => 'Provider removed from compare list'
            ]);
        } else {
            // Add to compare (limit to 4 providers)
            if (count($compareList) >= 4) {
                return response()->json([
                    'in_compare' => false,
                    'message' => 'You can only compare up to 4 providers'
                ], 422);
            }
            
            $compareList[] = $provider->id;
            Session::put('compare_list', $compareList);
            
            return response()->json([
                'in_compare' => true,
                'message' => 'Provider added to compare list'
            ]);
        }
    }
    
    public function count()
    {
        $compareList = Session::get('compare_list', []);
        return response()->json(['count' => count($compareList)]);
    }
    
    public function list()
    {
        $compareList = Session::get('compare_list', []);
        $providers = Provider::whereIn('id', $compareList)->get();
        
        return response()->json(['providers' => $providers]);
    }

    /**
     * Show the compare page with providers loaded from session
     */
    public function page()
    {
        $compareList = Session::get('compare_list', []);
        $providers = Provider::whereIn('id', $compareList)->get();

        return view('website.compare-page', compact('providers'));
    }
    
    public function clear()
    {
        Session::forget('compare_list');
        return response()->json(['success' => true, 'message' => 'Compare list cleared']);
    }
}