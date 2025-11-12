@include(Auth::user()->hasRole('admin') ? 'layouts.admin' : 'layouts.provider-layout')
