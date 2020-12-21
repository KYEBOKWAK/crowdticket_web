//저장된 state_app 값
//export const STATE_APP_NONE = "STATE_APP_NONE" as const; //초기 상태

//서버와 값이 같아야함.

//////여긴 웹 타입
export const WEB_PAGE_KEY_HOME = "WEB_PAGE_KEY_HOME"; //홈
export const WEB_PAGE_KEY_WELCOME = "WEB_PAGE_KEY_WELCOME";
export const WEB_PAGE_KEY_STORE_MAIN = "WEB_PAGE_KEY_STORE_MAIN"; //스토어 메인
//////하단은 앱 타입
//MAIN STATE START
export const STATE_APP_NONE = "STATE_APP_NONE"; //빈상태
export const STATE_APP_INIT = "STATE_APP_INIT"; //초기 상태
export const STATE_APP_LOGIN = "STATE_APP_LOGIN"; //로그인 화면
export const STATE_APP_LOGIN_EMAIL = "STATE_APP_LOGIN_EMAIL"; //이메일 로그인
export const STATE_APP_REGISTER_EMAIL = "STATE_APP_REGISTER_EMAIL"; //이메일 회원가입
export const STATE_APP_JOIN_EMAIL = "STATE_APP_JOIN_EMAIL"; //이메일 회원가입
export const STATE_APP_EMAIL_CHECK = "STATE_APP_EMAIL_CHECK"; //이메일 체크

export const STATE_APP_PASSWORD_FIND = "STATE_APP_PASSWORD_FIND"; //비번 찾기

export const STATE_APP_PHONE_CHECK = "STATE_APP_PHONE_CHECK"; //폰 체크
export const STATE_APP_PHONE_VALID_CHECK = "STATE_APP_PHONE_VALID_CHECK"; //폰 체크
export const STATE_APP_USER_NAME = "STATE_APP_USER_NAME"; //유저 이름

export const STATE_APP_SET_USER_MORE_INFO = "STATE_APP_SET_USER_MORE_INFO"; //유저 추가 정보 입력

export const STATE_APP_TERMS_AGREE = "STATE_APP_TERMS_AGREE"; //이용 약관 동의

export const STATE_APP_EMAIL_FIND = "STATE_APP_EMAIL_FIND"; //이메일 찾기
export const STATE_APP_EMAIL_FIND_RESULT = "STATE_APP_EMAIL_FIND_RESULT";  //이메일 찾기 결과 화면

// export const STATE_APP_INTRO_MAIN = "STATE_APP_INTRO_MAIN";  //mainview가기 전 인트로 뷰  //로딩화면에 타입으로 간다.

export const STATE_APP_MAIN = "STATE_APP_MAIN";
//MAIN STATE END

//HOME STATE START
//GNB TOP KEY
export const STATE_HOME_KEY_FEED = 'STATE_HOME_KEY_FEED';
export const STATE_HOME_KEY_MEETUP = 'STATE_HOME_KEY_MEETUP';
export const STATE_HOME_KEY_MEET = 'STATE_HOME_KEY_MEET';
export const STATE_HOME_KEY_EVENT = 'STATE_HOME_KEY_EVENT';
export const STATE_HOME_KEY_TICKET = 'STATE_HOME_KEY_TICKET';
//HOME STATE END

//click detail project
export const PAGE_KEY_DETAIL_PROJECT = 'PAGE_KEY_DETAIL_PROJECT';
export const PAGE_KEY_DETAIL_COMMENT = 'PAGE_KEY_DETAIL_COMMENT';

export const PAGE_KEY_DETAIL_COMMENT_MANNAYO = 'PAGE_KEY_DETAIL_COMMENT_MANNAYO';

export const PAGE_KEY_EVENT_SELECT_VIEW = 'PAGE_KEY_EVENT_SELECT_VIEW';
export const PAGE_KEY_PAY_VIEW = 'PAGE_KEY_PAY_VIEW';
export const PAGE_KEY_PAY_WEB_VIEW = 'PAGE_KEY_PAY_WEB_VIEW';
export const PAGE_KEY_POST_CODE_VIEW = 'PAGE_KEY_POST_CODE_VIEW';
export const PAGE_KEY_PAY_COMPLITE_VIEW = 'PAGE_KEY_PAY_COMPLITE_VIEW';
export const PAGE_KEY_SURVEY_DETAIL_VIEW = 'PAGE_KEY_SURVEY_DETAIL_VIEW';

export const PAGE_KEY_MORE_MANNAYO_VIEW = 'PAGE_KEY_MORE_MANNAYO_VIEW';

export const PAGE_KEY_MANNAYO_DETAIL_VIEW = 'PAGE_KEY_MANNAYO_DETAIL_VIEW';
//

export const PAGE_KEY_COMMENTS_COMMENT_VIEW = 'PAGE_KEY_COMMENTS_COMMENT_VIEW';

export const PAGE_KEY_CREATE_MANNAYO_COVER_VIEW = 'PAGE_KEY_CREATE_MANNAYO_COVER_VIEW';

export const PAGE_KEY_CREATE_MANNAYO_WHO_FIND_CREATOR_VIEW = 'PAGE_KEY_CREATE_MANNAYO_WHO_FIND_CREATOR_VIEW';

export const PAGE_KEY_FIND_VIEW = 'PAGE_KEY_FIND_VIEW';  //크리에이터 찾기

export const PAGE_KEY_CREATE_INPUT_CHANNEL_FIND_VIEW = 'PAGE_KEY_CREATE_INPUT_CHANNEL_FIND_VIEW';

export const PAGE_KEY_CREATE_MANNAYO_SELECT_VIEW = 'PAGE_KEY_CREATE_MANNAYO_SELECT_VIEW';

