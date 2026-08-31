<?php

namespace Automobile\Http\Controllers;

use Automobile\Http\Resources\VehicleResource;
use Automobile\Models\Vehicle;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Vehicles",
 *     description="Vehicle management endpoints"
 * )
 */
class VehicleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/vehicles",
     *     tags={"Vehicles"},
     *     summary="List vehicles",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="variant_id",
     *         in="query",
     *         description="Filter by variant id",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="fuel_type",
     *         in="query",
     *         description="Filter by fuel type (e.g. Petrol, Diesel, Electric, Hybrid, CNG)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="body_type",
     *         in="query",
     *         description="Filter by body type (e.g. Hatchback, Sedan, SUV, Motorcycle, Scooter)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="manufacturing_origin",
     *         in="query",
     *         description="Filter by manufacturing origin country",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="launch_date_from",
     *         in="query",
     *         description="Filter vehicles launched on or after this date",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="launch_date_to",
     *         in="query",
     *         description="Filter vehicles launched on or before this date",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(response="200", description="Successful")
     * )
     */
    public function index(Request $request)
    {
        $vehicles = Vehicle::with(['variant.model.manufacturer', 'parts'])
            ->when($request->filled('variant_id'), fn ($query) => $query->where('variant_id', $request->input('variant_id')))
            ->when($request->filled('fuel_type'), fn ($query) => $query->where('details->fuel_type', $request->input('fuel_type')))
            ->when($request->filled('body_type'), fn ($query) => $query->where('details->body_type', $request->input('body_type')))
            ->when($request->filled('manufacturing_origin'), fn ($query) => $query->where('details->manufacturing_origin', $request->input('manufacturing_origin')))
            ->when($request->filled('launch_date_from'), fn ($query) => $query->whereDate('launch_date', '>=', $request->input('launch_date_from')))
            ->when($request->filled('launch_date_to'), fn ($query) => $query->whereDate('launch_date', '<=', $request->input('launch_date_to')))
            ->paginate(15);

        return VehicleResource::collection($vehicles);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/vehicles",
     *     tags={"Vehicles"},
     *     summary="Create a vehicle",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"variant_id"},
     *             @OA\Property(property="variant_id", type="integer"),
     *             @OA\Property(property="launch_date", type="string", format="date"),
     *             @OA\Property(property="discontinue_date", type="string", format="date"),
     *             @OA\Property(property="details", type="object", properties={
     *                 @OA\Property(property="manufacturing_origin", type="string"),
     *                 @OA\Property(property="fuel_type", type="string"),
     *                 @OA\Property(property="body_type", type="string"),
     *                 @OA\Property(property="seating_capacity", type="integer"),
     *             }),
     *             @OA\Property(property="parts", type="array", @OA\Items(type="integer")),
     *         )
     *     ),
     *     @OA\Response(response="201", description="Created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'variant_id' => 'required|integer|exists:variants,id',
            'launch_date' => 'nullable|date',
            'discontinue_date' => 'nullable|date|after_or_equal:launch_date',
            'details' => 'nullable|array',
            'details.manufacturing_origin' => 'nullable|string|max:255',
            'details.fuel_type' => 'nullable|string|max:255',
            'details.body_type' => 'nullable|string|max:255',
            'details.seating_capacity' => 'nullable|integer',
            'parts' => 'nullable|array',
            'parts.*' => 'integer|exists:parts,id',
        ]);

        $vehicle = Vehicle::create($data);
        $vehicle->parts()->sync($data['parts'] ?? []);

        return new VehicleResource($vehicle->load(['variant.model.manufacturer', 'parts']));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/vehicles/{vehicle}",
     *     tags={"Vehicles"},
     *     summary="Get a single vehicle",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="vehicle",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Successful"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function show(Vehicle $vehicle)
    {
        return new VehicleResource($vehicle->load(['variant.model.manufacturer', 'parts']));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/vehicles/{vehicle}",
     *     tags={"Vehicles"},
     *     summary="Update a vehicle",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="vehicle",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="variant_id", type="integer"),
     *             @OA\Property(property="launch_date", type="string", format="date"),
     *             @OA\Property(property="discontinue_date", type="string", format="date"),
     *             @OA\Property(property="details", type="object", properties={
     *                 @OA\Property(property="manufacturing_origin", type="string"),
     *                 @OA\Property(property="fuel_type", type="string"),
     *                 @OA\Property(property="body_type", type="string"),
     *                 @OA\Property(property="seating_capacity", type="integer"),
     *             }),
     *             @OA\Property(property="parts", type="array", @OA\Items(type="integer")),
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'variant_id' => 'sometimes|required|integer|exists:variants,id',
            'launch_date' => 'nullable|date',
            'discontinue_date' => 'nullable|date|after_or_equal:launch_date',
            'details' => 'nullable|array',
            'details.manufacturing_origin' => 'nullable|string|max:255',
            'details.fuel_type' => 'nullable|string|max:255',
            'details.body_type' => 'nullable|string|max:255',
            'details.seating_capacity' => 'nullable|integer',
            'parts' => 'nullable|array',
            'parts.*' => 'integer|exists:parts,id',
        ]);

        $vehicle->update($data);
        if (array_key_exists('parts', $data)) {
            $vehicle->parts()->sync($data['parts']);
        }

        return new VehicleResource($vehicle->load(['variant.model.manufacturer', 'parts']));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/vehicles/{vehicle}",
     *     tags={"Vehicles"},
     *     summary="Delete a vehicle",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="vehicle",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="No Content"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->noContent();
    }
}
