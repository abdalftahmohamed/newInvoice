<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'email', 'phone', 'address','status','logo'];

    public function scopeActive($query)
    {
        return $query->where('status' , 1);
    }
    public function getStatusNameAttribute($value)
    {//$value is status_name
        if ($this->status == 1) {
            return trans('dashboard.active');
        } else {
            return trans('dashboard.unactive');
        }
    }
    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y h:i A', strtotime($value));
    }

    public function getLogoAttribute($logo)
    {
        if (filter_var($logo, FILTER_VALIDATE_URL)) {
            return $logo; // Return the image URL if valid
        }
        return 'uploads/clients/' . $logo;
    }


    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
