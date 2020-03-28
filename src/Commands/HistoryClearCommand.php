<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\Helper\CommandHelper;
use Jakmall\Recruitment\Calculator\Helper\HistoryHelper;

class HistoryClearCommand extends CommandHelper
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $command  = 'history:clear';

    /**
     * @var string
     */
    protected $commandDescription  = 'Clear saved history';

    /**
     * @var array
     */
    protected $arguments = [];


    public function __construct()
    {
        //generate signature
        $this->signature   = CommandHelper::generateSignature($this->arguments, $this->command);
        //get description
        $this->description = $this->commandDescription;
        parent::__construct($this);
    }

    public function handle(): void
    {
        //clear history
        HistoryHelper::clearHistory();
        //get list history
        $this->comment('History cleared!');
    }


}
