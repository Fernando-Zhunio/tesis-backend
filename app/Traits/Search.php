<?php

namespace App\Traits;

trait Search
{
    /**
     * @param string $search El nombre que va a buscar por defecto en la columna name
     * @param string $colum_name Especifica la columna a buscar que por defecto es name
     * @param boolean $isOrWhere especifica si contendra la clausula orWhere por defecto false
     * @param array $array El array de orWhere que contendra como llaves la columna y como valor lo que busca
     */
    public function scopeSearch($query, $search, $colum_name = 'name', $array = [])
    {
        if (!empty($search)) {
            $query->where($colum_name, 'LIKE', "%{$search}%");
            if (!empty($array)) {
                foreach ($array as $key => $value) {
                    $query->orWhere($key, 'LIKE', "%{$value}%");
                }
            }
            return $query;
        }
    }
}