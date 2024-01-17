<?php
namespace Vendor\Module\Api\Data;

interface ViewInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_ID            = 'entity_id';
    const URL                 = 'url';
    const COUNT               = 'count';
    public function logAttemptedUrl($url);
    public function getUrl();

    public function getCount();

    public function getId();


    public function setUrl($url);

    public function setCount($count);

    public function setId($id);
}