<?php

namespace Automobile\Http\Controllers;

use Automobile\Http\Resources\VehicleModelResource;
use Automobile\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Models",
 *     description="Vehicle model management endpoints"
 * )
 */
class ModelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/models",
     *     tags={"Models"},
     *     summary="List models",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="manufacturer_id",
     *         in="query",
     *         description="Filter by manufacturer id",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter by model name (partial match)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Successful")
     * )
     */
    public function index(Request $request)
    {
        $models = VehicleModel::query()
            ->when($request->filled('manufacturer_id'), fn ($query) => $query->where('manufacturer_id', $request->input('manufacturer_id')))
            ->when($request->filled('name'), fn ($query) => $query->where('name', 'like', '%'.$request->input('name').'%'))
            ->paginate(15);

        return VehicleModelResource::collection($models);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/models",
     *     tags={"Models"},
     *     summary="Create a model",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"manufacturer_id","name"},
     *             @OA\Property(property="manufacturer_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="201", description="Created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'manufacturer_id' => 'required|integer|exists:manufacturers,id',
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('models', 'name')->where(fn ($query) => $query->where('manufacturer_id', $request->input('manufacturer_id'))),
            ],
        ]);

        $model = VehicleModel::create($data);

        return new VehicleModelResource($model->load('manufacturer'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/models/{model}",
     *     tags={"Models"},
     *     summary="Get a single model",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="model",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Successful"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function show(VehicleModel $model)
    {
        return new VehicleModelResource($model->load(['manufacturer', 'variants']));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/models/{model}",
     *     tags={"Models"},
     *     summary="Update a model",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="model",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="manufacturer_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function update(Request $request, VehicleModel $model)
    {
        $data = $request->validate([
            'manufacturer_id' => 'sometimes|required|integer|exists:manufacturers,id',
            'name' => [
                'sometimes', 'required', 'string', 'max:255',
                Rule::unique('models', 'name')
                    ->where(fn ($query) => $query->where('manufacturer_id', $request->input('manufacturer_id', $model->manufacturer_id)))
                    ->ignore($model->id),
            ],
        ]);

        $model->update($data);

        return new VehicleModelResource($model->load('manufacturer'));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/models/{model}",
     *     tags={"Models"},
     *     summary="Delete a model",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="model",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="No Content"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(VehicleModel $model)
    {
        $model->delete();

        return response()->noContent();
    }
}
