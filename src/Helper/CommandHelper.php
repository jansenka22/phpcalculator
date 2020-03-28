<?php

namespace Jakmall\Recruitment\Calculator\Helper;

use Illuminate\Console\Command;

class CommandHelper extends Command
{

  /**
   * @param array $description
   *
   * @return array
   */
  public function getInput(array $arguments): array
  {
      $arguments = array_keys($arguments);
      $count = count($arguments);
      foreach($arguments as $argument){
        $replace  = array('*','?');
        $argument =  str_replace($replace,'',$argument);
        if($count > 1){
          $input[]    =  $this->argument($argument);
        }else{
          $input      =  $this->argument($argument);
        }
      }
      return $input;
  }

  /**
   * @param string $description
   * @param string $result
   *
   * @return string
   */
  public function generateComment(string $description, string $result): string
  {
      return sprintf('%s = %s', $description, $result);
  }

  /**
   * @param array $input
   * @param string $operator
   *
   * @return string
   */
  public function generateCalculationDescription(array $inputs, string $operator): string
  {
      $glue = sprintf(' %s ', $operator);
      return implode($glue, $inputs);
  }

  /**
   * @param array $arguments
   * @param string $command
   *
   * @return string
   */
  public function generateSignature(array $arguments, string $command)
  {
      foreach($arguments as $argument => $description)
      {
          $signature .=  sprintf('{%s : %s}',$argument,$description);
      }
      $signatures = sprintf('%s %s',$command,$signature);
      return $signatures;
  }

  /**
   * @param array $input
   * @param string $command
   *
   * @return float|int
   */
  public function calculateAll(array $inputs, string $command)
  {
      $input = array_pop($inputs);

      if (count($inputs) <= 0) {
          return $input;
      }

      return $this->calculate($this->calculateAll($inputs, $command), $input, $command);
  }

  /**
   * @param int|float $number1
   * @param int|float $number2
   * @param string $command
   *
   * @return int|float
   */
  protected function calculate($number1, $number2, $command)
  {
      switch ($command) {
          case 'add':
              return $number1 + $number2;
              break;
          case 'subtract':
              return $number1 - $number2;
              break;
          case 'multiply':
              return $number1 * $number2;
              break;
          case 'divide':
              return $number1 / $number2;
              break;
          case 'pow':
              return $number1 ** $number2;
              break;
          default:
              return 0;
      }
  }


}
