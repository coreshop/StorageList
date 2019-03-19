<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2019 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

namespace CoreShop\Component\StorageList;

use CoreShop\Component\StorageList\Model\StorageListInterface;
use CoreShop\Component\StorageList\Model\StorageListItemInterface;

class SimpleStorageListModifier implements StorageListModifierInterface
{
    /**
     * @var StorageListItemQuantityModifierInterface
     */
    protected $storageListItemQuantityModifier;

    public function __construct()
    {
        $this->storageListItemQuantityModifier = new StorageListItemQuantityModifier();
    }

    /**
     * {@inheritdoc}
     */
    public function addToList(StorageListInterface $storageList, StorageListItemInterface $item)
    {
        return $this->resolveItem($storageList, $item);
    }

    /**
     * {@inheritdoc}
     */
    public function removeFromList(StorageListInterface $storageList, StorageListItemInterface $item)
    {
        $storageList->removeItem($item);
    }

    /**
     * @param StorageListInterface     $storageList
     * @param StorageListItemInterface $storageListItem
     */
    private function resolveItem(StorageListInterface $storageList, StorageListItemInterface $storageListItem)
    {
        foreach ($storageList->getItems() as $item) {
            if ($storageListItem->equals($item)) {
                $this->storageListItemQuantityModifier->modify(
                    $item,
                    $item->getQuantity() + $storageListItem->getQuantity()
                );

                return;
            }
        }

        $storageList->addItem($storageListItem);
    }
}
