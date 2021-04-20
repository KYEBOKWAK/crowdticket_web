'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import axios from './lib/Axios';
import Types from './Types';

import Profile from './component/Profile';

import ReactTooltip from 'react-tooltip';
import InputBox from './component/InputBox';
import SelectBox from './component/SelectBox';
import ErrorMessageInputBox from './component/ErrorMessageInputBox';

import img_logo_kakao from './res/img/img-logo-kakao.svg';
import img_logo_google from './res/img/img-logo-google.svg';
import img_logo_facebook from './res/img/img-logo-facebook.png';

class App_modify extends Component {
  
  profileRef = null;
  input_name_ref = null;

  constructor(props) {
    super(props);

    let select_age_list_data = [];
    var nowYear = Number(new Date().getFullYear());
    for(var i = 1900 ; i <= nowYear ; i++ )
    {
      const data = {
        value: i,
        show_value: i
      }

      select_age_list_data.push(data);      
    }

    this.state = {
      user_id: null,
      email: '',

      name: '',
      nick_name: '',
      contact: '',
      gender: null,
      age: '',

      select_age_list_data: select_age_list_data.concat(),

      kakao_id: null,
      google_id: null,
      facebook_id: null,
    }
    
  }

  componentDidMount(){
    this.requestUserInfo();

    this.facebookLibInit();
    this.googleLibInit();
  }

  requestUserInfo = () => {
    axios.post('/user/info', {}, 
    (result) => {
      const data = result.userInfo;
      this.setState({
        user_id: data.user_id,
        email: data.email,

        name: data.name,
        nick_name: data.nick_name,
        contact: data.contact,
        gender: data.gender,
        age: data.age,

        kakao_id: data.kakao_id,
        google_id: data.google_id,
        facebook_id: data.facebook_id
      })
    }, (error) => {

    })
  }

  facebookLibInit = () => {
    let facebook_app_id = process.env.REACT_APP_FACEBOOK_ID_REAL;
    let facebook_app_ver = process.env.REACT_APP_FACEBOOK_VER_REAL;
    const app_type_key = document.querySelector('#g_app_type');
    if(app_type_key){
      if(app_type_key.value === 'local'){
        facebook_app_id = process.env.REACT_APP_FACEBOOK_ID_LOCAL;
        facebook_app_ver = process.env.REACT_APP_FACEBOOK_VER_LOCAL;
      }else if(app_type_key.value === 'qa'){
        facebook_app_id = process.env.REACT_APP_FACEBOOK_ID_QA;
        facebook_app_ver = process.env.REACT_APP_FACEBOOK_VER_QA;
      }
    }

    window.fbAsyncInit = () => {
      FB.init({
        appId      : facebook_app_id,
        // cookie     : true,  // enable cookies to allow the server to access
                            // the session
        xfbml      : true,  // parse social plugins on this page
        version    : facebook_app_ver // use graph api version 2.8
      });
  
      FB.getLoginStatus((response) => {
      });
  
    };
  
    // Load the SDK asynchronously
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  }

  googleLibInit = () => {
    setTimeout( () => {
      let google_app_id = process.env.REACT_APP_GOOGLE_ID_REAL;
      
      const app_type_key = document.querySelector('#g_app_type');
      if(app_type_key){
        if(app_type_key.value === 'local'){
          google_app_id = process.env.REACT_APP_GOOGLE_ID_LOCAL;
        }else if(app_type_key.value === 'qa'){
          google_app_id = process.env.REACT_APP_GOOGLE_ID_QA;
        }
      }

      gapi.load('auth2', () => {
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        this.auth2 = gapi.auth2.init({
          client_id: google_app_id,
          cookiepolicy: 'single_host_origin',
          // Request scopes in addition to 'profile' and 'email'
          //scope: 'additional_scope'
        });
        
        this.attachGoogle();
        
      });
    }, 100);
  }

  attachGoogle = () => {
    var userAgent = window.navigator.userAgent;
    var isKakao = userAgent.indexOf('KAKAOTALK');
    if(isKakao > 0)
    {
      return;
    }else{
      this.attachSignin(document.getElementById('login_social_google_react_button'));
    }
  }

