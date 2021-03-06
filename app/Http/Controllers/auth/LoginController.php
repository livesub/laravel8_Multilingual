<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;  //체크
use App\Models\User;    //모델 정의
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
//use App\Helpers\Custom\Messages_kr;    //error 메세지 모음
use Illuminate\Support\Facades\Auth;    //인증

class LoginController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        //로그인 된 상태에선 이페이지 못열게
        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function index()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        return view('auth.login',$Messages::$blade_ment['login']['message']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**************************************************************************/
     /* $user_pw 을 사용 하면 로그인이 되지 않으므로 칼럼명을 password 로 바꾼다 */
     /**************************************************************************/

    public function store(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $user_id = $request->get('user_id');
        $user_pw = $request->get('user_pw');
        $remember = $request->has('remember');

        Validator::validate($request->all(), [
            'user_id'  => ['required', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/', 'max:200'],
            'user_pw'  => ['required', 'string', 'min:6', 'max:16'],
        ], $Messages::$login_Validator['login_Validator']['message']);

        $credentials = [
            'user_id' => trim($user_id),
            'password' => $user_pw,
        ];

        if (!Auth::attempt($credentials, $remember))
        {
            return redirect()->route('main.index')->with('alert_messages', $Messages::$login_chk['login_chk']['message']['login_chk']);
            exit;
        }

        //이메일 인증이 안됬으면 로그아웃 시킴
        if(!auth()->user()->user_activated)
        {
            auth()->logout();
            return redirect()->route('main.index')->with('alert_messages', $Messages::$login_chk['login_chk']['message']['email_chk']);
            exit;
        }

        return redirect()->route('main.index')->with('alert_messages', $Messages::$login_chk['login_chk']['message']['login_ok']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));
        auth()->logout();
        return redirect()->route('main.index')->with('alert_messages', $Messages::$logout_chk['logout']['message']['logout']);
        exit;
    }
}
