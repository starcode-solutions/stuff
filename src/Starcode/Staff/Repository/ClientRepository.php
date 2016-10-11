<?php

namespace Starcode\Staff\Repository;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

/**
 * ClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientRepository extends AbstractRepository implements ClientRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->andWhere('c.identifier = :identifier')
            ->setParameter('identifier', $clientIdentifier);

        if ($mustValidateSecret) {
            $qb->andWhere('c.secret = :secret')
                ->setParameter('secret', md5($clientSecret));
        }

        $query = $qb->getQuery();

        return $query->getSingleResult();
    }
}
