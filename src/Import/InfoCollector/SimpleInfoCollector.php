<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Import\InfoCollector;

use PFC\Demo\SimpleUserImport\Import\Validation\ValidationResult;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class SimpleInfoCollector implements InfoCollectorInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ProgressBar
     */
    private $progressBar;

    /**
     * @var string[]
     */
    private $validationErrors;

    /**
     * @var int
     */
    private $insertedCount;

    /**
     * @var int
     */
    private $updatedCount;

    /**
     * @var int
     */
    private $total;

    /**
     * @param LoggerInterface $logger
     * @param ProgressBar $progressBar
     */
    public function __construct(LoggerInterface $logger, ProgressBar $progressBar)
    {
        $this->logger = $logger;
        $this->progressBar = $progressBar;
        $this->validationErrors = 0;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
        $this->progressBar->setMaxSteps($total);
        $this->progressBar->setFormat('%current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * @param ValidationResult $validationResult
     */
    public function addValidationError(ValidationResult $validationResult): void
    {
        if (!$validationResult->hasErrors()) {
            return;
        }

        ++$this->validationErrors;

        $this->logger->warning(sprintf(
            'Validation error for row with identifier "%s": %s',
            $validationResult->rowId(),
            implode(';', $validationResult->errors())
        ));
    }

    /**
     * @return int
     */
    public function validationErrorsCount(): int
    {
        return $this->validationErrors;
    }

    /**
     * @param int $insertedCount
     */
    public function addInserted(int $insertedCount): void
    {
        $this->insertedCount += $insertedCount;
    }

    /**
     * @return int
     */
    public function inserted(): int
    {
        return $this->insertedCount;
    }

    /**
     * @param int $updatedCount
     */
    public function addUpdated(int $updatedCount): void
    {
        $this->updatedCount += $updatedCount;
    }

    /**
     * @return int
     */
    public function updated(): int
    {
        return $this->updatedCount;
    }

    /**
     * @return int
     */
    public function processed(): int
    {
        return $this->inserted() + $this->updated();
    }

    /**
     */
    public function start(): void
    {
        $this->progressBar->start();
        $this->progressBar->setMessage('Сегодня донимают меня муторные мысли...'.PHP_EOL);
        $this->progressBar->display();
    }

    public function finish(): void
    {
        $this->progressBar->setMaxSteps($this->total);
        $this->progressBar->finish();
    }

    /**
     * @param int $steps
     */
    public function progress(int $steps): void
    {
        $this->progressBar->advance($steps);
    }
}
