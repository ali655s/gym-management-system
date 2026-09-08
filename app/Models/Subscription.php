<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'member_id',
        'membership_plan_id',
        'start_date',
        'end_date',
        'status',
        'amount_paid',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'amount_paid' => 'decimal:2',
        ];
    }

    /**
     * The "booted" method of the model.
     * Automatically computes end_date and amount_paid from the membership plan if not set.
     */
    protected static function booted(): void
    {
        static::creating(function (Subscription $subscription) {
            if (empty($subscription->start_date)) {
                $subscription->start_date = Carbon::today()->toDateString();
            }

            $plan = $subscription->membershipPlan ?? MembershipPlan::find($subscription->membership_plan_id);

            if ($plan) {
                if (empty($subscription->end_date)) {
                    $months = $plan->durationInMonths();
                    $subscription->end_date = Carbon::parse($subscription->start_date)->addMonths($months)->toDateString();
                }

                if ($subscription->amount_paid === null || $subscription->amount_paid === '') {
                    $subscription->amount_paid = $plan->price;
                }
            }
        });
    }

    /**
     * Scope a query to only include active subscriptions.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->where('end_date', '>=', Carbon::today()->toDateString());
    }

    /**
     * Scope a query to only include expired subscriptions.
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('status', 'expired')
            ->orWhere(function (Builder $q) {
                $q->where('status', 'active')
                    ->where('end_date', '<', Carbon::today()->toDateString());
            });
    }

    /**
     * Get the member that owns this subscription.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the membership plan for this subscription.
     */
    public function membershipPlan(): BelongsTo
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    /**
     * Renew this subscription according to the renewal business rules:
     * - If the current subscription is still active (not expired), the new period starts from the old end_date.
     * - If it is already expired, the new period starts from today.
     * - The old subscription's status is set to 'expired'.
     * - A new subscription row is created for the new period.
     */
    public function renew(?MembershipPlan $newPlan = null, ?float $amountPaid = null): self
    {
        $plan = $newPlan ?? $this->membershipPlan ?? MembershipPlan::findOrFail($this->membership_plan_id);

        $today = Carbon::today();
        $oldEndDate = Carbon::parse($this->end_date)->startOfDay();

        // Determine if subscription is still active
        $isStillActive = ($this->status === 'active' && $oldEndDate->greaterThanOrEqualTo($today));

        // Starting date: old end_date if active, or today if expired
        $startDate = $isStillActive ? $oldEndDate->toDateString() : $today->toDateString();

        // Expire the current subscription
        $this->update(['status' => 'expired']);

        // Calculate new end_date based on the selected plan duration
        $months = $plan->durationInMonths();
        $endDate = Carbon::parse($startDate)->addMonths($months)->toDateString();

        // Create a new subscription for the new period
        return Subscription::create([
            'member_id' => $this->member_id,
            'membership_plan_id' => $plan->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
            'amount_paid' => $amountPaid ?? $plan->price,
        ]);
    }
}
