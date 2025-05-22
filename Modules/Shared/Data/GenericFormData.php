<?php

namespace Modules\Shared\Data;

use Modules\Shared\Http\Requests\BaseFormRequest;

class GenericFormData
{
    /**
     * The attributes stored.
     *
     * @var array<string, mixed>
     */
    protected array $attributes = [];

    /**
     * Constructor.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Create from a validated BaseFormRequest.
     *
     * @return static
     */
    public static function fromRequest(BaseFormRequest $request, array $fields = [], array $extra = []): self
    {
        return new static(array_merge($request->safeData($fields), $extra));
    }

    /**
     * Create from a plain array.
     *
     * @return static
     */
    public static function fromArray(array $data): self
    {
        return new static($data);
    }

    /**
     * Get a value by key.
     *
     * @return mixed|null
     */
    public function get(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Get all attributes.
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->attributes;
    }

    /**
     * Get only specific keys.
     *
     * @return array<string, mixed>
     */
    public function only(array $keys): array
    {
        return array_intersect_key($this->attributes, array_flip($keys));
    }

    /**
     * Get all except specific keys.
     *
     * @return array<string, mixed>
     */
    public function except(array $keys): array
    {
        return array_diff_key($this->attributes, array_flip($keys));
    }

    public function amenitiesAsInt(): array    // Amenities pivot table Sync issue solved function, this function is ids are convert to [1,2,3]
    {
        return array_map('intval', $this->get('amenities', []) ?? []);
    }
}
