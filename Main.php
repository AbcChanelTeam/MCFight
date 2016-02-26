<?php

namespace AbcChanelMC;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as F;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\entity\Entity;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\block\Block;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("MCFight включен");
    }

    public function onBlockBreak(BlockBreakEvent $event) {
        $b = $event->getBlock();
        $p = $event->getPlayer();
        $nickname = $p->getName();
        $cancel = false;
        $pos = new Vector3($b->x,$b->y,$b->z);
        foreach($this->regions as $region) {
            if($region->contains($pos) && !(($p->hasPermission("mcfbreak")) || ($p->hasPermission("mcf.break")))) {
                    $cancel = true;
                    $MESSAGE_TO_PLAYER = F::YELLOW. "[MCFight]". F::GOLD. " На MCFight ломать запрещено.";
                    $p->sendMessage($MESSAGE_TO_PLAYER);
            }
        }
        if($cancel) {
            $event->setCancelled();
        }
    }

    public function onCommand(CommandSender $p,Command $cmd,$label,array $args) {
        if(!($p instanceof Player)){
            $p->sendMessage(F::YELLOW. "[MCFight]". " Комманды используются только от имени игрока.");
            return true;
        }
        $x = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getX();
        $y = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getY();
        $z = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getZ();
        switch ($cmd->getName()) {
            case "mcf-setlobby":
                if($entity->isOp() && $entity Instanceof Player) {
                    $this->setLobby($entity->getName(), $entity->getX(), $entity->getY(), $entity->getZ());
                    $entity->sendMessage(F::YELLOW. "[MCFight]" .F::GOLD. " Точка лобби успешно установлена.");
                } else {
                    $entity->sendMessage(F::YELLOW. "[MCFight]" .F::GOLD. " Комманда вводится только от имени игрока.");
                }
            break;
            case "mcf-lobby":
                if($entity Instanceof Player) {
                    if($this->getLobbyX($entity->getName()) != null && $this->getLobbyY($entity->getName()) != null && $this->getLobbyZ($entity->getName()) != null) {
                        $entity->teleport(new Vector3($this->getLobbyX($entity->getName()), $this->getLobbyY($entity->getName()), $this->getlobbyZ($entity->getName()), $level));
                        $entity->sendMessage(F::YELLOW. "[MCFight]" .F::GOLD. " Вы успешно телепортированы в лобби");
                    } else {
                        $entity->sendMessage(F::YELLOW. "[MCFight]" .F::GOLD. " Точка лобби еще не установлена!");
                    }
                } else {
                    $entity->sendMessage(F::YELLOW. "[MCFight]" .F::GOLD. " Комманда вводится только от имени игрока.");
                }
                break;

        }
    }

    public function onDisable(){
        $this->getLogger()->info("MCFight выключен");
    }
}