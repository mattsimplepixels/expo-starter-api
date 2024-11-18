<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    public function notes(Request $request): JsonResponse
    {
        $user = User::find($request->user()->id);

        return response()->json($user->notes);
    }

    public function note(Request $request, $noteId): JsonResponse
    {
        $note = Note::where('user_id', $request->user()->id)
            ->where('id', $noteId)
            ->first();

        if (!$note) {
            return response()->json(['error' => 'Note not found'], 404);
        }

        return response()->json($note);
    }

    public function create(Request $request): JsonResponse
    {
        Log::info($request->all());
        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:500'
        ]);

        $note = Note::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json($note);
    }

    public function delete(Request $request, $noteId): JsonResponse
    {
        $note = Note::where('user_id', $request->user()->id)
            ->where('id', $noteId)
            ->first();

        if (!$note) {
            return response()->json(['error' => 'Note not found'], 404);
        }

        $note->delete();

        return response()->json(['message' => 'Note successfully deleted']);
    }
}
