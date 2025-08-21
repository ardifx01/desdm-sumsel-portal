<?php

namespace App\Models\Traits;

trait CleansHtml
{
    /**
     * Boot the trait.
     * Secara otomatis membersihkan field HTML saat model disimpan.
     */
    protected static function bootCleansHtml()
    {
        static::saving(function ($model) {
            // Ambil daftar field yang perlu dibersihkan dari properti di model
            $fieldsToClean = $model->htmlFieldsToClean ?? [];

            foreach ($fieldsToClean as $field) {
                if (isset($model->attributes[$field])) {
                    // Gunakan fungsi clean() dari Purifier
                    $model->attributes[$field] = clean($model->attributes[$field]);
                }
            }
        });
    }
}
