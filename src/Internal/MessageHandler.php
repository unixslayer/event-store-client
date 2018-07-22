<?php
/**
 * This file is part of the prooph/event-store-client.
 * (c) 2018-2018 prooph software GmbH <contact@prooph.de>
 * (c) 2018-2018 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\EventStoreClient\Internal;

use Prooph\EventStoreClient\Exception\RuntimeException;
use Prooph\EventStoreClient\Internal\Message\Message;

/** @internal */
class MessageHandler
{
    /** @var array */
    private $handlers = [];

    public function registerHandler(string $messageName, callable $handler): void
    {
        $this->handlers[$messageName] = $handler;
    }

    public function handle(Message $message): void
    {
        $name = \get_class($message);

        if (! isset($this->handlers[$name])) {
            throw new RuntimeException('No handler found for ' . $name);
        }

        $this->handlers[$name]($message);
    }
}
