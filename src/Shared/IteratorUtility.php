<?php

namespace App\Shared;

use Doctrine\Common\Collections\Collection;

class IteratorUtility
{
    /* @phpstan-ignore missingType.iterableValue */
    public static function iterator_add(iterable &$iterator, mixed $value): void
    {
        if (is_array($iterator)) {
            $iterator[] = $value;
        } elseif ($iterator instanceof Collection) {
            $iterator->add($value);
        }
    }

    /**
     * @phpstan-template T of mixed
     *
     * @param iterable<T> $iterator
     *
     * @return T
     */
    public static function iterator_last(iterable $iterator): mixed
    {
        return iterator_to_array($iterator)[iterator_count($iterator) - 1];
    }
}
