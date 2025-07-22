<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'container_count',
        'pin',
    ];

    /**
     * Get the containers for the customer
     */
    public function containers()
    {
        return $this->hasMany(Container::class);
    }

    /**
     * Update container count when containers are added/removed
     */
    public function updateContainerCount()
    {
        $this->container_count = $this->containers()->count();
        $this->save();
    }
}
