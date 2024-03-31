<?php

namespace App\Http\Controllers;

use App\Models\buku;
use App\Models\genre;
use App\Models\saving;
use App\Models\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    public function index()
    {
        $data1 = User::all();
        $data2 = buku::all();
        $data3 = genre::all();
        $data4 = saving::all();

        return response()->json([
            "data1" => $data1,
            "data2" => $data2,
            "data3" => $data3,
            "data4" => $data4,
        ]);
    }

    public function show($id)
    {
        $saving = Saving::find($id);

        if (!$saving) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($saving);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'buku_id' => 'required|integer',
        ]);

        $saving = Saving::create($request->all());

        return response()->json(['message' => 'Success', 'data' => $saving], 201);
    }

    public function update(Request $request, $id)
    {
        $saving = Saving::find($id);

        if (!$saving) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $request->validate([
            'user_id' => 'required|integer',
            'buku_id' => 'required|integer',
        ]);

        $saving->update($request->all());

        return response()->json(['message' => 'Data updated successfully', 'data' => $saving]);
    }

    public function destroy($id)
    {
        $saving = Saving::find('id', $id);

        if (!$saving) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $saving->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }

    public function genreSearch($id){
        $genre = genre::find($id);

        return response()->json($genre);
    }

    public function deleting($userId, $bookId){
        $saving = Saving::where('user_id', $userId)
        ->where('buku_id', $bookId);

        if (!$saving) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $saving->where('user_id', $userId)
        ->where('buku_id', $bookId)->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }

    public function getBookNormal(){
        $books = buku::with('genre')->get();

        // You can customize the response format if needed
        $formatted = $books->map(function ($book) {
            return [
                'id' => $book->id,
                'name' => $book->name,
                'genre_name' => $book->genre->name,
                'author' => $book->author,
                'sinopsis' => $book->sinopsis
            ];
        });

        return response()->json(["data1" => $formatted]);
    }
}
