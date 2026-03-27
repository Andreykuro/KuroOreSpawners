<?php
namespace Andreykuro\KuroOreSpawner\Task;

use pocketmine\scheduler\Task;
use pocketmine\block\VanillaBlocks;
use pocketmine\world\Position;
use Andreykuro\KuroOreSpawner\Main;

class GeneratorTickTask extends Task {

    private Main $plugin;
    private int $tick = 0;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onRun(): void {
        $this->tick++;

        foreach($this->plugin->activeGenerators as $key => &$data) {
            $interval = match((int) $data["level"]) {
                1 => 15,
                2 => 7,
                3 => 3,
                default => 15
            };

            $data["ticker"]++;

            if($data["ticker"] < $interval) continue;

            $data["ticker"] = 0;

            $world = $this->plugin->getServer()->getWorldManager()->getWorldByName($data["world"]);
            if($world === null) continue;

            $spawnPos = new Position(
                $data["x"],
                $data["y"] + 2, // spawn ore 2 blocks above the generator
                $data["z"],
                $world
            );

            $oreBlock = match($data["ore"]) {
                "coal"    => VanillaBlocks::COAL_ORE(),
                "iron"    => VanillaBlocks::IRON_ORE(),
                "gold"    => VanillaBlocks::GOLD_ORE(),
                "diamond" => VanillaBlocks::DIAMOND_ORE(),
                default   => VanillaBlocks::COAL_ORE(),
            };

            // Only place if the block above is air
            $blockAbove = $world->getBlock($spawnPos);
            if($blockAbove->getTypeId() === VanillaBlocks::AIR()->getTypeId()){
                $world->setBlock($spawnPos, $oreBlock);
            }
        }
    }
}
