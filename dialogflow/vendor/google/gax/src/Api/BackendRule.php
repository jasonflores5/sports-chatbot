<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/backend.proto

namespace Google\Api;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A backend rule provides configuration for an individual API element.
 *
 * Generated from protobuf message <code>google.api.BackendRule</code>
 */
class BackendRule extends \Google\Protobuf\Internal\Message
{
    /**
     * Selects the methods to which this rule applies.
     * Refer to [selector][google.api.DocumentationRule.selector] for syntax details.
     *
     * Generated from protobuf field <code>string selector = 1;</code>
     */
    private $selector = '';
    /**
     * The address of the API backend.
     *
     * Generated from protobuf field <code>string address = 2;</code>
     */
    private $address = '';
    /**
     * The number of seconds to wait for a response from a request.  The
     * default depends on the deployment context.
     *
     * Generated from protobuf field <code>double deadline = 3;</code>
     */
    private $deadline = 0.0;

    public function __construct() {
        \GPBMetadata\Google\Api\Backend::initOnce();
        parent::__construct();
    }

    /**
     * Selects the methods to which this rule applies.
     * Refer to [selector][google.api.DocumentationRule.selector] for syntax details.
     *
     * Generated from protobuf field <code>string selector = 1;</code>
     * @return string
     */
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * Selects the methods to which this rule applies.
     * Refer to [selector][google.api.DocumentationRule.selector] for syntax details.
     *
     * Generated from protobuf field <code>string selector = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setSelector($var)
    {
        GPBUtil::checkString($var, True);
        $this->selector = $var;

        return $this;
    }

    /**
     * The address of the API backend.
     *
     * Generated from protobuf field <code>string address = 2;</code>
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * The address of the API backend.
     *
     * Generated from protobuf field <code>string address = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setAddress($var)
    {
        GPBUtil::checkString($var, True);
        $this->address = $var;

        return $this;
    }

    /**
     * The number of seconds to wait for a response from a request.  The
     * default depends on the deployment context.
     *
     * Generated from protobuf field <code>double deadline = 3;</code>
     * @return float
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * The number of seconds to wait for a response from a request.  The
     * default depends on the deployment context.
     *
     * Generated from protobuf field <code>double deadline = 3;</code>
     * @param float $var
     * @return $this
     */
    public function setDeadline($var)
    {
        GPBUtil::checkDouble($var);
        $this->deadline = $var;

        return $this;
    }

}

