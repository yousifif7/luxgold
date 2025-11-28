<?php

namespace App\Services;

use App\Models\User;
use App\Models\Cleaner;
use App\Models\Notification;
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
     * Send notification to a specific cleaner
     */
    public function sendToProvider(Cleaner $cleaner, array $data): Notification
    {
        $data['notifiable_type'] = Cleaner::class;
        $data['notifiable_id'] = $cleaner->id;
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
    public function sendProfileApproved(Cleaner $cleaner): Notification
    {
        return $this->sendToProvider($cleaner, [
            'type' => 'success',
            'title' => 'Profile Approved',
            'message' => 'Your cleaner profile has been approved and is now live on the platform.',
            'action_url' => route('cleaner-home'),
            'action_text' => 'View Dashboard'
        ]);
    }

    public function sendProfileRejected(Cleaner $cleaner, string $reason = null): Notification
    {
        $message = 'Your provider profile requires additional information.';
        if ($reason) {
            $message .= " Reason: {$reason}";
        }

        return $this->sendToProvider($cleaner, [
            'type' => 'error',
            'title' => 'Profile Requires Updates',
            'message' => $message,
            'action_url' => route('cleaner-profile'),
            'action_text' => 'Update Profile'
        ]);
    }

    // Subscription notifications
    public function sendSubscriptionExpiring(Cleaner $cleaner, int $daysLeft): Notification
    {
        return $this->sendToProvider($cleaner, [
            'type' => 'warning',
            'title' => 'Subscription Renewal',
            'message' => "Your subscription renews in {$daysLeft} days. Ensure your payment method is up to date.",
            'action_url' => route('cleaner-subscription'),
            'action_text' => 'Manage Subscription',
            'expires_at' => now()->addDays($daysLeft + 1)
        ]);
    }

    public function sendSubscriptionExpired(Cleaner $cleaner): Notification
    {
        return $this->sendToProvider($cleaner, [
            'type' => 'error',
            'title' => 'Subscription Expired',
            'message' => 'Your subscription has expired. Some features may be limited.',
            'action_url' => route('cleaner-subscription'),
            'action_text' => 'Renew Now'
        ]);
    }

    // Inquiry notifications
    public function sendNewInquiry(Cleaner $cleaner, int $inquiryCount = 1): Notification
    {
        $message = $inquiryCount > 1 
            ? "You have {$inquiryCount} new inquiries." 
            : "You have a new inquiry from a parent.";

        return $this->sendToProvider($cleaner, [
            'type' => 'info',
            'title' => 'New Inquiry' . ($inquiryCount > 1 ? 's' : ''),
            'message' => $message,
            'action_url' => route('cleaner-inquiries'),
            'action_text' => 'View Inquiries'
        ]);
    }

    // Review notifications
    public function sendNewReview(Cleaner $cleaner): Notification
    {
        return $this->sendToProvider($cleaner, [
            'type' => 'info',
            'title' => 'New Review',
            'message' => 'A parent has left a new review for your service.',
            'action_url' => route('cleaner-home'),
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