<?php

namespace Automobile\Http\Controllers;

use Automobile\Http\Resources\PartResource;
use Automobile\Models\Part;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Parts",
 *     description="Part management endpoints"
 * )
 */
class PartController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/parts",
     *     tags={"Parts"},
     *     summary="List parts",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter by part name (partial match)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filter by part category",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="part_number",
     *         in="query",
     *         description="Filter by exact part number",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Successful")
     * )
     */
    public function index(Request $request)
    {
        $parts = Part::with('vehicles')
            ->when($request->filled('name'), fn ($query) => $query->where('name', 'like', '%'.$request->input('name').'%'))
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->input('category')))
            ->when($request->filled('part_number'), fn ($query) => $query->where('part_number', $request->input('part_number')))
            ->paginate(15);

        return PartResource::collection($parts);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/parts",
     *     tags={"Parts"},
     *     summary="Create a part",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="part_number", type="string"),
     *             @OA\Property(property="category", type="string"),
     *             @OA\Property(property="details", type="object", properties={
     *                 @OA\Property(property="manufacturer", type="string"),
     *                 @OA\Property(property="compatibility", type="string"),
     *             }),
     *             @OA\Property(property="vehicles", type="array", @OA\Items(type="integer")),
     *         )
     *     ),
     *     @OA\Response(response="201", description="Created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'details' => 'nullable|array',
            'details.manufacturer' => 'nullable|string|max:255',
            'details.compatibility' => 'nullable|string|max:255',
            'vehicles' => 'nullable|array',
            'vehicles.*' => 'integer|exists:vehicles,id',
        ]);

        $part = Part::create($data);
        $part->vehicles()->sync($data['vehicles'] ?? []);

        return new PartResource($part->load('vehicles'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/parts/{part}",
     *     tags={"Parts"},
     *     summary="Get a single part",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="part",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Successful"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function show(Part $part)
    {
        return new PartResource($part->load('vehicles'));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/parts/{part}",
     *     tags={"Parts"},
     *     summary="Update a part",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="part",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="part_number", type="string"),
     *             @OA\Property(property="category", type="string"),
     *             @OA\Property(property="details", type="object", properties={
     *                 @OA\Property(property="manufacturer", type="string"),
     *                 @OA\Property(property="compatibility", type="string"),
     *             }),
     *             @OA\Property(property="vehicles", type="array", @OA\Items(type="integer")),
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function update(Request $request, Part $part)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'details' => 'nullable|array',
            'details.manufacturer' => 'nullable|string|max:255',
            'details.compatibility' => 'nullable|string|max:255',
            'vehicles' => 'nullable|array',
            'vehicles.*' => 'integer|exists:vehicles,id',
        ]);

        $part->update($data);
        if (array_key_exists('vehicles', $data)) {
            $part->vehicles()->sync($data['vehicles']);
        }

        return new PartResource($part->load('vehicles'));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/parts/{part}",
     *     tags={"Parts"},
     *     summary="Delete a part",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="part",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="No Content"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(Part $part)
    {
        $part->delete();

        return response()->noContent();
    }
}
