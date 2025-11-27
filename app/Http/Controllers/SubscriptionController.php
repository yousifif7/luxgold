<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session as StripeSession;

class SubscriptionController extends Controller
{
    public function checkout($id)
    {

        $plan=Plan::where('id',$id)->first();
        Stripe::setApiKey(config('stripe.secret'));

        // If the plan is free (zero amount), create a local active subscription and skip Stripe
        if ($plan->monthly_fee <= 0) {
            $subscription = Subscription::create([
                'cleaner_id' => Auth::user()->cleaner->id,
                'plan_id' => $plan->id,
                'amount' => 0,
                'currency' => $plan->currency ?? 'USD',
                'status' => 'active',
                'started_at' => now(),
                'is_active' => true,
                'renews_at' => now()->addDays($plan->duration_days ?? 30),
                'meta' => ['plan_id' => $plan->id, 'auto_renew' => false, 'is_free' => true],
            ]);

            // No payment required; redirect to subscription page
            return redirect()->route('cleaner-subscription')->with('success', 'You have been subscribed to the free plan.');
        }

        // Create Stripe recurring subscription checkout session
        
        // Create subscription (pending, awaiting Stripe confirmation)
        $subscription = Subscription::create([
            'cleaner_id' => Auth::user()->cleaner->id,
            'plan_id' => $plan->id,
            'amount' => $plan->monthly_fee,
            'currency' => $plan->currency ?? 'USD',
            'status' => 'pending',
            'started_at' => now(),
            'is_active' => true, // Default to active when created
            'meta' => ['plan_id' => $plan->id, 'auto_renew' => true],
        ]);

        $session = StripeSession::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => $plan->currency ?? 'usd',
                'unit_amount' => (int)($plan->monthly_fee * 100),
                'recurring' => [
                    'interval' => 'month', // 🔁 Auto-renew every month
                ],
                'product_data' => [
                    'name' => $plan->name,
                    'description' => $plan->description ?? 'Monthly subscription plan',
                ],
            ],
            'quantity' => 1,
        ]],
        'mode' => 'subscription', // 🔁 Enables recurring billing
        'success_url' => route('subscriptions.success', ['subscription' => $subscription->id]) . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('subscriptions.cancel-checkout', ['subscription' => $subscription->id]),
    ]);


        // Create initial payment record
        Payment::create([
            'subscription_id' => $subscription->id,
            'cleaner_id' => Auth::user()->cleaner->id,
            'payment_method' => 'stripe',
            'transaction_id' => $session->id,
            'amount' => $plan->monthly_fee,
            'currency' => $plan->currency ?? 'USD',
            'status' => 'pending',
            'meta' => ['checkout_session_url' => $session->url],
        ]);

        return redirect($session->url, 303);
    }

    public function success(Request $request, Plan $plan)
    {
        $sessionId = $request->get('session_id');
        
        // Retrieve payment and update status if needed
        $payment = Payment::where('transaction_id', $sessionId)->first();
        
        if ($payment) {
            $payment->update(['status' => 'completed']);
            
            $subscription = $payment->subscription;

            if ($subscription) {
                
                $subscription->update([
                    'status'=>'active',
                    'is_active' => true,
                     'renews_at' => now()->addMonth(),
                ]);
            }
        }

        return view('subscriptions.success', [
            'payment' => $payment,
            'subscription' => $subscription ?? null
        ]);
    }

    public function cancelCheckout($id)
    {

        $subscription=Subscription::where('id',$id)->first();
        $plan=Plan::where('id',$subscription->plan_id)->first();

        return view('subscriptions.cancel-checkout', ['subscription' => $subscription,'plan'=>$plan]);
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutCompleted($session);
                break;

            case 'invoice.paid':
                $invoice = $event->data->object;
                $this->handleInvoicePaid($invoice);
                break;

            case 'customer.subscription.deleted':
                $subscription = $event->data->object;
                $this->handleSubscriptionCancelled($subscription);
                break;
        }

        return response('Webhook handled', 200);
    }

    protected function handleCheckoutCompleted($session)
    {
        $payment = Payment::where('transaction_id', $session->id)->first();

        if ($payment) {
            $payment->update([
                'status' => 'completed',
                'transaction_id' => $session->subscription ?? $session->payment_intent,
                'paid_at' => now(),
                'meta' => array_merge($payment->meta ?? [], [
                    'stripe_session_id' => $session->id,
                    'stripe_subscription_id' => $session->subscription ?? null,
                ]),
            ]);

            $subscription = $payment->subscription;
            if ($subscription) {
                $subscription->update([
                    'status' => 'active',
                    'is_active' => true,
                    'started_at' => now(),
                    'renews_at' => now()->addMonth(),
                    'meta->stripe_subscription_id' => $session->subscription ?? null,
                ]);
            }
        }
    }

    protected function handleInvoicePaid($invoice)
    {
        $stripeSubscriptionId = $invoice->subscription ?? null;

        if (!$stripeSubscriptionId) return;

        $subscription = Subscription::where('meta->stripe_subscription_id', $stripeSubscriptionId)->first();

        if ($subscription && $subscription->is_active) {
            // Create a new payment record for renewal
            Payment::create([
                'subscription_id' => $subscription->id,
                'cleaner_id' => $subscription->cleaner_id,
                'payment_method' => 'stripe',
                'transaction_id' => $invoice->payment_intent ?? $invoice->id,
                'amount' => ($invoice->amount_paid / 100),
                'currency' => strtoupper($invoice->currency ?? 'USD'),
                'status' => 'completed',
                'paid_at' => now(),
                'meta' => [
                    'invoice_id' => $invoice->id,
                    'stripe_subscription_id' => $stripeSubscriptionId,
                ],
            ]);

            // Extend renewal date
            $subscription->update([
                'renews_at' => now()->addMonth(),
            ]);
        }
    }

    protected function handleSubscriptionCancelled($stripeSubscription)
    {
        $subscription = Subscription::where('meta->stripe_subscription_id', $stripeSubscription->id)->first();

        if ($subscription) {
            $subscription->update([
                'status' => 'cancelled',
                'is_active' => false,
                'cancelled_at' => now(),
                'meta->auto_renew' => false,
            ]);
        }
    }

    /**
     * Cancel subscription (stop auto-renewal)
     */
    public function cancel(Subscription $subscription)
    {
        // Check if user owns this subscription
        $cleanerId = auth()->user()->cleaner->id ?? null;
        if ($subscription->cleaner_id !== $cleanerId) {
            abort(403, 'Unauthorized action.');
        }

        Stripe::setApiKey(config('stripe.secret'));

        $stripeSubscriptionId = $subscription->meta['stripe_subscription_id'] ?? null;

        if ($stripeSubscriptionId) {
            try {
                $stripeSub = \Stripe\Subscription::retrieve($stripeSubscriptionId);
                $stripeSub->cancel();
            } catch (\Exception $e) {
                // Log error but continue with local cancellation
                \Log::error('Stripe cancellation failed: ' . $e->getMessage());
            }
        }

        $subscription->update([
            'status' => 'cancelled',
            'is_active' => false,
            'cancelled_at' => now(),
            'meta->auto_renew' => false,
        ]);

        return redirect()->back()->with('success', 'Subscription cancelled successfully. Auto-renew has been disabled.');
    }

    /**
     * Enable subscription (re-activate)
     */
    public function enable(Subscription $subscription)
    {
        // Check if user owns this subscription
        $cleanerId = auth()->user()->cleaner->id ?? null;
        if ($subscription->cleaner_id !== $cleanerId) {
            abort(403, 'Unauthorized action.');
        }

        Stripe::setApiKey(config('stripe.secret'));

        $stripeSubscriptionId = $subscription->meta['stripe_subscription_id'] ?? null;

        if ($stripeSubscriptionId) {
            try {
                // Reactivate in Stripe
                $stripeSub = \Stripe\Subscription::retrieve($stripeSubscriptionId);
                
                // If subscription is cancelled in Stripe, we need to create a new one
                if ($stripeSub->status === 'canceled') {
                    // Create new Stripe subscription
                    $plan = Plan::find($subscription->meta['plan_id'] ?? null);
                    
                    if ($plan) {
                        $newStripeSubscription = \Stripe\Subscription::create([
                            'customer' => $stripeSub->customer,
                            'items' => [[
                                'price_data' => [
                                    'currency' => $plan->currency ?? 'usd',
                                    'product_data' => ['name' => $plan->title],
                                    'unit_amount' => (int)($plan->price * 100),
                                    'recurring' => ['interval' => 'month'],
                                ],
                            ]],
                        ]);

                        $stripeSubscriptionId = $newStripeSubscription->id;
                    }
                } else {
                    // Update existing subscription to resume
                    \Stripe\Subscription::update($stripeSubscriptionId, [
                        'cancel_at_period_end' => false,
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('Stripe enable failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to enable subscription. Please try again.');
            }
        }

        $subscription->update([
            'status' => 'active',
            'is_active' => true,
            'cancelled_at' => null,
            'meta->auto_renew' => true,
            'meta->stripe_subscription_id' => $stripeSubscriptionId ?? $subscription->meta['stripe_subscription_id'],
        ]);

        return redirect()->back()->with('success', 'Subscription enabled successfully. Auto-renew has been activated.');
    }

    /**
     * Disable subscription (pause without cancelling)
     */
    public function disable(Subscription $subscription)
    {
        // Check if user owns this subscription
        $cleanerId = auth()->user()->cleaner->id ?? null;
        if ($subscription->cleaner_id !== $cleanerId) {
            abort(403, 'Unauthorized action.');
        }

        Stripe::setApiKey(config('stripe.secret'));

        $stripeSubscriptionId = $subscription->meta['stripe_subscription_id'] ?? null;

        if ($stripeSubscriptionId) {
            try {
                // Set subscription to cancel at period end instead of immediate cancellation
                \Stripe\Subscription::update($stripeSubscriptionId, [
                    'cancel_at_period_end' => true,
                ]);
            } catch (\Exception $e) {
                \Log::error('Stripe disable failed: ' . $e->getMessage());
            }
        }

        $subscription->update([
            'status' => 'paused',
            'is_active' => false,
            'meta->auto_renew' => false,
        ]);

        return redirect()->back()->with('success', 'Subscription disabled successfully. It will not auto-renew.');
    }

    /**
     * List user's subscriptions
     */
    public function index()
    {
        $cleanerId = auth()->user()->cleaner->id ?? null;
        $subscriptions = Subscription::where('cleaner_id', $cleanerId)
            ->with('payments')
            ->latest()
            ->paginate(10);

        return view('subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show subscription details
     */
    public function show(Subscription $subscription)
    {
        // Check if user owns this subscription
        $cleanerId = auth()->user()->cleaner->id ?? null;
        if ($subscription->cleaner_id !== $cleanerId) {
            abort(403, 'Unauthorized action.');
        }

        $subscription->load('payments');

        return view('subscriptions.show', compact('subscription'));
    }
}