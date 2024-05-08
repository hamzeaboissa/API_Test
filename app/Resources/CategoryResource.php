<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request;

class CategoryResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        $array = [
            'id' => $this->id,
            'name' => $this->name,
        ];
        if (Request::isMethod('get')) {
            $array['createdFrom'] = 'created from: ' . Carbon::now()->diffInHours($this->created_at) . ' hours ago';
        }
        return $array;
    }
}
