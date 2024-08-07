<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    public $incrementing = false; // Disable auto-incrementing ID
    public $timestamps = false; // Disable timestamps if not needed

    protected $primaryKey = ['client_id', 'document']; // Define composite key
    protected $keyType = 'string'; // Set key type if necessary

    protected $fillable = [
        'client_id',
        'document',
        'yes',
        'no',
        'remarks',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Override the setKeysForSaveQuery method to handle composite keys
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        return $this->getAttribute($keyName);
    }
}

class RrcyForm extends Model
{
    use HasFactory;

    public $incrementing = false; // Disable auto-incrementing ID
    public $timestamps = false; // Disable timestamps if not needed

    protected $primaryKey = ['client_id', 'form']; // Define composite key
    protected $keyType = 'string'; // Set key type if necessary

    protected $fillable = [
        'client_id',
        'form',
        'yes',
        'no',
        'remarks',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Override the setKeysForSaveQuery method to handle composite keys
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        return $this->getAttribute($keyName);
    }
}