  attachSignin = (element) => {
    this.auth2.attachClickHandler(element, {},
    (googleUser) => {
      const socialId = googleUser.getBasicProfile().getId();
      const socialName = googleUser.getBasicProfile().getName();
      const socialEmail = googleUser.getBasicProfile().getEmail();
      const socialPhotoUrl = googleUser.getBasicProfile().getImageUrl();;

      // console.error(socialId + socialName + socialEmail + " | " + socialPhotoUrl);

      axios.post('/user/update/sns/id', {
        sns_id: socialId,
        sns_type : 'GOOGLE'
      }, (result) => {
        swal('구글 동기화 완료!', '', 'success');
        this.setState({
          google_id: socialId
        })
      }, (error) => {

      })

      // this.requestSNSLogin({
      //   'id' : socialId,
      //   'name' : socialName,
      //   'email' : socialEmail,
      //   'profile_photo_url' : socialPhotoUrl,
      //   'type' : 'GOOGLE'
      // });

    }, (error) => {
      //alert(JSON.stringify(error, undefined, 2));
    });
    
      // axios.post("/user/update/sns/id/delete", {
      //   sns_type : 'GOOGLE'
      // }, (result) => {
      //   swal('구글 동기화 해제 완료!', '', 'success');
      //   this.setState({
      //     google_id: null
      //   })
      // }, (error) => {

      // })
    
    
  }

  componentWillUnmount(){
    this.profileRef = null;
    this.input_name_ref = null;
  }

  requestSave = () => {
    if(this.state.user_id === null){
      alert('유저 id가 없습니다. 새로고침 혹은 재로그인 후 다시 이용 부탁드립니다.');
      return;
    }

    showLoadingPopup('저장중입니다..');

    this.profileRef.uploadProfileImage(this.state.user_id, Types.file_upload_target_type.user, 
    () => {
      stopLoadingPopup();
      alert('완료');
    }, 
    () => {
      stopLoadingPopup();
      alert('프로필 이미지 저장 오류');
    })
  }

  onClickUpdate = (e) => {
    e.preventDefault();

    if(this.state.name === ''){
      return;
    }

    showLoadingNoContentPopup();

    this.profileRef.uploadProfileImage(this.state.user_id, Types.file_upload_target_type.user, 
    () => {
      axios.post('/user/info/update/web', {
        name: this.state.name,
        nick_name: this.state.nick_name,
        contact: this.state.contact,
        gender: this.state.gender,
        age: this.state.age
      }, (result) => {
        swal('수정완료!', '', 'success');
      }, (error) => {
        stopLoadingPopup();
      })
    }, 
    () => {
      stopLoadingPopup();
      alert('프로필 이미지 저장 오류');
    })
  }

  onClickPasswordReset = (e) => {
    e.preventDefault();

    window.location.href = '/user/password/reset';
  }

  onClickKakaoLogin = (e) => {
    e.preventDefault();

    if(this.state.kakao_id === null){
      Kakao.Auth.login({
        success: (authObj) => {
          Kakao.API.request({
            url: '/v2/user/me',
            success: (res) => {
              axios.post('/user/update/sns/id', {
                sns_id: res.id,
                sns_type : 'KAKAO'
              }, (result) => {
                swal('카카오톡 동기화 완료!', '', 'success');
                this.setState({
                  kakao_id: res.id
                })
              }, (error) => {

              })
            },
            fail: (error) => {
              alert(
                'login success, but failed to request user information: ' +
                  JSON.stringify(error)
              )
            },
          })
        },
        fail: function(err) {
          alert(JSON.stringify(err))
        },
      })
    }else{
      axios.post("/user/update/sns/id/delete", {
        sns_type : 'KAKAO'
      }, (result) => {
        swal('카카오톡 동기화 해제 완료!', '', 'success');
        this.setState({
          kakao_id: null
        })
      }, (error) => {

      })
    }
    
  }

  onClickGoogleLogin = (e) => {
    e.preventDefault();

    var userAgent = window.navigator.userAgent;
    var isKakao = userAgent.indexOf('KAKAOTALK');
    if(isKakao > 0)
    {
      alert('카카오톡 브라우저에선 구글 로그인이 불가능합니다.');
      return;
    }
  }

  onClickGoogleUnLogin = (e) => {
    e.preventDefault();

    console.log('dfdf');
    axios.post("/user/update/sns/id/delete", {
      sns_type : 'GOOGLE'
    }, (result) => {
      swal('구글 동기화 해제 완료!', '', 'success');
      this.setState({
        google_id: null
      }, () => {
        // this.attachGoogle();
      })
    }, (error) => {

    })
  }

