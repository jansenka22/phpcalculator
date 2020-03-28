<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\Helper\CommandHelper;
use Jakmall\Recruitment\Calculator\Helper\HistoryHelper;

class MultiplyCommand extends CommandHelper
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
  protected $command  = 'multiply';

  /**
   * @var string
   */
  protected $commandDescription  = 'Multiply all given Numbers';

  /**
   * @var array
   */
  protected $arguments = [
    'numbers*'  =>  'The numbers to be multiplied'
  ];

  /**
   * @var string
   */
  protected $operator  = '*';

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
      //generate calculation
      $description  = CommandHelper::generateCalculationDescription($input, $this->operator);
      //calculate
      $result       = CommandHelper::calculateAll($input, $this->command);
      //generate comment
      $comment      = CommandHelper::generateComment($description, $result);
      //output
      $this->comment($comment);
      //save history
      HistoryHelper::saveHistory($this->command, $description, $result, $comment);
      
  }
}