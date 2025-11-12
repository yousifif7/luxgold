<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    /**
     * Create a new notification
     */
    public function create(array $data): Notification
    {
        return Notification::create($data);
    }

    /**
     * Send notification to a specific user
     */
    public function sendToUser(User $user, array $data): Notification
    {
        $data['notifiable_type'] = User::class;
        $data['notifiable_id'] = $user->id;
        $data['sent_at'] = now();

        return $this->create($data);
    }

    /**
     * Send notification to a specific provider
     */
    public function sendToProvider(Provider $provider, array $data): Notification
    {
        $data['notifiable_type'] = Provider::class;
        $data['notifiable_id'] = $provider->id;
        $data['sent_at'] = now();

        return $this->create($data);
    }

    /**
     * Send notification to all users with a specific role
     */
    public function sendToRole(string $role, array $data): int
    {
        $data['target_role'] = $role;
        $data['sent_at'] = now();

        $notification = $this->create($data);
        
        // You can also send to specific users with this role if needed
        // This creates a global notification that can be fetched by role

        return 1; // Return count or implement bulk creation
    }

    /**
     * Send global notification (to all users)
     */
    public function sendGlobal(array $data): Notification
    {
        $data['sent_at'] = now();
        // No notifiable_id/type for global notifications

        return $this->create($data);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification): bool
    {
        return $notification->markAsRead();
    }

    /**
     * Mark all notifications as read for a notifiable
     */
    public function markAllAsRead($notifiable): bool
    {
        return $notifiable->notifications()->unread()->update(['read_at' => now()]);
    }

    /**
     * Delete expired notifications
     */
    public function cleanupExpired(): int
    {
        return Notification::where('expires_at', '<', now())->delete();
    }

    /**
     * Get notifications for a notifiable with pagination
     */
    public function getForNotifiable($notifiable, $perPage = 15)
    {
        return $notifiable->notifications()
            ->active()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Create common notification types
     */
    
    // Profile approval notifications
    public function sendProfileApproved(Provider $provider): Notification
    {
        return $this->sendToProvider($provider, [
            'type' => 'success',
            'title' => 'Profile Approved',
            'message' => 'Your provider profile has been approved and is now live on the platform.',
            'action_url' => route('provider.dashboard'),
            'action_text' => 'View Dashboard'
        ]);
    }

    public function sendProfileRejected(Provider $provider, string $reason = null): Notification
    {
        $message = 'Your provider profile requires additional information.';
        if ($reason) {
            $message .= " Reason: {$reason}";
        }

        return $this->sendToProvider($provider, [
            'type' => 'error',
            'title' => 'Profile Requires Updates',
            'message' => $message,
            'action_url' => route('provider.profile.edit'),
            'action_text' => 'Update Profile'
        ]);
    }

    // Subscription notifications
    public function sendSubscriptionExpiring(Provider $provider, int $daysLeft): Notification
    {
        return $this->sendToProvider($provider, [
            'type' => 'warning',
            'title' => 'Subscription Renewal',
            'message' => "Your subscription renews in {$daysLeft} days. Ensure your payment method is up to date.",
            'action_url' => route('provider.subscription'),
            'action_text' => 'Manage Subscription',
            'expires_at' => now()->addDays($daysLeft + 1)
        ]);
    }

    public function sendSubscriptionExpired(Provider $provider): Notification
    {
        return $this->sendToProvider($provider, [
            'type' => 'error',
            'title' => 'Subscription Expired',
            'message' => 'Your subscription has expired. Some features may be limited.',
            'action_url' => route('provider.subscription'),
            'action_text' => 'Renew Now'
        ]);
    }

    // Inquiry notifications
    public function sendNewInquiry(Provider $provider, int $inquiryCount = 1): Notification
    {
        $message = $inquiryCount > 1 
            ? "You have {$inquiryCount} new inquiries." 
            : "You have a new inquiry from a parent.";

        return $this->sendToProvider($provider, [
            'type' => 'info',
            'title' => 'New Inquiry' . ($inquiryCount > 1 ? 's' : ''),
            'message' => $message,
            'action_url' => route('provider.inquiries.index'),
            'action_text' => 'View Inquiries'
        ]);
    }

    // Review notifications
    public function sendNewReview(Provider $provider): Notification
    {
        return $this->sendToProvider($provider, [
            'type' => 'info',
            'title' => 'New Review',
            'message' => 'A parent has left a new review for your service.',
            'action_url' => route('provider.reviews.index'),
            'action_text' => 'View Reviews'
        ]);
    }

    // System/Admin notifications
    public function sendSystemMaintenance(string $message, string $role = null): Notification
    {
        $data = [
            'type' => 'system',
            'title' => 'System Maintenance',
            'message' => $message,
            'expires_at' => now()->addHours(24)
        ];

        if ($role) {
            return $this->sendToRole($role, $data);
        }

        return $this->sendGlobal($data);
    }
}