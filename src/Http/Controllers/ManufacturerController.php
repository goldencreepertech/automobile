<?php

namespace Automobile\Http\Controllers;

use Automobile\Http\Resources\ManufacturerResource;
use Automobile\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Manufacturers",
 *     description="Manufacturer management endpoints"
 * )
 */
class ManufacturerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/manufacturers",
     *     tags={"Manufacturers"},
     *     summary="List manufacturers",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter by manufacturer name (partial match)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Successful")
     * )
     */
    public function index(Request $request)
    {
        $manufacturers = Manufacturer::query()
            ->when($request->filled('name'), fn ($query) => $query->where('name', 'like', '%'.$request->input('name').'%'))
            ->get();

        return ManufacturerResource::collection($manufacturers);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/manufacturers",
     *     tags={"Manufacturers"},
     *     summary="Create a manufacturer",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
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
            'name' => 'required|string|max:255|unique:manufacturers,name',
        ]);

        $manufacturer = Manufacturer::create($data);

        return new ManufacturerResource($manufacturer);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/manufacturers/{manufacturer}",
     *     tags={"Manufacturers"},
     *     summary="Get a single manufacturer",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="manufacturer",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Successful"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function show(Manufacturer $manufacturer)
    {
        return new ManufacturerResource($manufacturer->load('models'));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/manufacturers/{manufacturer}",
     *     tags={"Manufacturers"},
     *     summary="Update a manufacturer",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="manufacturer",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        $data = $request->validate([
            'name' => [
                'sometimes', 'required', 'string', 'max:255',
                Rule::unique('manufacturers', 'name')->ignore($manufacturer->id),
            ],
        ]);

        $manufacturer->update($data);

        return new ManufacturerResource($manufacturer);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/manufacturers/{manufacturer}",
     *     tags={"Manufacturers"},
     *     summary="Delete a manufacturer",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="manufacturer",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="No Content"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();

        return response()->noContent();
    }
}
