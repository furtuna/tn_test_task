<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\Tests\Import\InfoCollector;

use PFC\Demo\SimpleUserImport\Import\InfoCollector\InfoCollectorInterface;
use PFC\Demo\SimpleUserImport\Import\InfoCollector\SimpleInfoCollector;
use PFC\Demo\SimpleUserImport\Import\Validation\ValidationResult;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

final class SimpleInfoCollectorTest extends TestCase
{
    /**
     * @var InfoCollectorInterface
     */
    private $simpleInfoCollector;

    public function setUp(): void
    {
        $this->simpleInfoCollector = new SimpleInfoCollector(
            $this->createMock(LoggerInterface::class),
            new ProgressBar(new ConsoleOutput())
        );
    }

    public function testTotalIsSet(): void
    {
        $this->simpleInfoCollector->setTotal(225);
        $this->assertSame(225, $this->simpleInfoCollector->total());
    }

    public function testValidationErrorsAdded(): void
    {
        $this->simpleInfoCollector->addValidationError(new ValidationResult('1', ['Error 1']));
        $this->simpleInfoCollector->addValidationError(new ValidationResult('2', ['Error 2']));
        $this->assertSame(2, $this->simpleInfoCollector->validationErrorsCount());
    }

    public function testInsertedUpdatedProcessed(): void
    {
        $this->simpleInfoCollector->addInserted(25);
        $this->simpleInfoCollector->addUpdated(35);
        $this->assertSame(25, $this->simpleInfoCollector->inserted());
        $this->assertSame(35, $this->simpleInfoCollector->updated());
        $this->assertSame(60, $this->simpleInfoCollector->processed());
    }
}
