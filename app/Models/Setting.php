<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'title_pa',
        'title_en',
        'phone1',
        'phone2',
        'image_path',
        'address',
        'bill_text',
        'user_id'
    ];

    public function imagePath()
    {
        $path = $this->image_path;

        if ($path) {
            $path = explode('public/', $path);
            $path = 'storage/' . $path[1];
        }
        return url($path);
    }
}
