<?php

namespace App\DTOs\Categories;

use App\DTOs\Common\QueryParamsDto;
use Illuminate\Http\Request;

class CategoryParamsDto extends QueryParamsDto
{
    public function __construct(
        public int $page,
        public int $limit,
        public ?string $sort,
        public ?string $by,
        public ?string $keyword,
        public ?array $includes
    ) {
        parent::__construct($page, $limit, $sort, $by, $keyword);
    }

    /**
     * Map request to CategoryParamsDto object
     */
    public static function fromRequest(Request $request) {
        $paramsDto = QueryParamsDto::fromRequest($request);

        return new CategoryParamsDto(
            $paramsDto->page,
            $paramsDto->limit,
            $paramsDto->sort,
            $paramsDto->by,
            $paramsDto->keyword,
            null
        );
    }
}
