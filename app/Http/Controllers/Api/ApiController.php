<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Bookshelves API",
 *     description="Documentation about Bookshelves API"
 * ),
 * @OA\Tag(
 *     name="global",
 *     description="Global requests"
 * ),
 * @OA\Tag(
 *     name="books",
 *     description="Books requests"
 * ),
 * @OA\Tag(
 *     name="series",
 *     description="Series requests"
 * ),
 * @OA\Tag(
 *     name="authors",
 *     description="Authors requests"
 * ),
 * @OA\Tag(
 *     name="search",
 *     description="Search requests"
 * ),
 */
class ApiController extends Controller
{
}
