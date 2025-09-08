<?php
/**
 * ====================================================================================
 *                           GemFramework (c) GemPixel
 * ----------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework owned by GemPixel Inc as such
 *  distribution or modification of this framework is not allowed before prior consent
 *  from GemPixel administrators. If you find that this framework is packaged in a
 *  software not distributed by GemPixel or authorized parties, you must not use this
 *  software and contact GemPixel at https://gempixel.com/contact to inform them of this
 *  misuse otherwise you risk of being prosecuted in courts.
 * ====================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (http://gempixel.com)
 * @copyright 2023 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com
 * @since 1.0
 */
namespace Core;

use ArrayObject;
Use Closure;

/**
 * public __construct(array|object $array = [], int $flags = 0, string $iteratorClass = ArrayIterator::class)
 * public append(mixed $value): void
 * public asort(int $flags = SORT_REGULAR): true
 * public count(): int
 * public exchangeArray(array|object $array): array
 * public getArrayCopy(): array
 * public getFlags(): int
 * public getIterator(): Iterator
 * public getIteratorClass(): string
 * public ksort(int $flags = SORT_REGULAR): true
 * public natcasesort(): true
 * public natsort(): true
 * public offsetExists(mixed $key): bool
 * public offsetGet(mixed $key): mixed
 * public offsetSet(mixed $key, mixed $value): void
 * public offsetUnset(mixed $key): void
 * public serialize(): string
 * public setFlags(int $flags): void
 * public setIteratorClass(string $iteratorClass): void
 * public uasort(callable $callback): true
 * public uksort(callable $callback): true
 * public unserialize(string $data): void
 */

final class Collection extends ArrayObject {
    /**
     * Array Items
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     */
    private $items = [];
    /**
     * Create collection
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param mixed $items
     */
    public function __construct($items){
        parent::__construct($items);
        $this->items = $items;
    }
    /**
     * Collect Statically
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param array $items
     * @return void
     */
    public static function with($items){
        return new self($items);
    }
    /**
     * Return Items
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @return void
     */
    public function all(){
        return $this->items;
    }
    /**
     * Limit Array Range
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param int $limit
     * @return void
     */
    public function limit(int $limit){
        return array_slice($this->items, 1, $limit);
    }
    /**
     * Return a range
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param int $from
     * @param int $to
     * @return void
     */
    public function range(int $from, int $to){
        return array_slice($this->items, $from, $to);
    }
    /**
     * Set value
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param [type] $key
     * @param [type] $value
     * @return void
     */
    public function set(mixed $key, mixed $value){
        $this->offsetSet($key, $value);
        return $this;
    }
    /**
     * Get value
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param mixed $key
     * @return void
     */
    public function get(mixed $key){
        if($this->offsetExists($key)) {
            return $this->offsetGet($key);
        }
        return null;
    }
    /**
     * Remove Key
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param mixed $key
     * @return void
     */
    public function remove(mixed $key){
        $this->offsetUnset($key);
        return $this;
    }
    /**
     * Map Collection
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param \Closure $fn
     * @return void
     */
    public function map(Closure $fn){
        $result = [];
        foreach ($this->items as $item) {
          $result[] = $fn($item);
        }
        return $result;
    }
    /**
     * Flatten Array
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @return void
     */
    public function flatten(){
        $items = [];
        foreach($this->items as $key => $item){
            $items[$key] = $item instanceof \Core\Support\ORM ? $item->asArray() : $item;
        }
        return $items;
    }

    /**
     * Convert Array / Object to JSON
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param mixed $data
     * @return void
     */
    public function toJson(){
        return json_encode($this->items);
    }
    /**
     * Split array into chunks
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param integer $num
     * @return void
     */
    public function chunk(int $num){
        return array_chunk($this->items, $items, true);
    }
    /**
     * Collapse array into a single array
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @return void
     */
    public function collapse(){
        return call_user_func_array('array_merge', $this->items);
    }
}