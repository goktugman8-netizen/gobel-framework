<?php

namespace Gobel\Database\Concerns;

trait HasRelationships
{
    /**
     * Define a one-to-one relationship.
     *
     * @param string $related
     * @param string $foreignKey
     * @param string $localKey
     * @return mixed
     */
    public function hasOne($related, $foreignKey = null, $localKey = 'id')
    {
        $instance = new $related;
        $foreignKey = $foreignKey ?: strtolower(class_basename($this)) . '_id';

        return $instance->newQuery()
            ->where($foreignKey, '=', $this->getAttribute($localKey))
            ->first();
    }

    /**
     * Define a one-to-many relationship.
     *
     * @param string $related
     * @param string $foreignKey
     * @param string $localKey
     * @return array
     */
    public function hasMany($related, $foreignKey = null, $localKey = 'id')
    {
        $instance = new $related;
        $foreignKey = $foreignKey ?: strtolower(class_basename($this)) . '_id';

        $records = $instance->newQuery()
            ->where($foreignKey, '=', $this->getAttribute($localKey))
            ->get();

        return array_map(function ($record) use ($related) {
            return new $related((array) $record);
        }, $records);
    }
}
