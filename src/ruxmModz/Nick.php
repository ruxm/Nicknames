<?php
  
namespace ruxmModz;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use pocketmine\Server;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\player\PlayerJoinEvent;

class Nick extends PluginBase {
  public $config;
  public $prefix;
  
  public function onLoad(){
    $this->prefix = $this->getConfig()->get("prefix");
  } 
    
  public function onJoin(PlayerJoinEvent $event){
    $player = $event->getPlayer();
    $nick = new Config($this->getDataFolder() . $player->getName() . ".yml", Config::YAML);
    if($nick != null){
      $player->setDisplayName($nick->get("nick"));
      $player->sendMessage($this->prefix . "Dein Nickname ist: " . $nick);
    }
  }
  public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        if($command->getName() === "nick") {
            if(isset($args[0])){
                $sender->sendMessage($this->prefix . 'Dein Nickname ist ' . $args[0]);
                $playerfile = new Config($this->getDataFolder() . $sender->getName() . ".yml", Config::YAML);
                $sender->setDisplayName($args[0]);
                $playerfile->set("nick", $args[0]);
                $playerfile->save();
            }
            elseif(!isset($args[0])){
                $sender->sendMessage($this->prefix . 'Usage: /nick <Gewünschter Nickname>');
            }
            return true;
        }
        return false;
    }
}
