<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'iUserId';
    public $timestamps = false;
    protected $fillable = ['iUserId','iRoleId','vFirstName', 'vLastName', 'vEmail', 'vPassword', 'vImage', 'vPhone', 'dBirthDate','eGender','vImage','iImmigrationStatusId','vAddress1','vAddress2','vAddress3','eAddressCheck','vCity','vZipCode','vState','vPostalAddress','vPostCode','vPTD','vAuthCode','iLoginCount','dtLastLogin','eStatus','dtAddedDate','dtUpdatedDate'];
}
