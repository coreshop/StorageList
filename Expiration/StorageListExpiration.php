<?php

declare(strict_types=1);

/*
 * CoreShop
 *
 * This source file is available under two different licenses:
 *  - GNU General Public License version 3 (GPLv3)
 *  - CoreShop Commercial License (CCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 *
 */

namespace CoreShop\Component\StorageList\Expiration;

use CoreShop\Component\StorageList\Repository\ExpireAbleStorageListRepositoryInterface;

final class StorageListExpiration implements StorageListExpirationInterface
{
    public function __construct(
        private ExpireAbleStorageListRepositoryInterface $repository,
    ) {
    }

    public function expire(int $days, array $params = []): void
    {
        if ($days <= 0) {
            return;
        }

        $lists = $this->repository->findExpiredStorageLists($days, $params);

        foreach ($lists as $list) {
            $list->delete();
        }
    }
}
