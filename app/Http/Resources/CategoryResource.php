<?php

namespace App\Http\Resources;

use App\DTOs\CategoryDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CategoryDTO
 */
class CategoryResource extends JsonResource
{
    /**
     * @var CategoryDTO
     */
    public $resource;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->resource->slug,
            'name' => $this->resource->name,
        ];
    }
}
