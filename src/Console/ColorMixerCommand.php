<?php

namespace Console;

use Model\ColorMixer;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\String\Exception\InvalidArgumentException;
use File\FileReader;

/**
 * Class ColorMixerCommand.
 *
 * @package Console
 */
class ColorMixerCommand extends SymfonyCommand {

  /**
   * The FileReader instance.
   *
   * @var \File\FileReader
   */
  protected $fileReader;

  /**
   * The ColorMixer instance.
   *
   * @var \Model\ColorMixer
   */
  protected $colorMixer;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    parent::__construct();
    $this->fileReader = new FileReader();
    $this->colorMixer = new ColorMixer();
  }

  /**
   * {@inheritdoc}
   */
  public function configure() {
    $this->setName('mixcolor')
      ->setDescription('Mixed a sort of colors based on some rules.')
      ->setHelp('This command allows you to solve a problem of color mixing')
      ->addArgument('inputfile', InputArgument::REQUIRED, 'The input file.');
  }

  /**
   * {@inheritdoc}
   */
  public function execute(InputInterface $input, OutputInterface $output) {
    $this->readFile($input, $output);
    $this->result($output);
    return 0;
  }

  /**
   * Returns the result of the command.
   *
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   The Console Output instance.
   */
  protected function result(OutputInterface $output) {
    if (!$this->colorMixer->mixPaints()) {
      $output->writeln('No solution exists');
      return;
    }
    $output->writeln('');
    $output->writeln('SOLUTION:');
    $output->writeln($this->colorMixer->getSolutionString());
  }

  /**
   * Reads a input file in the command.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   The Console Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   The Console Output instance.
   */
  protected function readFile(InputInterface $input, OutputInterface $output) {
    $filename = $input->getArgument('inputfile');
    $handle = fopen($filename, "r");
    if ($handle) {
      $line_number = 0;
      $output->writeln("YOUR FILE:");
      while (($line = fgets($handle)) !== FALSE) {
        $line = trim($line);
        $line_number++;
        // Process the line read.
        $output->writeln($line);
        if ($line_number === 1) {
          if ($this->fileReader->validateFirstLine($line)) {
            $this->colorMixer->setColorCount((int) $line);
            continue;
          }
          throw new InvalidArgumentException("Error at line $line_number: first line should be a number > 0. You have \"$line\"");
        }
        if ($this->fileReader->validateLine($line)) {
          $colors = $this->fileReader->getColorsFromLine($line);
          $this->colorMixer->addCustomer($colors);
          continue;
        }
        throw new InvalidArgumentException("Error at line $line_number");
      }

      fclose($handle);
    }
    else {
      throw new InvalidArgumentException("The file $filename could not be read");
    }
  }

}
