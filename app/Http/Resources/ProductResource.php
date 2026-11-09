<?php

namespace App\Http\Resources;

use App\DTOs\ProductDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ProductDTO
 */
class ProductResource extends JsonResource
{
    /**
     * @var ProductDTO
     */
    public $resource;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'price' => $this->resource->price,
            'description' => $this->resource->description,
            'category' => $this->resource->category,
            'image' => $this->resource->image,
            'rating' => $this->resource->rating,
        ];
    }
}
