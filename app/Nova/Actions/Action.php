<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action as NovaAction;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

class Action extends NovaAction
{
    use InteractsWithQueue, Queueable, SerializesModels;
}