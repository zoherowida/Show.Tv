<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeriesTvCollection;
use App\LikeEpisodes;
use App\SeriesTv;
use App\Episode;
use App\FollowSeries;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\EpisodeCollection;
use Illuminate\Support\Facades\Auth;
use App\Enums\StateSeriesTv;
use App\Enums\StateEpisodes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image ;
class VueController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUser(Request $request){

        if ($request->isXmlHttpRequest()) {
            return response()->json([
                'result' => 1,
                'message' => 'success',
                'data' => [
                    'user' => auth::user(),
                ]
            ], 200);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => ['required'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->messages()->all();
            return response()->json(['result' => 0, 'message' => $errors[0], 'data' => []],200);
        }

        $image = $request->input('image'); // image base64 encoded
        preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
        $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
        $image = str_replace(' ', '+', $image);
        $imageName = 'image_' . time() . '.' . $image_extension[1]; //generating unique file name;

        file_put_contents(public_path() . '/image/' . $imageName, base64_decode($image));

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'image' => $imageName,
        ]);

        return response()->json([
            'result'=> 1,
            'message'=> 'Thank you for register on Show.TV',
            'data'=>''
        ],200);


    }

    /**
     * @param Request $request
     * @return SeriesTvCollection
     */
    public function SeriesTv(Request $request){

        if ($request->isXmlHttpRequest()) {
            if (SeriesTv::all()->count() > 5) {
                return new SeriesTvCollection(SeriesTv::all('title')->random(5));
            }
            return new SeriesTvCollection(SeriesTv::all('title')->random(SeriesTv::get()->count()));
        }

    }

    /**
     * @param Request $request
     * @return EpisodeCollection|array
     */
    public function EpisodeBySeries(Request $request){

        if ($request->isXmlHttpRequest()) {

            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:series_tvs,title',
            ]);
            if ($validator->fails()) {
                $errors = $validator->messages()->all();
                return response()->json(['result' => 0, 'message' => $errors[0], 'data' => []]);
            }

            $series = SeriesTv::where('title', $request->get('id'))->firstOrFail();


            $followCount = $series->FollowSeries->where('case', StateSeriesTv::Follow)->count();
            if (Auth::check()) {
                $caseUser = $series->FollowSeries->where('user_id', auth::user()->id)->first();
                $caseUser ? $caseUser = $caseUser->case : $caseUser = StateSeriesTv::UnFollow;

            } else {
                $caseUser = StateSeriesTv::UnFollow;
            }

            return response()->json([
                'result' => 1,
                'message' => 'success',
                'data' => [
                    'count' => $followCount,
                    'caseUser' => $caseUser,
                    'episodes' => Episode::where('seriesTv_id', $series->id)->get(['id', 'title', 'thumbnail'])
                ]
            ], 200);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function EpisodeById(Request $request)
    {

        if ($request->isXmlHttpRequest()) {
            $episode = Episode::where('title', $request->get('id'))->firstOrFail();

            $likeCount = $episode->LikeEpisodes->where('case', StateEpisodes::Like)->count();
            if (Auth::check()) {
                $caseUser = $episode->LikeEpisodes->where('user_id', auth::user()->id)->first();
                $caseUser ? $caseUser = $caseUser->case : $caseUser = StateEpisodes::DisLike;
            } else {
                $caseUser = StateEpisodes::DisLike;
            }

            return response()->json([
                'result' => 1,
                'message' => 'success',
                'data' => [
                    'count' => $likeCount,
                    'caseUser' => $caseUser,
                    'episode' => $episode
                ]
            ], 200);

        }
    }

    /**
     * @return EpisodeCollection
     */
    public function EpisodesAll(){

        return new EpisodeCollection(Episode::with('SeriesTv')->orderBy('id', 'desc')->get());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ChangeFollowingSeriesTv(Request $request){
        if ($request->isXmlHttpRequest()) {

            if (Auth::check()) {
                $series = SeriesTv::where('title', $request->get('id'))->firstOrFail();
                $followSeriesQuery = FollowSeries::class;
                $oldCase = $followSeriesQuery::where([['user_id', auth::user()->id], ['seriesTv_id', $series->id]])->first();
                $oldCase ? $oldCase = $oldCase->case : $oldCase = 0;
                $followSeriesQuery::updateOrCreate(
                    [
                        'user_id' => auth::user()->id,
                        'seriesTv_id' => $series->id
                    ],
                    [
                        'case' => $oldCase == 1 ? 0 : 1
                    ]);
                $caseUser = $series->FollowSeries->where('user_id', auth::user()->id)->first()->case;
                $followCount = $series->FollowSeries->where('case', StateSeriesTv::Follow)->count();
                return response()->json([
                    'result' => 1,
                    'message' => 'success',
                    'data' => [
                        'count' => $followCount,
                        'caseUser' => $caseUser
                    ]
                ], 200);

            } else {
                return response()->json([
                    'result' => 0,
                    'message' => 'error',
                ], 403);

            }
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ChangeLikeEpisodes(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if (Auth::check()) {
                $episode = Episode::where('title', $request->get('id'))->firstOrFail();
                $likeCountQuery = LikeEpisodes::class;
                $oldCase = $likeCountQuery::where([['user_id', auth::user()->id], ['episodes_id', $episode->id]])->first();
                $oldCase ? $oldCase = $oldCase->case : $oldCase = 0;
                $likeCountQuery::updateOrCreate(
                    [
                        'user_id' => auth::user()->id,
                        'episodes_id' => $episode->id
                    ],
                    [
                        'case' => $oldCase == 1 ? 0 : 1
                    ]);
                $caseUser = $episode->LikeEpisodes->where('user_id', auth::user()->id)->first()->case;
                $likeCount = $episode->LikeEpisodes->where('case', StateEpisodes::Like)->count();

                return response()->json([
                    'result' => 1,
                    'message' => 'success',
                    'data' => [
                        'count' => $likeCount,
                        'caseUser' => $caseUser
                    ]
                ], 200);

            } else {
                return response()->json([
                    'result' => 0,
                    'message' => 'error',
                ], 403);

            }
        }
    }
}
