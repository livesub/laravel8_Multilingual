<?php

namespace App\Helpers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use Validator;  //체크
use Illuminate\Support\Facades\Mail;    //메일 class
use App\Helpers\Custom\Messages_kr;    //한글 error 메세지 모음
use App\Helpers\Custom\Messages_en;    //영어 error 메세지 모음

class CustomUtils extends Controller
{
/*    안씀!!!
    //$request => 입력값, $name => 입력 필드 이름, $chk => 체크 형태 )
    public static function validator_chk($request, $name, $chk)
    {
        $validator = Validator::make($request, $chk);

return $validator;

//        if ($validator->fails()) return false;
//        else return true;
    }
*/
    //이메일 보내기 함수
    public static function email_send($email_blade, $user_name, $user_id, $subject, $data)
    {
        Mail::send(
            $email_blade,
            $data,
            //function($message) use ($to_name, $to_email) {
            function($message) use ($user_name, $user_id, $subject) {
                $message->to($user_id, $user_name)->subject($subject);
                $message->from("yskim@yongsanzip.com","김영여영11111");
            }
        );

        if(count(Mail::failures()) > 0){
            return false;
        }else{
            return true;
        }
    }

    //파일 경로를 반환 하는 함수
    public static function attachments_path($path = '')
    {
        //return public_path($path.($path ? DIRECTORY_SEPARATOR.$path : $path));
        return public_path($path);
    }

    public static function attachment_save($file,$path)
    {
        $file_name = time().filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);     //파일 이름 변환
        $file_ori_name = $file->getClientOriginalName();    //원본 파일 이름

        if (!$file->move(CustomUtils::attachments_path($path),$file_name)) {
            return ['false', $file_name, $file_ori_name];
        }else{
            return ['true', $file_name, $file_ori_name];
        }
    }

    public static function language_pack($type)
    {
        if($type == 'kr') $Messages = new Messages_kr;
        else $Messages = new Messages_en;

        return $Messages;
    }
}
