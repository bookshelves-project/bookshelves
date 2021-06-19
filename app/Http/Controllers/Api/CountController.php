<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountController extends Controller
{
	/**
	 * @OA\Get(
	 *     path="/count",
	 *     tags={"count"},
	 *     summary="Count of entities",
	 *     description="Get count by entities, use query parameter to select entity.",
	 *     @OA\Parameter(
	 *         name="entity",
	 *         in="query",
	 *         description="String to select existant entity",
	 *         required=true,
	 *         @OA\Schema(
	 *           enum={"book", "serie", "author"},
	 *         ),
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Successful operation",
	 * 		   @OA\JsonContent(),
	 *     )
	 * )
	 */
	public function count(Request $request)
	{
		$entity = $request->get('entity');
		$entity = $entity ? $entity : null;
		$entityParameters = ['book', 'serie', 'author'];
		if (!$entity && !in_array($entity, $entityParameters)) {
			return response()->json(
				"Invalid 'entity' query parameter, must be like '" . implode("' or '", $entityParameters) . "'",
				400
			);
		}

		$lang = $request->get('lang');
		$lang = $lang ? $lang : null;
		$langParameters = ['fr', 'en'];
		if ($lang && !in_array($lang, $langParameters)) {
			return response()->json(
				"Invalid 'lang' query parameter, must be like '" . implode("' or '", $langParameters) . "'",
				400
			);
		}

		$model_name = 'App\Models\\' . ucfirst($entity);
		$entities_count = 0;

		try {
			if ($lang) {
				$entities_count = $model_name::whereLanguageSlug($lang)->get();
				$entities_count = $entities_count->count();
			} else {
				$entities_count = $model_name::count();
			}
		} catch (\Throwable $th) {
		}

		return $entities_count;
	}
}
