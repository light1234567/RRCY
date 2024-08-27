<?php

namespace App\Http\Controllers;

use App\Models\PerformanceObservationReport;
use App\Models\PerformanceIndicator;
use App\Models\PerformanceSection;
use App\Models\TrainingAttended;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PerformanceObservationReportController extends Controller
{
    public function storeOrUpdate(Request $request, $client_id)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'assessment_date' => 'required|date',
                'trainings_attended' => 'nullable|string|max:255',
                'general_remarks' => 'nullable|string',
                'prepared_by' => 'nullable|string|max:255',
                'noted_by' => 'nullable|string|max:255',
                'sections' => 'array',
                'sections.*.title' => 'nullable|string',
                'sections.*.sub_total' => 'nullable|integer',
                'sections.*.remarks' => 'nullable|string',
                'sections.*.indicators' => 'array',
                'sections.*.indicators.*.description' => 'nullable|string',
                'sections.*.indicators.*.self_rating' => 'nullable|integer',
                'sections.*.indicators.*.mdo_rating' => 'nullable|integer',
                'trainings' => 'array',
                'trainings.*.title' => 'nullable|string',
                'trainings.*.date_of_attendance' => 'nullable|date',
                'trainings.*.status' => 'nullable|string|max:255',
            ]);

            // Fetch or create the report
            $report = PerformanceObservationReport::updateOrCreate(
                ['client_id' => $client_id],
                [
                    'assessment_date' => $validatedData['assessment_date'],
                    'trainings_attended' => $validatedData['trainings_attended'] ?? null,
                    'general_remarks' => $validatedData['general_remarks'] ?? null,
                    'prepared_by' => $validatedData['prepared_by'] ?? null,
                    'noted_by' => $validatedData['noted_by'] ?? null,
                ]
            );

            // Save or update sections and related indicators
            if (isset($validatedData['sections'])) {
                foreach ($validatedData['sections'] as $sectionData) {
                    $section = $report->sections()->updateOrCreate(
                        ['title' => $sectionData['title']],
                        [
                            'sub_total' => $sectionData['sub_total'] ?? null,
                            'remarks' => $sectionData['remarks'] ?? null,
                        ]
                    );

                    // Save or update indicators related to the section
                    if (isset($sectionData['indicators'])) {
                        foreach ($sectionData['indicators'] as $indicatorData) {
                            $section->indicators()->updateOrCreate(
                                ['description' => $indicatorData['description']],
                                [
                                    'self_rating' => $indicatorData['self_rating'] ?? null,
                                    'mdo_rating' => $indicatorData['mdo_rating'] ?? null,
                                ]
                            );
                        }
                    }
                }
            }

            // Save or update trainings attended
            if (isset($validatedData['trainings'])) {
                foreach ($validatedData['trainings'] as $trainingData) {
                    $report->trainings()->updateOrCreate(
                        ['title' => $trainingData['title']],
                        [
                            'date_of_attendance' => $trainingData['date_of_attendance'] ?? null,
                            'status' => $trainingData['status'] ?? null,
                        ]
                    );
                }
            }

            Log::info("Successfully saved or updated Performance Observation Report for client_id: $client_id", $report->toArray());
            return response()->json($report, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Validation failed:", $e->errors());
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error("Error storing or updating Performance Observation Report for client_id: $client_id", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Failed to store or update report', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($client_id)
    {
        try {
            $report = PerformanceObservationReport::with(['sections.indicators', 'trainings', 'client'])
                ->where('client_id', $client_id)
                ->first();

            if (!$report) {
                return response()->json(['message' => 'Report not found'], 404);
            }

            return response()->json($report);
        } catch (\Exception $e) {
            Log::error("Error fetching Performance Observation Report for client_id: $client_id", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Failed to fetch report', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $report = PerformanceObservationReport::find($id);
            if ($report) {
                $report->delete();
                Log::info("Successfully deleted Performance Observation Report with id: $id");
                return response()->json(['message' => 'Deleted successfully']);
            }

            Log::warning("Report not found for id: $id");
            return response()->json(['message' => 'Not found'], 404);
        } catch (\Exception $e) {
            Log::error("Error deleting Performance Observation Report with id: $id", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Failed to delete report', 'error' => $e->getMessage()], 500);
        }
    }
}

