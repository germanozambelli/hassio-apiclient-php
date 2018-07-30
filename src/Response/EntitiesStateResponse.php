<?php

namespace GermanoZambelli\Hassio\Response;

use GermanoZambelli\Hassio\Model\Entity;

class EntitiesStateResponse extends SimpleResponse
{
    /**
     * EntitiesStateResponse constructor.
     * @param int $statusCode
     * @param string $message
     */
    public function __construct(int $statusCode, string $message)
    {
        parent::__construct($statusCode, $message);
    }

    /**
     * @param array|null $domains
     * @return array
     */
    public function getEntitiesByDomains(?array $domains): array
    {
        $decodedMessage = json_decode(parent::getMessage());
        $entities = [];
        foreach ($decodedMessage as $entity) {
            $domain = explode(".", $entity->entity_id)[0];
            if(in_array($domain, $domains) || !$domains)
                $entities[] = new Entity($domain, $entity->entity_id, (($entity->attributes->friendly_name) ?? null), $entity->attributes);
        }
        return $entities;
    }

    /**
     * @return array
     */
    public function getEntities(): array
    {
        return $this->getEntitiesByDomains([]);
    }
}