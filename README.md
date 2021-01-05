liveusb
controller 이용 다국어 데모 사이트

현) 회원 가입시 이메일 인증 ,로그인, 본인 사진 등록 만 작업 되어짐

laravel 버전
8.*

설치순서
laravel 공홈 8 설치 방법 준수

.env의 내용중 'DB_XXX' 관련 내용을 사용하려는 디비 정보로 변경, 메일 ID,pw 입력


디비 마이그레이트 실행
php artisan migrate


smtp 설정(gmail 사용을 원할 경우)
https://medium.com/@agavitalis/how-to-send-an-email-in-laravel-using-gmail-smtp-server-53d962f01a0c
다른 smtp 설정시 메일 발송 부분 설정 필요

서버 실행
php artisan serve

사이트 접속
http://localhost:8000 접속


서비스 배포(추후 정리)
