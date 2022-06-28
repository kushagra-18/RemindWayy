<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder extends Model
{
    use SoftDeletes;
    protected $table = 'reminders';

    protected $fillable = ['user_id','title', 'date', 'time', 'description'];

    /**
     * This function is used to save the reminder.
     */
    
    public function saveReminder($userId, $data){
       
        $reminder = $this->create([
            'user_id' => $userId,
            'title' => $data['title'],
            'date' => $data['date'],
            'time' => $data['time'],
            'description' => $data['description']
        ]);
        
        return $reminder;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
