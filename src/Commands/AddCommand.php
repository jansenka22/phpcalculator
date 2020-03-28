<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\Helper\CommandHelper;
use Jakmall\Recruitment\Calculator\Helper\HistoryHelper;

class AddCommand extends CommandHelper
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
  protected $command  = 'add';

  /**
   * @var string
   */
  protected $commandDescription  = 'Add all given Numbers';

  /**
   * @var array
   */
  protected $arguments = [
    'numbers*'  =>  'The numbers to be added'
  ];

  /**
   * @var string
   */
  protected $operator  = '+';

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