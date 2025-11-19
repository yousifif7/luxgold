@php
    // expects $user variable (instance of App\Models\User) or null
    $show = false;
    if (isset($user) && $user) {
        $show = (bool) ($user->is_verified ?? false);
    }
@endphp

@if($show)
    <span class="badge bg-success ms-2" title="Verified user">
        <i class="fas fa-check-circle"></i> Verified
    </span>
@endif
