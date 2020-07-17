<?php

namespace Youtube\EffectShop;

use pocketmine\plugin\PluginBase;
use Youtube\EffectShop\Commands\EffectShopCommand;

class ShopCore extends PluginBase {

    public static $instance;

    public function onEnable()
    {
        $this->getLogger()->info('§2ON');

        $this->getServer()->getCommandMap()->registerAll('Commands', [
            new EffectShopCommand($this),
        ]);
        self::$instance = $this;
        if(!$this->getServer()->getPluginManager()->getPlugin('EconomyAPI')){
            $this->getLogger()->info('§4Le plugin EconomyAPi n\'est pas sur votre serveur. Désactivation du plugin en cours...');
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
    }
    public static function getInstance(){
        return self::$instance;
    }
}
