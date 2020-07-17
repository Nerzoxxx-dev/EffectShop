<?php

namespace Youtube\EffectShop\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Player;
use Youtube\EffectShop\Forms\SimpleForm;
use Youtube\EffectShop\ShopCore;
use onebone\EconomyAPI\EconomyAPI;

class EffectShopCommand extends Command {

    private $core;

    public function __construct(ShopCore $core){
        parent::__construct('effectshop', 'Ouvre un ui qui vous permet d\'acheter des effets.', '/effectshop', []);

        $this->core = $core;

    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {

        if($player instanceof Player){

            if($player->hasPermission('effectshop.use')){

                $this->onShopUi($player);

            }else{

                $player->sendMessage('§4Vous n\'avez pas la permission d\'utiliser cette commande!');

            }

        }else{

            $player->sendMessage('§4Veuillez utiliser cette commande en jeu.');

        }
    }
    public function onShopUI($player){
        $form = new SimpleForm(function(Player $player, int $data = null){

           $result = $data;

           if($result === null){
               return true;
           }
           switch($result){
               case 0:

                   if(EconomyAPI::getInstance()->myMoney($player) >= 1500){

                       EconomyAPI::getInstance()->reduceMoney($player, 1500);
                       $player->addEffect(new EffectInstance(Effect::getEffect(Effect::NIGHT_VISION), 10*60*20, 0, false));
                       $player->sendMessage('§2L\'argent requise vous a bien été retirée et l\'effet vous a bien été ajouté.');

                   }else{

                       $player->sendMessage('§4Vous n\'avez pas l\'argent requis pour acheter cet effet.');

                   }

                   break;

               case 1:
                   if(EconomyAPI::getInstance()->myMoney($player) >= 3500){

                       EconomyAPI::getInstance()->reduceMoney($player, 3500);
                       $player->addEffect(new EffectInstance(Effect::getEffect(Effect::RESISTANCE), 10*60*20, 1, false));
                       $player->sendMessage('§2L\'argent requise vous a bien été retirée et l\'effet vous a bien été ajouté.');

                   }else{

                       $player->sendMessage('§4Vous n\'avez pas l\'argent requis pour acheter cet effet.');

                   }
                   break;

               case 2:

                   if(EconomyAPI::getInstance()->myMoney($player) >= 1500){

                       EconomyAPI::getInstance()->reduceMoney($player, 1500);
                       $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 10*60*20, 0, false));
                       $player->sendMessage('§2L\'argent requise vous a bien été retirée et l\'effet vous a bien été ajouté.');

                   }else{

                       $player->sendMessage('§4Vous n\'avez pas l\'argent requis pour acheter cet effet.');

                   }

                   break;

           }
        });
        $form->setTitle('§e§lEffectShop');
        $form->addButton("§fNigth vision 1 10 minutes \n Prix : 1500$");
        $form->addButton("§6Resistance 2 10 minutes\n Prix : 3500$");
        $form->addButton("§2Speed 1 10 minutes\n Prix : 1500$");
        $form->sendToPlayer($player);
    }
}