export const PAGE_KEY_CREATE_MANNAYO_SELECT_LOCATION_VIEW = 'PAGE_KEY_CREATE_MANNAYO_SELECT_LOCATION_VIEW';

export const PAGE_KEY_CREATE_MANNAYO_WHAT_VIEW = 'PAGE_KEY_CREATE_MANNAYO_WHAT_VIEW';

export const PAGE_KEY_CREATE_MANNAYO_EXAMPLE_VIEW = 'PAGE_KEY_CREATE_MANNAYO_EXAMPLE_VIEW';

export const PAGE_KEY_MANNAYO_OVERLAP_POPUP_VIEW = 'PAGE_KEY_MANNAYO_OVERLAP_POPUP_VIEW';

export const PAGE_KEY_MANNAYO_LIST_POPUP_VIEW = 'PAGE_KEY_MANNAYO_LIST_POPUP_VIEW';

export const PAGE_KEY_MY_PROFILE_EDIT_VIEW = 'PAGE_KEY_MY_PROFILE_EDIT_VIEW';

export const PAGE_KEY_MY_PROFILE_RECEIPT_VIEW = 'PAGE_KEY_MY_PROFILE_RECEIPT_VIEW';

export const PAGE_KEY_MEETUP_LIST_POPUP_VIEW = 'PAGE_KEY_MEETUP_LIST_POPUP_VIEW';

export const PAGE_KEY_FIND_ALL_VIEW = 'PAGE_KEY_FIND_ALL_VIEW';  //모두 찾기

export const PAGE_KEY_E_TICKET_VIEW = 'PAGE_KEY_E_TICKET_VIEW';  //모두 찾기

export const PAGE_KEY_PRIVACY_TERMS_VIEW = 'PAGE_KEY_PRIVACY_TERMS_VIEW';  //모두 찾기

export const PAGE_KEY_CHATTING_ROOM_VIEW = 'PAGE_KEY_CHATTING_ROOM_VIEW';  //채팅룸

export const PAGE_KEY_CHATTING_USER_LIST_VIEW = 'PAGE_KEY_CHATTING_USER_LIST_VIEW';


export const PAGE_KEY_ALERT_VIEW = 'PAGE_KEY_ALERT_VIEW';

export const PAGE_KEY_E_TICKET_SELECT_VIEW = "PAGE_KEY_E_TICKET_SELECT_VIEW";

export const PAGE_KEY_CHATTING_ENTER_VIEW = "PAGE_KEY_CHATTING_ENTER_VIEW";

export const PAGE_KEY_SETUP_VIEW = "PAGE_KEY_SETUP_VIEW";
export const PAGE_KEY_DEVICE_MANAGER_VIEW = "PAGE_KEY_DEVICE_MANAGER_VIEW";
export const PAGE_KEY_PERSONAL_INFO_EDIT_VIEW = "PAGE_KEY_PERSONAL_INFO_EDIT_VIEW";
export const PAGE_KEY_WEB_VIEW_KAKAO_CHANNEL = "PAGE_KEY_WEB_VIEW_KAKAO_CHANNEL";

export const PAGE_KEY_CONTECT_EMAIL_VIEW = "PAGE_KEY_CONTECT_EMAIL_VIEW";
export const PAGE_KEY_ALARM_SETUP_VIEW = "PAGE_KEY_ALARM_SETUP_VIEW";

export const PAGE_KEY_MAGAZINE_DETAIL_VIEW = "PAGE_KEY_MAGAZINE_DETAIL_VIEW";
export const PAGE_KEY_MAGAZINE_LIST_VIEW = "PAGE_KEY_MAGAZINE_LIST_VIEW";

export const PAGE_KEY_SURVEY_EDIT_VIEW = "PAGE_KEY_SURVEY_EDIT_VIEW";

export const PAGE_KEY_COMPANY_INFO_VIEW = "PAGE_KEY_COMPANY_INFO_VIEW";

export const WEB_PAGE_KEY_STORE_HOME = "WEB_PAGE_KEY_STORE_HOME";
export const WEB_PAGE_KEY_STORE_DETAIL = "WEB_PAGE_KEY_STORE_DETAIL";

export const WEB_STORE_PAGE_HOME = "WEB_STORE_PAGE_HOME";
export const WEB_STORE_PAGE_DETAIL = "WEB_STORE_PAGE_DETAIL";

export const WEB_STORE_PAGE_MANAGER = "WEB_STORE_PAGE_MANAGER";

export const WEB_STORE_REVIEW_WRITE = "WEB_STORE_REVIEW_WRITE";

export const WEB_STORE_ITEM_DETAIL = "WEB_STORE_ITEM_DETAIL";

export const WEB_STORE_ORDER_PAGE = "WEB_STORE_ORDER_PAGE";
export const WEB_STORE_ORDER_COMPLITE_PAGE = "WEB_STORE_ORDER_COMPLITE_PAGE";

export const WEB_MY_CONTENTS_PAGE = "WEB_MY_CONTENTS_PAGE";
export const WEB_STORE_ITEM_ADD_PAGE = "WEB_STORE_ITEM_ADD_PAGE";

export const WEB_STORE_DETAIL_RECEIPT = "WEB_STORE_DETAIL_RECEIPT";

export const WEB_STORE_CONTENT_CONFIRM = "WEB_STORE_CONTENT_CONFIRM";

export const WEB_STORE_ISP_ORDER_COMPLITE_PAGE = "WEB_STORE_ISP_ORDER_COMPLITE_PAGE";

export const WEB_EVENT_PAGE = "WEB_EVENT_PAGE";