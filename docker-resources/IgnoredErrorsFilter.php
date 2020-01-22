<?php

namespace App\Statictools\PHPStan;

use PHPStan\Command\ErrorFormatter\TableErrorFormatter;
use PHPStan\Command\AnalysisResult;
use PHPStan\Command\Output;

/**
 * Allow ignoring errors.
 *
 * Modified from
 * https://github.com/phpstan/phpstan/issues/786#issuecomment-532865549.
 */
class IgnoredErrorsFilter extends TableErrorFormatter {

  private const MUTE_ERROR_ANNOTATION = 'phpstan:ignoreError';

  private const NO_ERRORS = 0;

  /**
   * {@inheritdoc}
   */
  public function formatErrors(AnalysisResult $analysisResult, Output $output): int {
    if (!$analysisResult->hasErrors()) {
      return self::NO_ERRORS;
    }

    $fileSpecificErrorsWithoutIgnoredErrors = $this->clearIgnoredErrors(
      $analysisResult->getFileSpecificErrors()
    );

    $clearedAnalysisResult = new AnalysisResult(
      $fileSpecificErrorsWithoutIgnoredErrors,
      $analysisResult->getNotFileSpecificErrors(),
      $analysisResult->isDefaultLevelUsed(),
      $analysisResult->hasInferrablePropertyTypesFromConstructor(),
      $analysisResult->getProjectConfigFile()
    );

    return parent::formatErrors($clearedAnalysisResult, $output);
  }

  /**
   * Clear ignored errors from a list of errors.
   *
   * @param \PHPStan\Analyser\Error[] $fileSpecificErrors
   *   All errors.
   *
   * @return \PHPStan\Analyser\Error[]
   *   All errors except those which have an "ignore" comment on the previous
   *   line.
   */
  private function clearIgnoredErrors(array $fileSpecificErrors): array {
    foreach ($fileSpecificErrors as $index => $error) {
      $fileName = $error->getFile();

      $file = new \SplFileObject($fileName);

      // get the line above to the line that caused the error
      $file->seek($error->getLine() - 2);

      $line = $file->current();

      $lineContainAnnotation = strpos($line, self::MUTE_ERROR_ANNOTATION);
      $lineContainErrorDescription = strpos($line, $error->getMessage());

      if(false !== $lineContainAnnotation) {
        unset($fileSpecificErrors[$index]);
      }
    }

    return $fileSpecificErrors;
  }

}
