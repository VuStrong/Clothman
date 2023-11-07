<?php

namespace App\DTOs\Common;

use Illuminate\Http\Request;

class QueryParamsDto
{
    public function __construct(
        public int $limit,
        public ?string $sort,
        public ?string $by,
        public ?string $keyword
    ) {}

    /**
     * Map request to QueryParamsDto object
     */
    public static function fromRequest(Request $request) {
        $sort = $request->sort ? explode(".", $request->sort) : null;

        return new QueryParamsDto(
            $request->limit ?? 10,
            $sort ? $sort[0] : null,
            $sort && isset($sort[1]) ? $sort[1] : "asc",
            $request->q,
        );
    }
}