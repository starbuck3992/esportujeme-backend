<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentCreateRequest;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\GameResource;
use App\Http\Resources\PlatformResource;
use App\Http\Resources\Tournaments\TournamentShowResource;
use App\Http\Resources\Tournaments\TournamentTypeResource;
use App\Models\Currency;
use App\Models\Game;
use App\Models\Platform;
use App\Models\Tournament;
use App\Models\TournamentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class TournamentController extends Controller
{
    public function getCreateFormData()
    {

        try {

            return [
                'games' => GameResource::collection(Game::all()),
                'platforms' => PlatformResource::collection(Platform::all()),
                'tournamentTypes' => TournamentTypeResource::collection(TournamentType::all()),
                'currencies' => CurrencyResource::collection(Currency::all()),
            ];

        } catch (Throwable $e) {

            report($e);
            return response()->json(['message' => 'Nastala chyba při získávání dat'], 404);

        }

    }

    public function createTournament(TournamentCreateRequest $request)
    {

        try {
            $sequence = match ($request->maxPlayers) {
                16 => array('1-home', '1-guest', '2-home', '2-guest', '3-home', '3-guest', '4-home', '4-guest',
                    '5-home', '5-guest', '6-home', '6-guest', '7-home', '7-guest', '8-home', '8-guest'),
                default => array('1-home', '1-guest', '2-home', '2-guest', '3-home', '3-guest', '4-home', '4-guest'),
            };
            shuffle($sequence);

            $slug = Str::slug($request->name);

            $tournament = new Tournament([
                'platform_id' => $request->platform,
                'game_id' => $request->game,
                'tournament_status_id' => 1, //Register open,
                'tournament_type_id' => $request->tournamentType,
                'currency_id' => $request->currency,
                'name' => $request->name,
                'information' => $request->information,
                'fee' => $request->fee,
                'schedule_start' => $request->scheduleStart,
                'max_players' => $request->maxPlayers,
                'registration_sequence' => serialize($sequence),
                'slug' => $slug
            ]);

            $tournament->save();

            return response()->json([
                'message' => 'Turnaj byl vytvořen',
                'slug' => $slug
            ]);

        } catch (Throwable $e) {

            report($e);
            return response()->json(['message' => $e], 500);

        }
    }

    public function registerParticipant(Request $request)
    {

        try {

            $userId = Auth::id();

            $tournament = Tournament::where('slug', $request->slug)->where('tournament_status_id', 1)->firstorfail();

            $playerExist = $tournament->tournamentMatches()->where('user_home', $userId)->orWhere('user_guest', $userId)->exists();

            if ($playerExist) {
                return response()->json(['message' => 'Již jsi registrován'], 400);
            }

            $currentCount = $tournament->registered_count;
            $registrationSequence = unserialize($tournament->registration_sequence);

            $position = explode('-', $registrationSequence[$currentCount]);

            $bracket_position = $position[0];
            $player_position = $position[1] === 'home' ? 'user_home' : 'user_guest';

            $tournament->tournamentMatches()->updateOrCreate(
                ['bracket_position' => (int)$bracket_position],
                [$player_position => $userId]
            );

            $currentCount += 1;

            if ($currentCount === $tournament->max_players) {
                $tournament->tournament_status_id = 2; //Register closed
            }

            $tournament->registered_count = $currentCount;
            $tournament->save();

            return response()->json(['message' => 'Byl jsi registrován do turnaje']);


        } catch (Throwable $e) {

            report($e);
            return response()->json(['message' => 'Nastala chyba při registraci do turnaje'], 500);

        }

    }

    public function showTournament($slug)
    {
        try {

            return (new TournamentShowResource(Tournament::with(['platform', 'game', 'tournamentType', 'tournamentStatus', 'currency', 'tournamentMatches.userHome','tournamentMatches.userGuest'])
                ->where('slug', $slug)->firstOrFail()));

        } catch (Throwable $e) {

            report($e);
            return response()->json(['message' => 'Turnaj nenalezen'], 404);

        }
    }
}
