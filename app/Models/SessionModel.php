<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SessionModel extends Model
{
    protected $table = 'sessions';
    protected $guarded = [];
    public $timestamps = false;

    /**
     * @param string $sessionID
     * @return string|null
     */
    public static function getLanguageById(string $sessionID): ?string
    {
        return DB::table('sessions')->where('id', $sessionID)->value('language');
    }

    /**
     * @param string $language
     * @param string $sessionID
     * @return string
     */
    public static function setLanguage(string $language, string $sessionID): string
    {
        DB::table('sessions')->where('id', $sessionID)->update(['language' => $language]);

        return $language;
    }
}
