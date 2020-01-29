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
      $analysisResult->getWarnings(),
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
      // ::getFile() generally returns the file path, except in the case of
      // traits, which is why getFilePath() is preferred.
      $fileName = $error->getFilePath();

      $file = new \SplFileObject($fileName);

      // Get the line above to the line that caused the error
      $candidate = $error->getLine() - 2;
      if ($candidate < 0) {
        // Negative lines are not possible.
        break;
      }
      $file->seek($candidate);

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
