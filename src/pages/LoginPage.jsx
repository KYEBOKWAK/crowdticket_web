'use strict';

import React, { Component } from 'react';

import {
  BrowserRouter as Router,
  Switch,
  Route,
  Link,
  // Redirect
} from "react-router-dom";

import LoginStartPage from '../pages/LoginStartPage';
import LoginEmailPage from '../pages/LoginEmailPage';
import LoginJoinPage from '../pages/LoginJoinPage';

import LoginForgetEmailPage from '../pages/LoginForgetEmailPage';
// import LoginResetPasswordPage from '../pages/LoginResetPasswordPage';
import LoginKnowSNSPage from '../pages/LoginKnowSNSPage';
import LoginSNSSetEmailPage from '../pages/LoginSNSSetEmailPage';

import RoutesTypes from '../Routes_types';

class LoginPage extends Component{

  goSNSLinkRef = null;
  goNoEmailSNSRef = null;

  constructor(props){
    super(props);

    this.state = {
      sns_array: [],
      sns_is_password: false,
      email: '',

      //sns로그인시 이메일이 없을경우 이메일 입력란 브릿지 start
      sns_id: null,
      sns_name: '',
      sns_email: null,
      sns_profile_photo_url: '',
      sns_type: null
      //sns로그인시 이메일이 없을경우 이메일 입력란 브릿지 end
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.initData();
    // console.log(window.location.pathname);
    // window.addEventListener('popstate', this.onBackButtonEvent);
  };

  initData = () => {
    this.setState({
      sns_array: [],
      sns_is_password: false,
      email: '',

      //sns로그인시 이메일이 없을경우 이메일 입력란 브릿지 start
      sns_id: null,
      sns_name: '',
      sns_email: null,
      sns_profile_photo_url: '',
      sns_type: null
      //sns로그인시 이메일이 없을경우 이메일 입력란 브릿지 end
    })
  }

  componentWillUnmount(){
    // window.removeEventListener('popstate', this.onBackButtonEvent);
    goSNSLinkRef = null;
    goNoEmailSNSRef = null;
  };

  componentDidUpdate() {
  } 

  // testLoginCompliteButton = (e) => {
  //   window.history.go(-1);
  // }

  //no_email_sns
  render(){
    return(
      <div className={'LoginPage'}>
        <Router>
            <Link ref={(ref) => {this.goSNSLinkRef = ref;}} style={{display: 'none'}} to={RoutesTypes.login.know_sns}></Link>

            <Link ref={(ref) => {this.goNoEmailSNSRef = ref;}} style={{display: 'none'}} to={RoutesTypes.login.no_email_sns}></Link>
            <Switch>
              <Route path={RoutesTypes.login.no_email_sns}>
                <LoginSNSSetEmailPage 
                  sns_id={this.state.sns_id}
                  sns_name={this.state.sns_name}
                  sns_email={this.state.sns_email}
                  sns_profile_photo_url={this.state.sns_profile_photo_url}
                  sns_type={this.state.sns_type}
                ></LoginSNSSetEmailPage>
              </Route>

              <Route path={RoutesTypes.login.know_sns}>
                <LoginKnowSNSPage sns_array={this.state.sns_array} sns_is_password={this.state.sns_is_password} email={this.state.email}></LoginKnowSNSPage>
              </Route>
              <Route path={RoutesTypes.login.forget_email}>
                <LoginForgetEmailPage></LoginForgetEmailPage>
              </Route>
              <Route path={RoutesTypes.login.join}>
                <LoginJoinPage
                  callbackSnsArray={(sns_array, email) => {
                    this.setState({
                      sns_array: sns_array.concat(),
                      sns_is_password: false,
                      email: email
                    }, () => {
                      this.goSNSLinkRef.click();
                    })
                  }}
                ></LoginJoinPage>
              </Route>
              <Route path={RoutesTypes.login.email}>
                <LoginEmailPage callbackSnsArray={(sns_array, email) => {
                  this.setState({
                    sns_array: sns_array.concat(),
                    sns_is_password: true,
                    email: email
                  }, () => {
                    this.goSNSLinkRef.click();
                  })
                }}></LoginEmailPage>
              </Route>
              <Route path={RoutesTypes.login.home}>
                <LoginStartPage callbackNoEmail={(data) => {
                  this.setState({
                    sns_id: data.id,
                    sns_name: data.name,
                    sns_email: data.email,
                    sns_profile_photo_url: data.profile_photo_url,
                    sns_type: data.type
                  }, () => {
                    this.goNoEmailSNSRef.click();
                  })
                }}></LoginStartPage>
              </Route>
              
            </Switch>
          
        </Router>
      </div>
    )
  }
};

LoginPage.defaultProps = {
}

export default LoginPage;