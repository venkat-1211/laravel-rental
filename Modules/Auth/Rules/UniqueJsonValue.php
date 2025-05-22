<?php

namespace Modules\Auth\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueJsonValue implements Rule
{
    protected $table;

    protected $jsonColumn;

    protected $jsonPath;

    protected $excludeUserId;

    public function __construct($table, $jsonColumn, $jsonPath, $excludeUserId = null)
    {
        $this->table = $table;
        $this->jsonColumn = $jsonColumn;
        $this->jsonPath = $jsonPath;
        $this->excludeUserId = $excludeUserId;
    }

    public function passes($attribute, $value)
    {
        $query = DB::table($this->table)
            ->whereRaw(
                "JSON_UNQUOTE(JSON_EXTRACT(`{$this->jsonColumn}`, ?)) = ?",
                [$this->jsonPath, $value]
            );

        if ($this->excludeUserId) {
            $query->where('user_id', '!=', $this->excludeUserId);
        }

        return ! $query->exists();
    }

    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