  onClickFacebookLogin = (e) => {
    e.preventDefault();

    if(this.state.facebook_id === null){
      FB.login((response) => {
        if (response.status === 'connected') {
          this.fbStatusChangeCallback(response);
        }
      }, {scope: 'email'});
    }else{
      axios.post("/user/update/sns/id/delete", {
        sns_type : 'FACEBOOK'
      }, (result) => {
        swal('페이스북 동기화 해제 완료!', '', 'success');
        this.setState({
          facebook_id: null
        })
      }, (error) => {

      })
    }
    
  }

  fbStatusChangeCallback = (response) => {
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
  
      const url = '/me?fields=id,name,email';
      FB.api(url, (responseMe) => {
        const socialId = responseMe.id;
        const socialName = responseMe.name;
        const socialEmail = responseMe.email;
        const socialPhotoUrl = "https://graph.facebook.com/"+socialId+"/picture?type=normal";
  
        axios.post('/user/update/sns/id', {
          sns_id: socialId,
          sns_type : 'FACEBOOK'
        }, (result) => {
          swal('페이스북 동기화 완료!', '', 'success');
          this.setState({
            facebook_id: socialId
          })
        }, (error) => {

        })
      });
  
    } else {
      // The person is not logged into your app or we are unable to tell.
      FB.login((response) => {
        if (response.status === 'connected') {
          this.fbStatusChangeCallback(response);
        }
      }, {scope: 'email'});
    }
  }

  render() {
    if(this.state.user_id === null){
      return (<></>)
    }

    let kakaoImgStyle = {};
    let googleImgStyle = {};
    let unGoogleImgStyle = {};
    let facebookImgStyle = {};
    let kakaoToolTip = '연동해제';
    let googleToolTip = '연동해제';
    let facebookToolTip = '연동해제';

    if(this.state.kakao_id === null){
      kakaoToolTip = '연동하기';
      kakaoImgStyle = {
        opacity: 0.3
      }
    }

    if(this.state.google_id === null){
      googleToolTip = '연동하기';
      googleImgStyle = {
        opacity: 0.3
      }

      unGoogleImgStyle = {
        display: 'none'
      }
    }else{
      googleImgStyle = {
        display: 'none'
      }

      unGoogleImgStyle = {
        display: 'block'
      }
    }

    if(this.state.facebook_id === null){
      facebookToolTip = '연동하기';
      facebookImgStyle = {
        opacity: 0.3
      }
    }

    return (
      <div className={'App_modify'}>
        <div className={'allPageController'}>
          <div className={'all_container'}>
            <div className={'left_container'}>
              <div className={'container_title'}>
                프로필 수정
              </div>

              <div style={{width: 100, height: 100}} className={'profile_container'}>
                <Profile ref={(ref) => {this.profileRef = ref;}} user_id={this.state.user_id} circleSize={100} isEdit={true} isBlackCameraIcon={true}></Profile>
              </div>

              <div className={'contents_wrapper'}>
                <div className={'contents_label'}>
                  이메일
                </div>
                <div className={'input_box email_text_container'}>
                  {this.state.email}

                  <div className={'logo_container'}>
                    <button data-tip={kakaoToolTip} onClick={(e) => {this.onClickKakaoLogin(e)}}  className={'logo_button'}>
                      <img style={kakaoImgStyle} className={'logo_img'} src={img_logo_kakao} />
                    </button>

                    <button style={googleImgStyle} data-tip={googleToolTip} onClick={(e) => {this.onClickGoogleLogin(e)}} id={'login_social_google_react_button'} className={'logo_button'}>
                      <img className={'logo_img'} src={img_logo_google} />
                    </button>

                    <button style={unGoogleImgStyle} data-tip={googleToolTip} onClick={(e) => {this.onClickGoogleUnLogin(e)}} className={'logo_button'}>
                      <img className={'logo_img'} src={img_logo_google} />
                    </button>

                    <button data-tip={facebookToolTip} onClick={(e) => {this.onClickFacebookLogin(e)}} className={'logo_button'}>
                      <img style={facebookImgStyle} className={'logo_img'} src={img_logo_facebook} />
                    </button>
                  </div>
                </div>
                
              </div>

              <div className={'contents_wrapper'}>
                <div className={'contents_label'}>
                  비밀번호
                </div>
                <div className={'input_box'}>
                  <button className={'change_password_button'} onClick={(e) => {this.onClickPasswordReset(e)}}>
                    비밀번호 변경하기
                  </button>
                </div>
              </div>

              <div className={'contents_wrapper'}>
                <div className={'contents_label'}>
                  이름
                </div>
                <div className={'input_box'}>
                  <InputBox
                    ref={(ref) => {
                      this.input_name_ref = ref;
                    }}
                    default_text={this.state.name}
                    type={'text'}
                    name={'name'}
                    placeholder={'이름을 입력해주세요.'}
                    
                    callback_set_text={(text) => {
                      this.setState({
                        name: text
                      })
                    }}
                  ></InputBox>
                </div>
              </div>

              <div className={'input_error_box'}>
                <div className={'contents_label'}>
                </div>
                
                <ErrorMessageInputBox 
                    defaultText={this.state.name} 
                    inputBoxRef={this.input_name_ref}
                    error_messages={[
                      {
                        type: Types.input_error_messages.empty,
                        message: '필수 입력 사항입니다. 이름을 입력해주세요.'
                      }
                    ]}
                  >
                </ErrorMessageInputBox>
                
              </div>

              <div className={'contents_wrapper'}>
                <div className={'contents_label'}>
                  닉네임
                </div>
                <div className={'input_box'}>
                  <InputBox
                  default_text={this.state.nick_name}
                  type={'text'}
                  name={'nick_name'}
                  placeholder={'닉네임을 입력해주세요.'}
                  callback_set_text={(text) => {
                    this.setState({
                      nick_name: text
                    })
                  }}
                  ></InputBox>
                </div>                
              </div>

              <div className={'contents_wrapper'}>
                <div className={'contents_label'}>
                  연락처
                </div>
                <div className={'input_box'}>
                  <InputBox
                  default_text={this.state.contact}
                  type={'tel'}
                  name={'contact'}
                  placeholder={'연락처를 입력해주세요.'}
                  callback_set_text={(text) => {
                    this.setState({
                      contact: text
                    })
                  }}
                  ></InputBox>
                </div>
              </div>

              <div className={'contents_wrapper'}>
                <div className={'contents_label'}>
                  성별
                </div>
                <div className={'input_box'}>
                  <SelectBox 
                    default_value={this.state.gender}
                    null_show_value={'성별을 선택해주세요'}
                    list={[
                      {
                        value: Types.gender.m,
                        show_value: '남성'
                      },
                      {
                        value: Types.gender.f,
                        show_value: '여성'
                      }
                    ]}
                    callbackChangeSelect={(value) => {
                      this.setState({
                        gender: value
                      })
                    }}
                  ></SelectBox>
                </div>
              </div>

              <div className={'contents_wrapper'}>
                <div className={'contents_label'}>
                  년생
                </div>
                <div className={'input_box'}>
                  <SelectBox 
                    default_value={this.state.age}
                    null_show_value={'년도 선택'}
                    list={this.state.select_age_list_data}
                    null_show_value_set_last={true}
                    callbackChangeSelect={(value) => {
                      this.setState({
                        age: value
                      })
                    }}
                  ></SelectBox>
                </div>
              </div>


            </div>
            <div className={'right_container'}>
              <div className={'right_top_box'}>
                <div className={'right_top_title'}>
                  이메일과 연락처는 어디에 쓰이나요?
                </div>
                <div className={'right_top_content'}>
                  등록하신 이메일과 연락처로 콘텐츠 정보 및 주문 내역을 안내드립니다. 
                </div>
                <div className={'right_top_box_line'}>
                </div>
                <div className={'right_top_title'}>
                  성별과 생년월일은 어디에 쓰이나요?
                </div>
                <div className={'right_top_content'}>
                  등록하신 성별과 생년월일은 팬 이벤트 진행 시, 맞춤 서비스(굿즈 및 프로그램 구성 등)를 제공하기 위해 활용됩니다.
                </div>

              </div>
            </div>
          </div>
          
          <div className={'buttons_container'}>
            <button className={'update_button'} onClick={(e) => {this.onClickUpdate(e)}}>
                수정하기
            </button>
          </div>
        </div>
        <ReactTooltip />
      </div>
    );
  }
}

let domContainer = document.querySelector('#react_app_modify_page');
ReactDOM.render(<App_modify />, domContainer);