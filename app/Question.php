<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'body'];
    //Define relationships 
    public function user() 
    {//A question will belong to the creator/author
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value){
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
        
    }
//Accessor
    public function getUrlAttribute(){
        return route('questions.show',$this->id);
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute(){
        if($this->answers > 0){
            if($this->best_answer_id){
                return 'answered-accepted';
            }
            return 'answered';
        }
        return 'unanswered';
    }
}
