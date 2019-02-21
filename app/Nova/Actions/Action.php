<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use NovaComponents\ActionGearbox\Actions\Action as GearboxAction;

class Action extends GearboxAction
{
    use InteractsWithQueue, Queueable, SerializesModels;
}