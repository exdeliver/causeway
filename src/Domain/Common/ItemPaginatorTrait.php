<?php

namespace Exdeliver\Causeway\Domain\Common;

trait ItemPaginatorTrait
{
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();
        return new ItemPaginator(
            $connection,
            $connection->getQueryGrammar(),
            $connection->getPostProcessor()
        );
    }
}