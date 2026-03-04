<?php

namespace Gobel\Http\Resources;

use JsonSerializable;

abstract class JsonResource implements JsonSerializable
{
    /**
     * The resource instance.
     *
     * @var mixed
     */
    protected $resource;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * Create a new anonymous resource collection.
     *
     * @param mixed $resource
     * @return array
     */
    public static function collection($resource)
    {
        return array_map(function ($item) {
            return (new static($item))->toArray();
        }, $resource->all());
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
