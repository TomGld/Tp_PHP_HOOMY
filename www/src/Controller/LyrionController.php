<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LyrionController extends AbstractController
{
    #[Route('/api/music', name: 'get_music', methods: ['POST'])]
    public function getMusic(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $start = $data['start'] ?? 0;
        $limit = $data['limit'] ?? 100;

        $payload = json_encode([
            "id" => 1,
            "method" => "slim.request",
            "params" => ["", ["songs", $start, $limit, "tags:adltu"]],
        ]);

        $ch = curl_init("http://192.168.46.63:9000/jsonrpc.js");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($result === false || empty($result)) {
            return new JsonResponse(['error' => $error ?: 'Empty reply from server'], 500);
        }

        $decoded = json_decode($result, true);
        return new JsonResponse($decoded['result'] ?? ['error' => 'Invalid response']);
    }

    #[Route('/api/playlists', name: 'playlists', methods: ['POST'])]
public function getPlaylists(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $start = $data['start'] ?? 0;
    $limit = $data['limit'] ?? 50;
    $profileName = $data['profileName'] ?? null;

    $payload = json_encode([
        "id" => 1,
        "method" => "slim.request",
        "params" => ["", ["playlists", $start, $limit, "tags:adltu"]],
    ]);

    $ch = curl_init("http://192.168.46.63:9000/jsonrpc.js");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    $result = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($result === false || empty($result)) {
        return new JsonResponse(['error' => $error ?: 'Empty reply from server'], 500);
    }

    $decoded = json_decode($result, true);
    $playlists = $decoded['result'] ?? [];

    // Filter playlists by profile name prefix (case-insensitive)
    if ($profileName) {
        $playlists['playlists_loop'] = array_filter($playlists['playlists_loop'], function ($playlist) use ($profileName) {
            return stripos($playlist['playlist'], $profileName) === 0;
        });
    }

    return new JsonResponse($playlists);
}

    
    // Method to create a new playlist
    #[Route('/api/playlist/create', name: 'create_playlist', methods: ['POST'])]
    public function createPlaylist(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $profileName = $data['profile'] ?? 'user';
        $playlistName = $data['name'] ?? 'NewPlaylist';

        // Compose prefixed name: profile_playlistName
        $fullPlaylistName = $profileName . '_' . $playlistName;

        $payload = json_encode([
            "id" => 1,
            "method" => "slim.request",
            "params" => ["", ["playlists", "new", "name:$fullPlaylistName", "tags:adltu"]],
        ]);

        $ch = curl_init("http://192.168.46.63:9000/jsonrpc.js");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($result === false || empty($result)) {
            return new JsonResponse(['error' => $error ?: 'Empty reply from server'], 500);
        }

        $decoded = json_decode($result, true);
        return new JsonResponse($decoded['result'] ?? ['error' => 'Invalid response']);
    }

    // Méthode pour récupérer les songs d'une playlist
    #[Route('/api/playlists/{id}', name: 'playlist_detail', methods: ['POST'])]
    public function getPlaylistSongs(int $id): JsonResponse
    {
        $payload = json_encode([
            "id" => 1,
            "method" => "slim.request",
            "params" => ["", ["playlists","tracks","0","10","playlist_id:$id"]],
        ]);

        $ch = curl_init("http://192.168.46.63:9000/jsonrpc.js");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($result === false || empty($result)) {
            return new JsonResponse(['error' => $error ?: 'Empty reply from server'], 500);
        }

        $decoded = json_decode($result, true);
        return new JsonResponse($decoded['result'] ?? ['error' => 'Invalid response']);
    }
}
