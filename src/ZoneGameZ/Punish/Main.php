<?php

namespace ZoneGameZ\Punish;

use pocketmine\plugin\PluginBase;
use pocketmine\Player; 
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {
	
	public $plugin;

	public $prefix = "§e[§bPunish§e] §f"

	public function onEnable(){
		$this->getLogger()->info("".$prefix."Enable Plugin Punish players");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getResource("config.yml");
	}
	
	public function onCommand(CommandSender $sender, Command $command, String $label, array $args) : bool {
        switch($command->getName()){
            case "punish":
            if($sender->hasPermission("punish.command")){
            $this->OpenForm($sender);
            }
            return true;
        }
        return true;
	}
	
	 public function OpenForm($sender){
        $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createSimpleForm(function(Player $sender, $data){
          $result = $data;
          if($result === null){
			  return true;
          }
          switch($result){
              case 0:
              $this->Ban($sender);
              case 1:
			  $this->Kick($sender);
              break;
          }
        });
        $form->setTitle($this->getConfig()->get("Title-Menu");
		$form->addButton($this->getConfig()->get("Ban-Button"), 0, "textures/ui/trash");
		$form->addButton($this->getConfig()->get("Kick-Button"), 0, "textures/ui/hammer_l");
        $form->sendToPlayer($sender);
	}
	
	public function Ban($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $formapi->createCustomForm(function(Player $player, $data){
			$result = $data[0];
			if($result === null){
				return true;
			}
			$cmd = "ban $data[0]";
			$this->getServer()->getCommandMap()->dispatch($player, $cmd);
		});
		$form->setTitle($this->getConfig()->get("Ban-Title");
		// Enter the names of the players to be banned.
		$form->addInput($this->getConfig()->get("Ban-Input");
		$form->sendToPlayer($player);
	}
	
	public function Kick($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $formapi->createCustomForm(function(Player $player, $data){
			$result = $data[0];
			if($result === null){
				return true;
			}
			$cmd = "kick $data[0]";
			$this->getServer()->getCommandMap()->dispatch($player, $cmd);
		});
		$form->setTitle($this->getConfig()->get("Kick-Title");
		// Enter the names of the players to be Kicked.
		$form->addInput($this->getConfig()->get("Kick-Input");
		$form->sendToPlayer($player);
	}
}