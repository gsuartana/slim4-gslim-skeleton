<?php

namespace Gslim\App\Services;

use Gslim\App\Entity\MasterToken;
use Gslim\App\Repository\MasterTokenRepository;
use Gslim\App\Services\BaseServices;

/**
 * Class YasMasterTokenService
 * @package Gslim\App\Services
 */
class MasterTokenService extends BaseServices
{

    /**
     * Provide Yas Master token data
     *
     * @return mixed
     */
    public function getAll()
    {
        return BaseServices::entityManagers()
            ->getRepository(MasterToken::class)
            ->findByField(20);
    }
}