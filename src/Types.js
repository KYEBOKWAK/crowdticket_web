import * as GlobalTypes from "./GlobalKeys";

// interface ITypes {
//   login: any,
//   loading: any,
//   ticketingSlide: any,
//   toastMessage: any,
//   mannayo_sort: any,
//   project_sort: any,
//   project_list_type: any,
//   refresh: any,
//   comment: any,
//   mannayo_type_view: any,
//   mannayo_list: any,
//   mannayo_collect: any,
//   main_view_type: any,
//   myPage_MenuBarTypes: any,
//   order: any,
//   pay_method: any,
//   order_commision: any,
//   like: any,
//   fine: any,
//   gender: any,
//   res: any,
//   find_email: any,
//   directOpen: any,
//   socket: any,
//   chatMessage: any,
//   chatSynchronize: any,
//   chatMessageState: any,
//   alertButtons: any,
//   rooms: any,
//   project: any
// }

const Types = {
  table_type: {
    none: 'none',
    total_payment: 'total_payment'  //하단에 총합계가 나오는 ui 구성
  },
  table_columns_type: {
    price: 'price'
  },
  event_target_type: {
    store_item: 'store_item'
  },
  store_ready_state: {
    none: 0,
    default: 1,
    product_upload: 2
  },
  product_categorys: [
    {
      type: 'video',
      text: '영상',
      subText: '제공 콘텐츠',
      product_state: 1
    },
    {
      type: 'image',
      text: '이미지',
      subText: '제공 콘텐츠',
      product_state: 1
    },
    {
      type: 'text',
      text: '텍스트',
      subText: '위주 콘텐츠',
      product_state: 0
    },
    {
      type: 'live',
      text: '실시간',
      subText: '진행 콘텐츠',
      product_state: 2
    },
    {
      type: 'sound',
      text: '음성',
      subText: '제공 콘텐츠',
      product_state: 1
    },
    {
      type: 'etc',
      text: '기타',
      subText: '형식 콘텐츠',
      product_state: 1
    },
  ],
  product_state: {
    TEXT: 0,
    FILE: 1,
    ONE_TO_ONE: 2
  },
  file_upload_target_type: {
    orders_items: 'orders_items',
    items: 'items',
    product_file: 'product_file',
    items_images: 'items_images'
  },
  file_upload_state: {
    NONE: 0,
    IMAGE: 1,
    FILES: 2
  },
  store_home_item_list: {
    POPUALER: 'POPUALER',
    NEW_UPDATE: 'NEW_UPDATE',
    IN_ITEM: 'IN_ITEM'
  },
  item_limit_state: {
    UNLIMIT: 'UNLIMIT',
    LIMIT: 'LIMIT'
  },
  save_img: {
    user: 'SAVE_IMG_USER',
    item: 'SAVE_IMG_ITEM',
  },
  add_page_state: {
    ADD: 'ADD_PAGE_STATE_ADD',
    EDIT: 'ADD_PAGE_STATE_EDIT'
  },
  store_manager_state_order: {
    NONE: 'NONE',     //상점관리에서 상품 순서 state
    REORDER: 'REORDER'
  },

  reorder_type: {
    UP: 'UP',
    DOWN: 'DOWN'
  },
  item_state: {
    SALE: 0,
    SALE_STOP: 1,
    SALE_PAUSE: 2,
    SALE_LIMIT: 3
  },
  project: {
    STATE_READY: 1,
    STATE_READY_AFTER_FUNDING: 2,
    STATE_UNDER_INVESTIGATION: 3,
    STATE_APPROVED: 4,

    EVENT_TYPE_DEFAULT: 0, //기본 타입
    EVENT_TYPE_INVITATION_EVENT: 1,   //이벤트 타입(초대권)
    EVENT_TYPE_CRAWLING: 2,  //크롤링된 이벤트
    EVENT_TYPE_PICK_EVENT: 3,  //pick 이벤트

    EVENT_TYPE_SUB_DEFAULT: 0,
    EVENT_TYPE_SUB_SANDBOX_PICK: 1,  //샌드박스 전용 pick 이벤트
    EVENT_TYPE_SUB_SECRET_PROJECT: 2,//URL 통해서만 들어올 수 있는 프로젝트. 더보기에 공개 안됨

    PICK_STATE_NONE: 0,  //pick 상태
    PICK_STATE_PICKED: 1,  //pick 완료 상태

    IS_PAY_DEFAULT: 0, //기본값
    IS_PAY_ACCOUNT: 1, //무통장 계좌이체 추가 옵션(루디 이슈)
  },
  rooms: {
    BEFORE_ENTER: 'BEFORE_ENTER',
    ENTER: 'ENTER',
    LIKE_LIST: 'LIKE_LIST',
    CHATTING_ROOM: 'CHATTING_ROOM'
  },
  alertButtons: {
    cancel: "cancel",
    general: 'general'
  },
  socket: {
    SK_JOIN_CHATTING_ROOM: "SK_JOIN_CHATTING_ROOM",
    SK_ENTER_CHATTING_ROOM: "SK_ENTER_CHATTING_ROOM",
    SK_LEAVE_CHATTING_ROOM: "SK_LEAVE_CHATTING_ROOM",
    SK_SEND_CHATTING_MESSAGE: "SK_SEND_CHATTING_MESSAGE",
    SK_RECEIVE_CHATTING_MESSAGE: "SK_RECEIVE_CHATTING_MESSAGE",
    SK_DISCONNECT_CHAT_ROOM: "SK_DISCONNECT_CHAT_ROOM",
    SK_CONNECT_CHAT_ROOM: "SK_CONNECT_CHAT_ROOM",

    SK_CHAT_SYNC_REPEAT: "SK_CHAT_SYNC_REPEAT"
  },
  chatMessage: {
    MESSAGE_ENTER: "MESSAGE_ENTER",
    MESSAGE_LEAVE: "MESSAGE_LEAVE",
    MESSAGE_DATE_TIME: "MESSAGE_DATE_TIME", //날짜 다를시 나타내는 메시지
    MESSAGE: "MESSAGE",
  },
  chatSynchronize: {
    no_message: "no_message",
    synchronizing: "synchronizing",
    synchronizing_success: "synchronizing_success"
  },
  chatMessageState: {
    success: "success",
    no_sync: "no_sync"
  },
  gender: {
    m: 'm', //남자
    f: 'f'  //여자
  },
  login: {
    email: "email",
    facebook: "facebook",
    google: "google",
    kakao: "kakao",
    apple: "apple"
  },
  loading: {
    DEFAULT: "DEFAULT",
    INTRO_MAIN: "INTRO_MAIN"
  },
  ticketingSlide:{
    FEED_EVENT: "FEED_EVENT",
    MEETUP: "MEETUP",
    LIKE_MEETUP_HIGH: "LIKE_MEETUP_HIGH",
    LIKE_MEETUP: "LIKE_MEETUP",
    LIKE_MANNAYO: "LIKE_MANNAYO"
  },
  comment: {
    componentType: {
      detail: 'detail',
      moreList: 'moreList',
      commentsComment: 'comment',
      bottomBar: 'bottomBar',
      mannayoItem: 'mannayoItem',
      defaultItem: 'defaultItem',
      projectItem: 'projectItem'
    },
    commentType: {
      project: 'project',
      commentsComment: 'comment',
      mannayo: 'mannayo',
      store: 'store'
    },
    secondTargetType: {
      store_order: 'store_order'
    },
    commentState: {
      write: 'WRITE',
      edit: 'EDIT'
    }
  },
  toastMessage: {
    TOAST_TYPE_NONE: 0,
    TOAST_TYPE_CONNECT_TICKETING: 1
  },
  mannayo_sort:{
    MANNAYO_SORT_TYPE_POPUALER: "MANNAYO_SORT_TYPE_POPUALER",
    MANNAYO_SORT_TYPE_NEW: "MANNAYO_SORT_TYPE_NEW",
    MANNAYO_SORT_TYPE_MY_ALL: "MANNAYO_SORT_TYPE_MY_ALL", //내가 만나요 한 모든 만나요
    MANNAYO_SORT_TYPE_MY_REGISTER: "MANNAYO_SORT_TYPE_MY_REGISTER"  //내가 등록한 만나요
  },
  project_sort: {
    PROJECT_SORT_NONE: "PROJECT_SORT_NONE"
  },
  project_list_type: {
    PROJECT_LIST_ALL: "PROJECT_LIST_ALL",
    PROJECT_LIST_TICKETING: "PROJECT_LIST_TICKETING",
    PROJECT_LIST_FIND: "PROJECT_LIST_FIND",
    PROJECT_LIST_LIKE: "PROJECT_LIST_LIKE"
  },
  refresh: {
    NONE: "NONE",
    MAIN_HOME: "MAIN_HOME",
    MAIN_MEETUP: "MAIN_MEETUP",
    MAIN_MANNAYO: "MAIN_MANNAYO",
    MAIN_EVENT: "MAIN_EVENT",
    MAIN_MANNAYO_ITEM: "MAIN_MANNAYO_ITEM",
    MAIN_MANNAYO_ITEM_REMOVE: "MAIN_MANNAYO_ITEM_REMOVE",
    COMMENT_REFRESH: "COMMENT_REFRESH",
    COMMENT_REFRESH_DELETE: "COMMENT_REFRESH_DELETE",
    COMMENT_ALLCOUNT: "COMMENT_ALLCOUNT",
    MY_PROFILE_IMAGE: "MY_PROFILE_IMAGE",
    MY_NICK_NAME: "MY_NICK_NAME",
    NOTICE_PUSH: "NOTICE_PUSH",
    FEED_TICKET_COUNTER: "FEED_TICKET_COUNTER",
    CHATTING_ROOM_OPEN: "CHATTING_ROOM_OPEN",

    MYPAGE_MEETUP: "MYPAGE_MEETUP",
    MYPAGE_MANNAYO: "MYPAGE_MANNAYO",
    MYPAGE_LIKE: "MYPAGE_LIKE",
    MYPAGE_CHATTING: "MYPAGE_CHATTING",

    PUSH_NOTICE_ALARM: "PUSH_NOTICE_ALARM",
    PUSH_CHAT_ROOM: "PUSH_CHAT_ROOM",

    CHATTING_USER_LIST: "CHATTING_USER_LIST",
    CHATTING_LIST_ITEM: "CHATTING_LIST_ITEM",

    CHATTING_VIEW_LIST: "CHATTING_VIEW_LIST"
  },
  mannayo_type_view: {
   POPUALER: "POPUALER",
   CREATE_COVER: "CREATE_COVER"
  },
  mannayo_list:{
    TYPE_MANNAYO_LIST_NONE: "TYPE_MANNAYO_LIST_NONE",
    TYPE_MANNAYO_LIST_MORE_BUTTON: "TYPE_MANNAYO_LIST_MORE_BUTTON",
    TYPE_MANNAYO_LIST_LIKE_MORE_BUTTON: "TYPE_MANNAYO_LIST_LIKE_MORE_BUTTON",
    TYPE_MANNAYO_LIST_FIND_MORE_BUTTON: "TYPE_MANNAYO_LIST_FIND_MORE_BUTTON",
    TYPE_MANNAYO_LIST_COLLECT_CREATOR: "TYPE_MANNAYO_LIST_COLLECT_CREATOR",
    TYPE_MANNAYO_LIST_COLLECT_MCN: "TYPE_MANNAYO_LIST_COLLECT_MCN",
    TYPE_MANNAYO_LIST_COLLECT_LOCAL: "TYPE_MANNAYO_LIST_COLLECT_LOCAL",
  },
  mannayo_collect: {
    KEY_COLLECT_TAB_CREATOR: 'KEY_COLLECT_TAB_CREATOR',
    KEY_COLLECT_TAB_MCN: 'KEY_COLLECT_TAB_MCN',
    KEY_COLLECT_TAB_LOCAL: 'KEY_COLLECT_TAB_LOCAL',
    KEY_COLLECT_CREATE_CREATOR: 'KEY_COLLECT_CREATE_CREATOR'
  },
  main_view_type: {
    MAIN_VIEW_HOME: "MAIN_VIEW_HOME",
    MAIN_VIEW_CHAT: "MAIN_VIEW_CHAT",
    MAIN_VIEW_ALARM: "MAIN_VIEW_ALARM",
    MAIN_VIEW_MYPAGE: "MAIN_VIEW_MYPAGE"
  },
  myPage_MenuBarTypes:[
    {
      key: GlobalTypes.MYPAGE_TAB_BAR_MEETUP,
      text: "이벤트"
    },
    // {
    //   key: GlobalTypes.MYPAGE_TAB_BAR_MANNAYO,
    //   text: "만나요"
    // },
    {
      key: GlobalTypes.MYPAGE_TAB_BAR_LIKE,
      text: "좋아요"
    }
  ],

  order: {
    ORDER_STATE_STAY: 0, //결제 대기 상태 예전 주문정보고 있기 때문에 스탠바이 state를 별도 추가
    ORDER_STATE_PAY: 1,   //결제 혹은 결제대기
    ORDER_STATE_PAY_NO_PAYMENT: 2,   //order 는 들어갔지만, 결제 프로세를 안탐
    ORDER_STATE_PAY_SCHEDULE: 3,
    ORDER_STATE_PAY_SCHEDULE_RESULT_FAIL: 4,
    ORDER_STATE_PAY_SUCCESS_NINETY_EIGHT: 5, //98번 오더인데 결제 떨어짐.
    //ORDER_STATE_PAY_SUCCESS_SCHEDULE_NINETY_EIGHT: 6,
    ORDER_STATE_PAY_ACCOUNT_STANDBY: 6,
    ORDER_STATE_PAY_ACCOUNT_SUCCESS: 7,
    
    ORDER_STATE_APP_PAY_WAIT: 8, //앱 결제 진행시, 스탠바이. //30분 동안 결제 처리가 되지 않으면 자동 취소
    ORDER_STATE_APP_PAY_COMPLITE: 9,  //앱 결제 완료
    ORDER_STATE_APP_PAY_IAMPORT_WEBHOOK_VERIFY_COMPLITE: 10,  //앱 2차 iamport webhook 검증 완료
    ORDER_STATE_APP_PAY_WAIT_VBANK: 11, //앱 결제 진행시, 스탠바이. //30분 동안 결제 처리가 되지 않으면 자동 취소
    // ORDER_STATE_APP_PAY_COMPLITE_WAIT_SURVEY: 12, //결제는 끝났는데, 설문이 아직남음.
    // ORDER_STATE_APP_PAY_COMPLITE_AND_SURVEY_COMPLITE: 13, //결제도 끝나고 설문도 끝남.
    ORDER_STATE_APP_STORE_PAYMENT: 12,    //컨텐츠 상점 결제 완료 및 대기
    ORDER_STATE_APP_STORE_READY: 13,  //컨텐츠 상점 준비단계
    ORDER_STATE_APP_STORE_SUCCESS: 14,  //컨텐츠 상점 컨텐츠 완성. 크티에 보냄
    ORDER_STATE_APP_STORE_RELAY_CUSTOMER: 15,  //컨텐츠 고객에게 보냄
    ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE: 16,  //고객 콘텐츠 확인함.

    ORDER_STATE_APP_STORE_STANBY: 17, //isp 결제 대기 상태 24시간 뒤에도 ORDER_STATE_APP_STORE_STANBY 라면 취소된다.

    ORDER_STATE_APP_STORE_PLAYING_CONTENTS: 18, //1:1 콘텐츠 진행중

    ORDER_STATE_STANDBY_START: 98,
    ORDER_STATE_PAY_END: 99,
    //ORDER_STATE_SCHEDULE_PAY: 2, //예약결제 //결제 상태는 하나로 통합. 프로젝트의 타입에 따라서 구분한다.

    ORDER_STATE_CANCEL_START: 100, //취소사유는 100~200
    ORDER_STATE_PROJECT_CANCEL: 102,   //프로젝트 중도 취소
    ORDER_STATE_PROJECT_PICK_CANCEL: 103,  //추첨 안됨.
    ORDER_STATE_PAY_ACCOUNT_NO_PAY: 104,  //미입금으로 취소
    ORDER_STATE_CANCEL_ACCOUNT_PAY: 105, //계좌이체인데 고객이 취소누름.
    ORDER_STATE_CANCEL_WAIT_PAY: 106, //앱 결제 진행중 10분 초과로 인한 취소

    ORDER_STATE_CANCEL_STORE_RETURN: 107, //스토어 반려
    ORDER_STATE_CANCEL_STORE_WAIT_OVER: 108, //스토어 승인기간 만료됨

    ORDER_STATE_APP_STORE_STANBY_AUTO_CANCEL: 109,  //24시간이 지나면 취소처리 됨.

    ORDER_STATE_CANCEL: 199,//고객취소는 맨 마지막

    ORDER_STATE_HOST_SHOW_ORDER_END: 200,

    ORDER_STATE_ERROR_START: 500,
    ORDER_STATE_ERROR_PAY: 501,
    ORDER_STATE_ERROR_NO_INFO_IAMPORT: 502,
    ORDER_STATE_ERROR_TICKET_OVER_COUNT: 503,
    ORDER_STATE_ERROR_NO_PAY_NINETY_EIGHT: 504,  //98번 오더값인데 결제 정보가 없음(결제 안됨)
    ORDER_STATE_ERROR_NO_PAY_NO_IMP_INFO_NINETY_EIGHT: 505,  //98번 오더값인데 결제 정보가 없음(결제 안됨)
    ORDER_STATE_ERROR_GOODS_OVER_COUNT: 506,

    ORDER_STATE_ERROR_IAMPORT_WEBHOOK_ERROR: 507,
    ORDER_STATE_ERROR_IAMPORT_WEBHOOK_NONE: 508,  //iamport 웹훅 state가 아무값도 아닐때

    ORDER_STATE_APP_STORE_STANBY_FAIL: 509,

    ORDER_STATE_ERROR_END: 600,

    ORDER_STATE_STANDBY: 999,

    //ORDER_PROCESS_STATE_INIT: 1,
    //ORDER_PROCESS_STATE_: 2,

    // ORDER_TYPE_COMMISION_WITH_COMMISION: 0,  //커미션이 있는 오더 //env값으로 뺌
    // ORDER_TYPE_COMMISION_WITHOUT_COMMISION: 1, //커미션이 없는 오더

    ORDER_PAY_TYPE_CARD: 0,
    ORDER_PAY_TYPE_ACCOUNT: 1,
  },
  order_commision: {
    ORDER_TYPE_COMMISION_WITH_COMMISION: 0,  //커미션이 있는 오더 //env값으로 뺌
    ORDER_TYPE_COMMISION_WITHOUT_COMMISION: 1 //커미션이 없는 오더
  },
  pay_method : {
    PAY_METHOD_TYPE_CARD: "card", //신용카드
    PAY_METHOD_TYPE_CARD_INPUT: "card_input", //신용카드 input인데 실제론 안씀
    PAY_METHOD_TYPE_VBANK: "vbank", //가상계좌
    PAY_METHOD_TYPE_PHONE: "phone", //휴대폰소액결제
    PAY_METHOD_TYPE_FREE: "free" //휴대폰소액결제
  },
  like:{
    LIKE_MANNAYO: "LIKE_MANNAYO",
    LIKE_PROJECT: "LIKE_PROJECT",
    LIKE_COMMENT: "LIKE_COMMENT",
    LIKE_CHAT: "LIKE_CHAT"
  },
  fine:{
    CREATOR: "CREATOR",
    ALL: "ALL"
  },
  res: {
    //SUCCESS RES
    RES_SUCCESS_START: 0,

    RES_SUCCESS: 1,
    RES_SUCCESS_LOGIN_SNS_ALREADY_FACEBOOK: 2,
    RES_SUCCESS_LOGIN_SNS_ALREADY_GOOGLE: 3,
    RES_SUCCESS_LOGIN_SNS_ALREADY_KAKAO: 4,
    RES_SUCCESS_LOGIN_SNS_ALREADY_APPLE: 5,

    RES_SUCCESS_END: 999,

    //ERROR RES
    RES_ERROR_START: 1000,

    RES_ERROR: 1001,
    RES_ERROR_ALREADY_EMAIL_REGISTER: 1002,
    RES_ERROR_ALREADY_SNS_REGISTER: 1003,

    RES_ERROR_END: 9999
  },
  find_email:{
    none: 'none',
    email: 'email',
    sns: 'sns',
    email_sns: "email_sns" 
  },
  directOpen: {
    MAIN_HOME: {
      NONE: 0,
      HOME: 1,
      MEETUP: 2,
      MANNAYO: 3,
      EVENT: 4
    },
    MAIN_BOTTOM: {
      NONE: 0,
      HOME: 1,
      CHAT: 2,
      ALARM: 3,
      MYPAGE: 4
    },
    PAGE: {
      NONE: 0,
      PROJECT_DETAIL: 1,
      MANNAYO_DETAIL: 2,
      MYPAGE_DETAIL: 3,
      MANNAYO_MAKE: 4,
      MY_TICKET: 5
    }
  },
  agree: {
    all: 'AGREE_TYPE_ALL',
    refund: 'AGREE_TYPE_REFUND',
    terms_useInfo: 'AGREE_TERMS_USEINFO',
    third: 'AGREE_TYPE_THIRD'
  }
};

export default Types;