<?php

namespace Jakmall\Recruitment\Calculator\Helper;

use Illuminate\Console\Command;

class HistoryHelper extends Command
{

  /**
   * @var string
   */
  private static $separatorCol = ',';

  /**
   * @var string
   */
  private static $separatorRow = '|';

  /**
   * @var string
   */
  private static $fileName = 'log';

  /**
   * @param string $command
   * @param string $description
   * @param string $result
   * @param string $output
   *
   * @return void
   */
  public function saveHistory($command, $description, $result, $output): void
  {
      $time    = date('Y-m-d H:i:s');
      $data    = array($command, $description, $result, $output, $time);
      $history = sprintf('%s%s',static::$separatorRow,implode(static::$separatorCol, $data));
      file_put_contents(static::$fileName, $history,FILE_APPEND);
  }

  /**
   *
   * @return array
   */
  protected static function itemHistory(): array
  {
      $data = [];
      static::createFile();
      $listData    = file_get_contents(static::$fileName);
      $dataHistory = static::parseHistoryRow($listData);
      $dataHistory = array_filter($dataHistory);
      $no = 0;
      foreach($dataHistory as $listHistory){
        $no++;
        $historyList    = sprintf('%s%s%s',$no,static::$separatorCol,$listHistory);
        $data[]         = static::parseHistoryCol($historyList);
      }
      return $data;
  }

  /**
   * @param array $search
   */
  public function listHistory(array $search = [])
  {
      $history = static::itemHistory();
      if(sizeof($search) > 0){
        $history = static::filterHistory($search, $history);
      }
      foreach($history as $dataHistory)
      {
          $data[] = array_map( function($v) { return ucfirst($v); }, $dataHistory);
      }
      return $data;
  }

  /**
   * @return array
   */
  public function getHeaderTable(): array
  {
    $header = array('No','Command', 'Description', 'Result', 'Output', 'Time');
    return $header;
  }

  /**
   * @param array $search
   * @param array $data
   *
   */
  protected static function filterHistory(array $search = [],array $data): array
  {
      $filteredData = [];
      foreach($data as $key => $dataHistory)
      {
          //search data
          foreach($search as $searchValue){
            if(in_array($searchValue, $dataHistory)){
              $filteredData[] = $data[$key];
            }
          }
      }
      return $filteredData;
  }

  /**
   * @param string $data
   * @return array
   */
  public static function parseHistoryCol($data): array
  {
    $data = explode(static::$separatorCol, $data);
    return $data;
  }

  /**
   * @param string $data
   * @return array
   */
  protected static function parseHistoryRow($data): array
  {
    $data = explode(static::$separatorRow, $data);
    return $data;
  }

  /**
   * @return void
   */
  public function clearHistory(): void
  {
    file_put_contents(static::$fileName, '');
  }

  /**
   * @return void
   */
  protected static function createFile(): void
  {
      file_put_contents(static::$fileName, '', FILE_APPEND);
  }

}