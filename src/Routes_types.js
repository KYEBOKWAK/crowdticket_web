import * as GlobalTypes from "./GlobalKeys";

const Routes = {
  login: {
    // home: '/login',
    // email: '/login/email',
    // join: '/login/join'
    home: '/auth/login',
    email: '/auth/login/email',
    join: '/auth/login/join',
    forget_email: '/auth/login/forget/email',
    reset_password: '/auth/login/password/reset',
    know_sns: '/auth/login/know/sns',
    no_email_sns: '/auth/login/last/sns',
    inactive_user: '/auth/login/inactive'
  }
};

export default Routes;