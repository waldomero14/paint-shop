<?php

namespace File;

class FileReader {

  /**
   * Validates that the first line is valid.
   *
   * @param string $line
   *
   * @return bool
   */
  public function validateFirstLine(string $line): bool {
    // The first line should be an integer greater than 0.
    if (preg_match('/^[1-9][0-9]*$/', $line)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Validates that a line has the correct format.
   *
   * @param string $line
   *
   * @return bool
   */
  public function validateLine(string $line): bool {
    return TRUE;
  }

  /**
   * Converts a string to an array of colors.
   *
   * @param string $line
   *
   * @return array
   */
  public function getColorsFromLine(string $line): array {
    $chars = explode(' ', $line);
    // The 'force' key indicates that this costumer only has one color.
    $output['force'] = FALSE;
    if (sizeof($chars) === 2) {
      $output['force'] = TRUE;
    }
    foreach ($chars as $key => $char) {
      if ($key % 2 === 0) {
        $output['colors'][$key]['color'] = $char;
        continue;
      }
      $output['colors'][$key - 1]['value'] = $char;
    }
    return $output;
  }

}