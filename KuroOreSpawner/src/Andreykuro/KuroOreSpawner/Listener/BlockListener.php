<?php
namespace Andreykuro\KuroOreSpawner\Listener;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use Andreykuro\KuroOreSpawner\Main;
use Andreykuro\KuroOreSpawner\Utils\GeneratorItem;

class BlockListener implements Listener {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onPlace(BlockPlaceEvent $event): void {
        $item = $event->getItem();
        if(!GeneratorItem::isGenerator($item)) return;

        $block = $event->getBlockAgainst();
        $pos = $block->getPosition();
        $posKey = $pos->getWorld()->getFolderName() . ":" . $pos->getFloorX() . ":" . $pos->getFloorY() . ":" . $pos->getFloorZ();

        $ore = GeneratorItem::getOre($item);
        $level = GeneratorItem::getLevel($item);

        if($ore === null || $level === null) return;

        $this->plugin->activeGenerators[$posKey] = [
            "ore"     => $ore,
            "level"   => $level,
            "world"   => $pos->getWorld()->getFolderName(),
            "x"       => $pos->getFloorX(),
            "y"       => $pos->getFloorY(),
            "z"       => $pos->getFloorZ(),
            "ticker"  => 0,
        ];

        $event->getPlayer()->sendMessage("§a" . ucfirst($ore) . " Generator §7(Level " . $level . ") §aactivated!");
    }

    public function onBreak(BlockBreakEvent $event): void {
        $pos = $event->getBlock()->getPosition();
        $posKey = $pos->getWorld()->getFolderName() . ":" . $pos->getFloorX() . ":" . $pos->getFloorY() . ":" . $pos->getFloorZ();

        if(!isset($this->plugin->activeGenerators[$posKey])) return;

        $data = $this->plugin->activeGenerators[$posKey];
        unset($this->plugin->activeGenerators[$posKey]);

        // Drop the generator item back so player can pick it up
        $item = GeneratorItem::create($data["ore"], $data["level"]);
        $pos->getWorld()->dropItem($pos->add(0.5, 1, 0.5), $item);

        // Cancel drops from breaking the terracotta itself
        $event->setDrops([]);
        $event->getPlayer()->sendMessage("§eGenerator picked up!");
    }
}
