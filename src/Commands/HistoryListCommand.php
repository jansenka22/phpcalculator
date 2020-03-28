<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\Helper\CommandHelper;
use Jakmall\Recruitment\Calculator\Helper\HistoryHelper;

class HistoryListCommand extends CommandHelper
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
    protected $command  = 'history:list';

    /**
     * @var string
     */
    protected $commandDescription  = 'Show Calculator History';

    /**
     * @var array
     */
    protected $arguments = [
      'commands?*'  =>  'Filter the history by commands',
    ];


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
        //get input
        $input        = CommandHelper::getInput($this->arguments);
        //get header table
        $headerTable = HistoryHelper::getHeaderTable();
        //get list history
        $dataHistory = HistoryHelper::listHistory($input);
        if(isset($dataHistory)){
          $this->table($headerTable,$dataHistory);
        }else{
          $this->comment('History is empty');
        }
    }


}
