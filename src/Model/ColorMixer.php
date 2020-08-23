<?php

namespace Model;

/**
 * Class ColorMixer
 *
 * @package Model
 */
class ColorMixer {

  protected $colorCount;

  protected $customers = [];

  protected $solution = [];

  /**
   * Sets the number of colors that the mixer should use.
   *
   * @param int $number
   */
  public function setColorCount(int $number): void {
    $this->colorCount = $number;
  }

  /**
   * Adds a new customer array to the array of customers.
   *
   * @param array $colors
   */
  public function addCustomer(array $colors): void {
    $this->customers[] = $colors;
  }

  /**
   * Mixes the paints based on some constraints.
   *
   * @return array
   */
  public function mixPaints() {
    foreach ($this->customers as $customer) {
      $is_forced = $customer['force'];
      foreach ($customer['colors'] as $color) {
        $color_number = $color['color'];
        $color_value = $color['value'];
        // If the value for this color has already been set, check some
        // constraints to validate if the value should be overridden.
        if (!empty($this->solution[$color_number]['value']) && $this->solution[$color_number]['value'] !== $color_value) {
          // If there is another required value for this color and it is different
          // from the current, then, the problem has no solution.
          if ($is_forced && $this->solution[$color_number]['required']) {
            return [];
          }
          // Prefer the M color.
          if ($color_value === 'M') {
            $this->solution[$color_number]['value'] = $color_value;
          }
          continue;
        }
        $this->solution[$color_number]['value'] = $color_value;
        $this->solution[$color_number]['required'] = $is_forced;
      }
    }
    return $this->solution;
  }

  /**
   * Converts the solution array to a string.
   *
   * @return string
   */
  public function getSolutionString() {
    $output = '';
    ksort($this->solution);
    foreach ($this->solution as $color) {
      $output .= $color['value'] . " ";
    }
    return $output;
  }

}