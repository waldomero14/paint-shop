<?php

namespace File;

/**
 * Class FileReader.
 *
 * This class reads and process the input file.
 *
 * @package File
 */
class FileReader {

  /**
   * Validates that the first line is valid.
   *
   * @param string $line
   *   The line string.
   *
   * @return bool
   *   True if the validation is passed.
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
   *   The line string.
   *
   * @return bool
   *   True if the validation is passed.
   */
  public function validateLine(string $line): bool {
    // This regular expression checks there are not additional spaces between
    // the color numbers and the color values.
    if (preg_match('/^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/', $line)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Converts a string to an array of colors.
   *
   * @param string $line
   *   The line string.
   *
   * @return array
   *   And array with the colors information.
   */
  public function getColorsFromLine(string $line): array {
    $chars = explode(' ', $line);
    // The 'force' key indicates that this costumer only has one color.
    $output['force'] = FALSE;
    if (count($chars) === 2) {
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
