<?php

namespace App\DTOs;

readonly class ProductDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public float $price,
        public string $description,
        public string $category,
        public string $image,
        public ?float $rating = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $rating = null;
        if (isset($data['rating']['rate'])) {
            $rating = (float) $data['rating']['rate'];
        } elseif (isset($data['rating']) && is_numeric($data['rating'])) {
            $rating = (float) $data['rating'];
        }

        return new self(
            id: (int) $data['id'],
            title: (string) $data['title'],
            price: (float) $data['price'],
            description: (string) $data['description'],
            category: (string) $data['category'],
            image: (string) $data['image'],
            rating: $rating,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'category' => $this->category,
            'image' => $this->image,
            'rating' => $this->rating,
        ];
    }
}
