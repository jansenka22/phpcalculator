<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\Helper\CommandHelper;
use Jakmall\Recruitment\Calculator\Helper\HistoryHelper;

class PowCommand extends CommandHelper
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
    protected $command  = 'pow';

    /**
     * @var string
     */
    protected $commandDescription  = 'Exponent the given number';

    /**
     * @var array
     */
    protected $arguments = [
      'base'  =>  'The base number',
      'exp'   =>  'The exponent number'
    ];

    /**
     * @var string
     */
    protected $operator  = '^';

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
        $inputs       = CommandHelper::getInput($this->arguments);
        //generate calculation
        $description  = CommandHelper::generateCalculationDescription($inputs, $this->operator);
        //calculate
        $result       = CommandHelper::calculateAll($inputs, $this->command);
        //generate comment
        $comment      = CommandHelper::generateComment($description, $result);
        //output
        $this->comment($comment);
        //save history
      HistoryHelper::saveHistory($this->command, $description, $result, $comment);
      
    }


}
