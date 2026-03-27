<?php
namespace Andreykuro\KuroOreSpawner\Utils;

use pocketmine\item\Item;
use pocketmine\block\VanillaBlocks;
use pocketmine\block\utils\DyeColor;
use pocketmine\nbt\tag\StringTag;

class GeneratorItem {

    public static function create(string $ore, int $level): Item {
        $item = match($ore) {
            "coal"    => VanillaBlocks::GLAZED_TERRACOTTA()->setColor(DyeColor::BLACK)->asItem(),
            "iron"    => VanillaBlocks::GLAZED_TERRACOTTA()->setColor(DyeColor::LIGHT_GRAY)->asItem(),
            "gold"    => VanillaBlocks::GLAZED_TERRACOTTA()->setColor(DyeColor::YELLOW)->asItem(),
            "diamond" => VanillaBlocks::GLAZED_TERRACOTTA()->setColor(DyeColor::LIGHT_BLUE)->asItem(),
            default   => VanillaBlocks::GLAZED_TERRACOTTA()->setColor(DyeColor::BLACK)->asItem(),
        };

        $oreName = ucfirst($ore);
        $item->setCustomName("§r§b" . $oreName . " Generator §7[Lvl " . $level . "]");
        $item->setLore([
            "§7Ore: §f" . $oreName,
            "§7Level: §e" . $level,
            "§7Interval: §f" . self::getIntervalLabel($level),
            "§8Place to activate!"
        ]);

        $tag = $item->getNamedTag();
        $tag->setString("kuro_generator_ore", $ore);
        $tag->setString("kuro_generator_level", (string) $level);
        $item->setNamedTag($tag);

        return $item;
    }

    public static function isGenerator(Item $item): bool {
        return $item->getNamedTag()->getTag("kuro_generator_ore") instanceof StringTag;
    }

    public static function getOre(Item $item): ?string {
        $tag = $item->getNamedTag()->getTag("kuro_generator_ore");
        return $tag instanceof StringTag ? $tag->getValue() : null;
    }

    public static function getLevel(Item $item): ?int {
        $tag = $item->getNamedTag()->getTag("kuro_generator_level");
        return $tag instanceof StringTag ? (int) $tag->getValue() : null;
    }

    private static function getIntervalLabel(int $level): string {
        return match($level) {
            1 => "15s",
            2 => "7s",
            3 => "3s",
            default => "?"
        };
    }
}
