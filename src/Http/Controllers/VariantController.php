<?php

namespace Automobile\Http\Controllers;

use Automobile\Http\Resources\VariantResource;
use Automobile\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Variants",
 *     description="Vehicle variant management endpoints"
 * )
 */
class VariantController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/variants",
     *     tags={"Variants"},
     *     summary="List variants",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="model_id",
     *         in="query",
     *         description="Filter by model id",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter by variant name (partial match)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Successful")
     * )
     */
    public function index(Request $request)
    {
        $variants = Variant::query()
            ->when($request->filled('model_id'), fn ($query) => $query->where('model_id', $request->input('model_id')))
            ->when($request->filled('name'), fn ($query) => $query->where('name', 'like', '%'.$request->input('name').'%'))
            ->paginate(15);

        return VariantResource::collection($variants);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/variants",
     *     tags={"Variants"},
     *     summary="Create a variant",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"model_id","name"},
     *             @OA\Property(property="model_id", type="integer"),
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
            'model_id' => 'required|integer|exists:models,id',
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('variants', 'name')->where(fn ($query) => $query->where('model_id', $request->input('model_id'))),
            ],
        ]);

        $variant = Variant::create($data);

        return new VariantResource($variant->load('model.manufacturer'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/variants/{variant}",
     *     tags={"Variants"},
     *     summary="Get a single variant",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="variant",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Successful"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function show(Variant $variant)
    {
        return new VariantResource($variant->load('model.manufacturer'));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/variants/{variant}",
     *     tags={"Variants"},
     *     summary="Update a variant",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="variant",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="model_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function update(Request $request, Variant $variant)
    {
        $data = $request->validate([
            'model_id' => 'sometimes|required|integer|exists:models,id',
            'name' => [
                'sometimes', 'required', 'string', 'max:255',
                Rule::unique('variants', 'name')
                    ->where(fn ($query) => $query->where('model_id', $request->input('model_id', $variant->model_id)))
                    ->ignore($variant->id),
            ],
        ]);

        $variant->update($data);

        return new VariantResource($variant->load('model.manufacturer'));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/variants/{variant}",
     *     tags={"Variants"},
     *     summary="Delete a variant",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="variant",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="No Content"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(Variant $variant)
    {
        $variant->delete();

        return response()->noContent();
    }
}
