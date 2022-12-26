<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentCreateRequest;
use App\Http\Requests\TournamentSaveScoreRequest;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\GameResource;
use App\Http\Resources\PlatformResource;
use App\Http\Resources\Tournaments\Admin\TournamentMatchResource;
use App\Http\Resources\Tournaments\TournamentShowResource;
use App\Http\Resources\Tournaments\TournamentTypeResource;
use App\Http\Services\UploadService;
use App\Models\Currency;
use App\Models\Game;
use App\Models\Platform;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentType;
use App\Models\User;
use App\Notifications\TournamentScoreRejection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Match_;
use Throwable;
use function PHPUnit\Framework\isNull;

class TournamentMatchController extends Controller
{
    public function list()
    {

        try {

            return TournamentMatchResource::collection(TournamentMatch::with(
                ['userHome', 'userGuest', 'screenshotHome', 'screenshotGuest'])->orderBy('created_at', 'DESC')->get());

        } catch (Throwable $e) {

            report($e);

            return response()->json(['message' => 'Chyba při získávání seznamu zápasů'], 500);

        }

    }

    public function saveScore(TournamentSaveScoreRequest $request)
    {
        try {

            $userId = auth()->id();

            //Check if tournament is in progress
            $tournament = Tournament::where('slug', $request->slug)->where('tournament_status_id', 3)->first();

            if(!$tournament) {
                return response()->json(['message' => 'Do turnaje nelze zapisovat výsledky'], 400);
            }

            //Check if player is in tournament
            $tournamentMatch = $tournament->tournamentMatches()->where('bracket_position', $request->bracketPosition)->where(function ($query) use ($userId) {
                $query->where('user_home', $userId);
                $query->orWhere('user_guest', $userId);
            })->first();

            if(!$tournamentMatch) {
                return response()->json(['message' => 'Nejsi registrován v tomto turnaji'], 400);
            }

            //Check if player can save score
            $matchSide = $tournamentMatch->user_home === $userId ? 'home' : 'guest';

            $scoreSide = 'score_save_' . $matchSide;

            if (!is_null($tournamentMatch->$scoreSide)) {
                return response()->json(['message' => 'Výsledek je již zapsán'], 400);
            }

            //Save score
            if (is_null($tournamentMatch->score_home) && is_null($tournamentMatch->score_guest)) {

                $this->uploadScreenshot($request, $matchSide, $tournamentMatch, $scoreSaveSide);
                $tournamentMatch->score_home = $request->scoreHome;
                $tournamentMatch->score_guest = $request->scoreGuest;
                $tournamentMatch->$scoreSaveSide = Carbon::now();

                $tournamentMatch->save();

                return response()->json(['message' => 'Výsledek úspěšně zapsán']);

            }

            //Save score - confirmed
            if ($request->confirmed) {

                $scoreSaveSide = 'score_save_' . $matchSide;
                $tournamentMatch->$scoreSaveSide = Carbon::now();
                $tournamentMatch->save();

                return response()->json(['message' => 'Výsledek úspěšně zapsán']);
            }

            //Save score - reject
            if (!$request->confirmed) {

                $this->uploadScreenshot($request, $matchSide, $tournamentMatch, $scoreSaveSide);
                $tournamentMatch->$scoreSaveSide = Carbon::now();
                $tournamentMatch->save();

                $admins = User::where('is_admin', true)->get();

                Notification::sendNow($admins, new TournamentScoreRejection($tournamentMatch));

                return response()->json(['message' => 'Potvrzujeme reklamaci']);
            }

        } catch (Throwable $e) {

            report($e);
            return response()->json(['message' => 'Nastala chyba při zápisu výsledků'], 500);

        }
    }

    private function uploadScreenshot(Request $request, string $matchSide, $tournamentMatch, &$scoreSaveSide): void
    {
        $uploadService = new UploadService();
        $file = $request->file('screenshot');

        $image = $uploadService->uploadImage($file, "images/tournaments/$request->slug");

        $screenshotSide = 'screenshot_' . $matchSide;
        $tournamentMatch->$screenshotSide = $image->id;

        $scoreSaveSide = 'score_save_' . $matchSide;
    }

}
