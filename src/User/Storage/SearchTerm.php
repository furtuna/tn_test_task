<?php declare(strict_types=1);

namespace PFC\Demo\SimpleUserImport\User\Storage;

class SearchTerm
{
    /**
     * @var string
     */
    private $searchTerm;

    /**
     * @param string $searchTerm
     *
     * @throws SearchException
     */
    public function __construct(string $searchTerm)
    {
        $this->searchTerm = $this->validateAndNormalize($searchTerm);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->searchTerm;
    }

    /**
     * Just for demo reasons.
     *
     * @param string $searchTerm
     *
     * @return string
     *
     * @throws SearchException
     */
    private function validateAndNormalize(string $searchTerm): string
    {
        /** Just for demo reasons. */
        $searchTermLength = strlen($searchTerm);
        if ($searchTermLength < 3 || $searchTermLength > 50) {
            throw new SearchException(sprintf('Search term length should be between 3 and 50, "%s" passed', $searchTerm));
        }

        return strtolower($searchTerm);
    }
}
