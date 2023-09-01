<?php

namespace App\Http\Resources;

use App\Http\Resources\customers\CustomerUnfineshedOperation;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->collection->map(function ($value, $key) {

            return [
               'id' => $this->id,
               'name'=> $this->name,
               'email'=> $this->email,
               'class_rooms' => [],
               'subjects' => []
            ];
        });
        return $data->toArray();
    }
}
