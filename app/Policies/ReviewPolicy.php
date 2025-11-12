<?php
// app/Policies/ReviewPolicy.php
namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{
    public function update(User $user, Review $review)
    {
        return $user->id === $review->user_id
            ? Response::allow()
            : Response::deny('You do not own this review.');
    }

    public function delete(User $user, Review $review)
    {
        return $user->id === $review->user_id
            ? Response::allow()
            : Response::deny('You do not own this review.');
    }
}