<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailConfig extends Model
{
    protected $table = 'mail_config';
    protected $guarded = ['id','code'];
    protected $fillable = ['title','subject','body'];
}
