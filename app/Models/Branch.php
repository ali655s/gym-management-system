<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'city',
        'address',
        'phone',
        'map_link',
        'image',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include active branches.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the membership plans available at this branch.
     */
    public function membershipPlans(): HasMany
    {
        return $this->hasMany(MembershipPlan::class);
    }

    /**
     * Get the gym classes scheduled at this branch.
     */
    public function gymClasses(): HasMany
    {
        return $this->hasMany(GymClass::class);
    }

    /**
     * Get the members assigned to this branch.
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get the display image URL for the branch.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }

        $defaultImages = [
            'Downtown Flagship' => 'https://images.unsplash.com/photo-1540497077202-7c8a3999166f?auto=format&fit=crop&w=800&q=80',
            'Seaside Arena' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&q=80',
            'Oasis Health Club' => 'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?auto=format&fit=crop&w=800&q=80',
        ];

        return $defaultImages[$this->name] ?? 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&q=80';
    }
}
