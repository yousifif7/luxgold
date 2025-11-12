<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    public function index(Request $request)
    {
    $query = User::role('parent')->orderBy('email');

        if($request->filled('q')){
            $query->where(function($q){
                $t = request('q');
                $q->where('first_name','like','%'.$t.'%')->orWhere('email','like','%'.$t.'%');
            });
        }
        if($request->filled('status')){
            $query->where('status', $request->get('status'));
        }
        if($request->filled('city')){
            $query->where('city','like','%'.$request->get('city').'%');
        }

    $users = $query->get();

        // simple totals for the page
        $totalOnPage = $users->count();

        return view('admin.parents.index', compact('users','totalOnPage'));
    }

    public function create()
    {
        return view('admin.parents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:6|confirmed',
            'city'=>'nullable|string|max:255',
            'status'=>'nullable|string|in:active,inactive,pending',
        ]);
        $data['role'] = 'parent';
        $data['password'] = Hash::make($data['password']);
       $user= User::create($data);

         $user->assignRole('parent');
         return handleResponse($request, 'Parent created successfully!', 'admin.parents.index');
    }

    public function edit($id)
    {
        $user=User::where('id',$id)->first();
        return view('admin.parents.edit', compact('user'));
    }

    public function show(User $user)
    {
        $subscriptions = Subscription::with('service')->where('parent_id', $user->id)->orderByDesc('created_at')->get();
        $services = Service::orderBy('title')->get();
        return view('admin.parents.show', compact('parent','subscriptions','services'));
    }

    public function update(Request $request, $id)
    {
          $user=User::where('id',$id)->first();
        $data = $request->validate([
             'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'password'=>'nullable|string|min:6|confirmed',
            'city'=>'nullable|string|max:255',
            'status'=>'nullable|string|in:active,inactive,pending',
        ]);
        if(!empty($data['password'])){ $data['password'] = Hash::make($data['password']); } else { unset($data['password']); }
        $user->update($data);

           return handleResponse($request, 'Parent updated successfully!', 'admin.parents.index');
    }

    public function destroy(User $user)
    {
        // delete subscriptions for this parent first
        Subscription::where('parent_id', $user->id)->delete();
        $user->delete();
        return redirect()->route('admin.parents.index')->with('success','Parent deleted');
    }

    /**
     * Create a subscription on behalf of a parent (admin action)
     */
    public function storeSubscription(Request $request, User $user)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'amount' => 'required|numeric',
        ]);

        Subscription::create([
            'parent_id' => $user->id,
            'service_id' => $data['service_id'],
            'amount' => $data['amount'],
            'currency' => Service::find($data['service_id'])->currency ?? 'USD',
            'status' => 'active',
        ]);

        return redirect()->route('admin.parents.show', $user->id)->with('success','Subscription created');
    }
}
