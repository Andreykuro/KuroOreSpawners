# KuroOreSpawner ⛏️

A generator plugin for PocketMine-MP that lets players place ore-spawning blocks that automatically generate ores over time. Fully integrated with [KuroShops](https://github.com/Andreykuro/KuroShops) and [SimpleEconomy](https://github.com/NhanAZ/SimpleEconomy).

---

## 📋 Requirements

| Dependency | Version | Link |
|---|---|---|
| PocketMine-MP | API 5.42.0+ | [Download](https://github.com/pmmp/PocketMine-MP/releases) |
| PHP | 8.2+ | [Download](https://www.php.net) |
| SimpleEconomy | Latest | [Download](https://github.com/NhanAZ/SimpleEconomy) |
| FormAPI | Latest | [Download](https://github.com/jojoe77777/FormAPI) |
| KuroShops | 0.0.1+ | [Download](https://github.com/Andreykuro/KuroShops) |

---

## 📦 Installation

1. Place `KuroOreSpawner` into your `/plugins` folder
2. Make sure **SimpleEconomy**, **FormAPI**, and **KuroShops** are also in `/plugins`
3. Restart your server
4. The plugin will load automatically

> ⚠️ KuroOreSpawner **must** load after KuroShops. The `depend` in `plugin.yml` handles this automatically.

---

## 🔧 How It Works

1. Obtain a generator via `/kuroos give` or buy one from `/shop` → **Generators**
2. **Place** the generator block anywhere in the world
3. The generator will automatically **spawn the corresponding ore** 2 blocks above it at the configured interval
4. **Break** the generator block to pick it back up — it drops as the generator item again
5. Replant it anywhere to reactivate it

---

## 🏗️ Generators

Each generator is a **colored glazed terracotta** block with a custom name and NBT tag to identify it.

| Generator | Block Color | Level 1 | Level 2 | Level 3 |
|---|---|---|---|---|
| 🖤 Coal | Black Glazed Terracotta | Every 15s | Every 7s | Every 3s |
| 🩶 Iron | Light Gray Glazed Terracotta | Every 15s | Every 7s | Every 3s |
| 💛 Gold | Yellow Glazed Terracotta | Every 15s | Every 7s | Every 3s |
| 🩵 Diamond | Light Blue Glazed Terracotta | Every 15s | Every 7s | Every 3s |

---

## 💰 Shop Prices (via KuroShops)

| Generator | Level 1 | Level 2 | Level 3 |
|---|---|---|---|
| Coal | $5,000 | $10,000 | $18,000 |
| Iron | $15,000 | $28,000 | $45,000 |
| Gold | $25,000 | $45,000 | $70,000 |
| Diamond | $60,000 | $100,000 | $150,000 |

Generators are purchasable from `/shop` → **Generators** category powered by KuroShops.

---

## 🛠️ Commands

| Command | Description | Permission |
|---|---|---|
| `/kuroos give <player> <ore> <amount> <level>` | Give a generator to a player | `kuroos.give` |

### Examples
```
/kuroos give FinessedKB diamond 1 3
/kuroos give FinessedKB coal 2 1
/kuroos give FinessedKB gold 1 2
```

---

## 🔐 Permissions

| Permission | Description | Default |
|---|---|---|
| `kuroos.give` | Allows giving generators to players | `op` |

---

## ⚙️ plugin.yml

```yaml
name: KuroOreSpawner
version: 0.0.1
main: Andreykuro\KuroOreSpawner\Main
api: 5.42.0
depend:
  - SimpleEconomy
commands:
  kuroos:
    description: "Give a generator to a player"
    usage: "/kuroos give <player> <ore> <amount> <level>"
    permission: kuroos.give
permissions:
  kuroos.give:
    description: "Allows giving generators"
    default: op
```

---

## 📁 File Structure

```
KuroOreSpawner/
├── plugin.yml
└── src/
    └── Andreykuro/
        └── KuroOreSpawner/
            ├── Main.php
            ├── Listener/
            │   └── BlockListener.php
            ├── Task/
            │   └── GeneratorTickTask.php
            └── Utils/
                └── GeneratorItem.php
```

---

## 🔗 KuroShops Integration

KuroOreSpawner hooks directly into **KuroShops** by adding a **Generators** category to the `/shop` menu.

Make sure your KuroShops `plugin.yml` has the following:

```yaml
softdepend:
  - KuroOreSpawner
```

And that `GeneratorsUI.php` is placed inside:
```
KuroShops/src/Andreykuro/KuroShops/UI/GeneratorsUI.php
```

The Generators shop submenu allows players to browse and purchase all ore types across all 3 levels directly from `/shop`.

---

## 🧩 Plugin Suite

This plugin is part of the **Kuro** plugin suite:

| Plugin | Description |
|---|---|
| [KuroShops](https://github.com/Andreykuro/KuroShops) | In-game shop with categories for Woods, Crops, Food, Misc and Generators |
| [KuroMiner](https://github.com/Andreykuro/KuroMiner) | Earn money by mining ores |
| **KuroOreSpawner** | Place generator blocks that automatically spawn ores |

---

## 👤 Author

**Andreykuro** — KuroOreSpawner v0.0.1

---

## 📄 License

This project is provided as-is for use on PocketMine-MP servers.
