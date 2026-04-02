<?php
declare(strict_types=1);

namespace Trix\VibrantVisuals;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ResourcePacksInfoPacket;
use pocketmine\plugin\PluginBase;

final class VibrantVisual extends PluginBase implements Listener {

    protected function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDataPacketSend(DataPacketSendEvent $event): void {
        foreach ($event->getPackets() as $packet) {
            if ($packet instanceof ResourcePacksInfoPacket) {
                $ref = new \ReflectionProperty($packet, 'forceDisableVibrantVisuals');
                $ref->setAccessible(true);
                $ref->setValue($packet, false);
            }
        }
    }
}