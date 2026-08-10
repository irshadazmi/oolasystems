<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ChatbotController extends Controller
{
    /**
     * Process a chatbot message.
     */
    public function message(
        Request $request,
        ChatbotService $chatbotService
    ): JsonResponse {
        $validated = $request->validate([
            'message' => [
                'required',
                'string',
                'min:1',
                'max:2000',
            ],
        ]);

        try {
            $state = session()->get(
                'chatbot',
                [
                    'history' => [],
                    'extracted' => [],
                ]
            );

            $result = $chatbotService->respond(
                $validated['message'],
                $state
            );

            /*
             * Store conversation state for the
             * next visitor message.
             */
            session()->put('chatbot', [
                'history' => $result['history'],
                'extracted' => $result['extracted'],
                'confirmation_required' =>
                    $result['confirmation_required'],
                'ready_for_inquiry' =>
                    $result['ready_for_inquiry'],
            ]);

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'extracted' => $result['extracted'],
                'missing' => $result['missing'],
                'confirmation_required' =>
                    $result['confirmation_required'],
                'ready_for_inquiry' =>
                    $result['ready_for_inquiry'],
                'show_inquiry_form' =>
                    $result['show_inquiry_form'],
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' =>
                    'I’m sorry, I’m having trouble processing your request right now. Please try again in a moment.',
            ], 500);
        }
    }

    /**
     * Reset the current chatbot conversation.
     */
    public function reset(): JsonResponse
    {
        session()->forget('chatbot');

        return response()->json([
            'success' => true,
        ]);
    }
}
