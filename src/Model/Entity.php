<?php

namespace GermanoZambelli\Hassio\Model;

class Entity
{
    /**
     * @var string
     */
    private $friendlyName;

    /**
     * @var string
     */
    private $entityId;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $attributes;

    /**
     * Entity constructor.
     * @param string $domain
     * @param string $entityId
     * @param string $friendlyName
     * @param null|\stdClass $attributes
     */
    public function __construct(string $domain, string $entityId, string $friendlyName, ?\stdClass $attributes = null)
    {
        $this->friendlyName = $friendlyName;
        $this->entityId = $entityId;
        $this->domain = $domain;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getFriendlyName(): string
    {
        return $this->friendlyName;
    }

    /**
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return \stdClass
     */
    public function getAttributes(): \stdClass
    {
        return $this->attributes;
    }

    /**
     * @param string $friendlyName
     */
    public function setFriendlyName(string $friendlyName): void
    {
        $this->friendlyName = $friendlyName;
    }

    /**
     * @param string $entityId
     */
    public function setEntityId(string $entityId): void
    {
        $this->entityId = $entityId;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @param \stdClass $attributes
     */
    public function setAttributes(\stdClass $attributes): void
    {
        $this->attributes = $attributes;
    }
}