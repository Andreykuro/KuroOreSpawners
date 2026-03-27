<?php
namespace Andreykuro\KuroOreSpawner;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Andreykuro\KuroOreSpawner\Listener\BlockListener;
use Andreykuro\KuroOreSpawner\Utils\GeneratorItem;
use Andreykuro\KuroOreSpawner\Task\GeneratorTickTask;

class Main extends PluginBase {

    public static Main $instance;

    /** @var array<string, array{ore: string, level: int}> position string => generator data */
    public array $activeGenerators = [];

    public function onEnable(): void {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new BlockListener($this), $this);
        $this->getScheduler()->scheduleRepeatingTask(new GeneratorTickTask($this), 20); // ticks every second
        $this->getLogger()->info("KuroOreSpawner Enabled!");
    }

    public static function getInstance(): Main {
        return self::$instance;
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if(strtolower($command->getName()) !== "kuroos") return false;

        if(!isset($args[0]) || strtolower($args[0]) !== "give"){
            $sender->sendMessage("§cUsage: /kuroos give <player> <ore> <amount> <level>");
            return true;
        }

        if(!isset($args[1], $args[2], $args[3], $args[4])){
            $sender->sendMessage("§cUsage: /kuroos give <player> <ore> <amount> <level>");
            return true;
        }

        $target = $this->getServer()->getPlayerByPrefix($args[1]);
        if($target === null){
            $sender->sendMessage("§cPlayer not found!");
            return true;
        }

        $ore = strtolower($args[2]);
        $amount = (int) $args[3];
        $level = (int) $args[4];

        if(!in_array($ore, ["coal", "iron", "gold", "diamond"])){
            $sender->sendMessage("§cInvalid ore! Use: coal, iron, gold, diamond");
            return true;
        }

        if($level < 1 || $level > 3){
            $sender->sendMessage("§cLevel must be between 1 and 3!");
            return true;
        }

        if($amount < 1){
            $sender->sendMessage("§cAmount must be at least 1!");
            return true;
        }

        $item = GeneratorItem::create($ore, $level);
        $item->setCount($amount);
        $target->getInventory()->addItem($item);
        $sender->sendMessage("§aGave §e" . $amount . "x §f" . ucfirst($ore) . " Generator §7(Level " . $level . ")§a to §e" . $target->getName() . "§a!");
        $target->sendMessage("§aYou received §e" . $amount . "x §f" . ucfirst($ore) . " Generator §7(Level " . $level . ")§a!");
        return true;
    }
}
