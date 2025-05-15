<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Flash
{
    public function predictPriority(string $taskName, string $description, string $projectTitle, string $projectDescription, string $deadline): ?string
    {

        $apiKey = config('services.gemini.key');

        $prompt = <<<EOT
        You are an expert IT project manager.
        
        Given a task with its context (title, description, deadline, and project info), respond with a JSON object containing:
        - "priority": one of "low", "medium", or "high"
        - "confidence": a float between 0.0 and 1.0 indicating your confidence in this prediction
        
        Instructions:
        - Always respond in valid JSON.
        - Do NOT explain. Respond ONLY with JSON.
        - If the task has no urgency indicators or is minor in impact, label it "low".
        - If it directly affects functionality, user experience, or release timelines, assign "medium" or "high" as appropriate.
        - Use clues like urgency keywords (e.g., "urgent", "critical", "ASAP") and how soon the deadline is (e.g., today/tomorrow = high).
        
        Respond only with the JSON.
        
        Task: "{$taskName}", Description: "{$description}", Deadline: "{$deadline}"
        Project: "{$projectTitle}", Description: "{$projectDescription}"
        EOT;

        Log::info('Gemini Priority Prompt', ['prompt' => $prompt]);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
            'contents' => [['parts' => [['text' => $prompt]]]]
        ]);

        $resultText = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
        Log::info('Gemini Raw Response', ['response' => $resultText]);

        $cleaned = trim($resultText);
        if (str_starts_with($cleaned, '```')) {
            $cleaned = preg_replace('/^```[a-z]*\n?|```$/i', '', $cleaned);
        }

        $data = json_decode($cleaned, true);
        Log::info('Gemini Parsed Result', ['parsed' => $data]);

        if (!is_array($data) || !isset($data['priority']) || !is_numeric($data['confidence']) || $data['confidence'] < 0.5) {
            Log::warning('Gemini fallback triggered', [
                'reason' => 'Invalid JSON or low confidence',
                'raw_response' => $cleaned
            ]);
            return null;
        }

        $prio = strtolower($data['priority']);
        return in_array($prio, ['low', 'medium', 'high']) ? $prio : null;
    }

    public function validateTaskForProject($taskName, $project)
    {
        $apiKey = config('services.gemini.key');
        $projectTitle = $project->name ?? '';
        $projectDescription = $project->description ?? '';

        $prompt = <<<EOT
            The project is titled: "{$projectTitle}".
            Description: "{$projectDescription}"
            Is the task "{$taskName}" relevant to this project? Answer with one word only: yes or no.
            EOT;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        $result = $response->json();
        $answer = strtolower(trim($result['candidates'][0]['content']['parts'][0]['text'] ?? 'no'));

        return $answer === 'yes';
    }

    public function isITProject(string $projectTitle, string $projectDescription): bool
    {
        $apiKey = config('services.gemini.key');

        $prompt = <<<EOT
        You are a classification engine for project domains. Determine if a project belongs to Information Technology (IT).
        
        Output JSON:
        {
        "isIT": "yes" or "no",
        "confidence": float (0.0–1.0)
        }
        
        Rubric:
        - YES if title or description mentions software, development, coding, infrastructure, network, database, AI/ML, cloud, DevOps, cybersecurity, web/mobile app, UX/UI, API, microservices.
        - NO if it is unrelated (e.g. agriculture, retail, event planning, healthcare without IT component).
        
        Examples:
        Project: "E-commerce website rebuild", Description: "Migrate to microservices on AWS"  
        => {"isIT":"yes","confidence":0.96}
        
        Project: "Organic farm expansion", Description: "Build new greenhouses"  
        => {"isIT":"no","confidence":0.98}
        
        Now classify:
        Project: "{$projectTitle}"
        Description: "{$projectDescription}"
        EOT;


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}",
            ['contents' => [['parts' => [['text' => $prompt]]]]]
        );

        $raw = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';
        Log::info('isITProject raw response:', ['raw' => $raw]);

        if (preg_match('/\{.*\}/s', $raw, $m)) {
            $jsonBlock = $m[0];
            $data = json_decode($jsonBlock, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return isset($data['isIT']) && strtolower($data['isIT']) === 'yes';
            }
            Log::warning('JSON decode error in isITProject', ['error' => json_last_error_msg()]);
        } else {
            Log::warning('No JSON block found in isITProject response');
        }

        return false;
    }
}
