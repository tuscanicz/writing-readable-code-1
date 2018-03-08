<?php

declare(strict_types=1);

namespace Wrc\Command;

use InvalidArgumentException;

class AddressList
{
    private $addresses;

    /**
     * @param Address[]
     */
    public function __construct(array $addresses)
    {
        $this->addresses = $addresses;
    }

    public function hasAddresses(): bool
    {
        return $this->getAddressesCount() > 0;
    }

    public function getAddressesCount(): int
    {
        return count($this->addresses);
    }

    /**
     * @return Address[]
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function getFirstAddress(): Address
    {
        if ($this->getAddressesCount() >= 1) {
            return $this->addresses[0];
        }

        throw new InvalidArgumentException(
            'Cannot get first address, empty list given'
        );
    }

    public function getSecondAddress(): Address
    {
        if ($this->getAddressesCount() >= 2) {
            return $this->addresses[1];
        }

        throw new InvalidArgumentException(
            'Cannot get second address, too short list given'
        );
    }
}
