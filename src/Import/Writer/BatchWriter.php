<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Import\Writer;

use PFC\Demo\SimpleUserImport\Import\DataProvider\DataTransferInterface;
use PFC\Demo\SimpleUserImport\Import\InfoCollector\InfoCollectorInterface;

class BatchWriter implements WriterInterface
{
    /**
     * @var PersisterInterface
     */
    private $persister;

    /**
     * @var InfoCollectorInterface
     */
    private $infoCollector;

    /**
     * @var int
     */
    private $batchSize;

    /**
     * @param PersisterInterface $persister
     * @param InfoCollectorInterface $infoCollector
     * @param int $batchSize
     */
    public function __construct(PersisterInterface $persister, InfoCollectorInterface $infoCollector, int $batchSize)
    {
        $this->persister = $persister;
        $this->infoCollector = $infoCollector;
        $this->batchSize = max($batchSize, 1);
    }

    /**
     * @param \Iterator|DataTransferInterface[] $data
     *
     * @throws WriterException
     */
    public function write(\Iterator $data): void
    {
        $dataTransfers = [];
        $dataTransfersInBatchCount = 0;
        foreach ($data as $dataTransfer) {
            $this->requireDataTransfer($dataTransfer);
            $dataTransfers[] = $dataTransfer;
            ++$dataTransfersInBatchCount;
            if ($dataTransfersInBatchCount >= $this->batchSize) {
                $persisterResult = $this->persister->persistCollection($this->createDataTransfersBatch($dataTransfers));
                $this->collectInfo($persisterResult);
                $dataTransfers = [];
                $dataTransfersInBatchCount = 0;
            }
        }

        $persisterResult = $this->persister->persistCollection($this->createDataTransfersBatch($dataTransfers));
        $this->collectInfo($persisterResult);
    }

    /**
     * @param PersisterResult $persisterResult
     */
    private function collectInfo(PersisterResult $persisterResult): void
    {
        $this->infoCollector->addInserted($persisterResult->inserted());
        $this->infoCollector->addUpdated($persisterResult->updated());
        $this->infoCollector->progress($this->batchSize);
    }

    /**
     * @param array $dataTransfers
     *
     * @return \Iterator
     */
    private function createDataTransfersBatch(array $dataTransfers): \Iterator
    {
        foreach ($dataTransfers as $dataTransfer) {
            yield $dataTransfer;
        }
    }

    /**
     * @param mixed $object
     *
     * @throws WriterException
     */
    private function requireDataTransfer($object): void
    {
        if (!$object instanceof DataTransferInterface) {
            throw new WriterException(sprintf(
                'Instance of "%s" expected.',
                DataTransferInterface::class
            ));
        }
    }
}
