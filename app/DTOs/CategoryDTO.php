<?php

namespace App\DTOs;

readonly class CategoryDTO
{
    public function __construct(
        public string $slug,
        public string $name,
    ) {}

    public static function fromSlug(string $slug): self
    {
        return new self(
            slug: $slug,
            name: ucwords(str_replace(['-', '_'], ' ', $slug)),
        );
    }

    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
        ];
    }
}
