'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import StoreDoIt from '../component/StoreDoIt';

import ic_more from '../res/img/ic-more.svg';


class StoreManagerTabHomePage extends Component{

  constructor(props){
    super(props);

    this.state = {

      //첫번째 단 start
      order_count: 0,
      item_count: 0
      //첫번째 단 end
    }
  };

  componentDidMount(){
    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){


    let new_order_center_container_dom = <></>;
    let new_order_center_content_dom = <></>;
    if(this.state.order_count === 0 && this.state.item_count === 0){
      new_order_center_content_dom = <div>
                                      {`주문을 받기 전,\n 먼저 상품을 등록해볼까요?`}
                                    </div>;

    }else if(this.state.order_count === 0 && this.state.item_count > 0){
      new_order_center_content_dom = <div>
                                      {`신규 주문이 없어요.\n상점 링크 공유 배너를 클릭해\n상점을 홍보해보세요!`}
                                    </div>;
    }
    else{

    }

    new_order_center_container_dom = <div>
                                      {new_order_center_content_dom}
                                    </div>;

    return(
      <div className={'StoreManagerTabHomePage'}>
        <StoreDoIt store_id={this.props.store_id} store_user_id={this.props.store_user_id}></StoreDoIt>

        
        <div className={'container_box'}>
          <div className={'first_area_box'}>
            <div className={'new_order_box'}>
              <div className={'new_order_top_container'}>
                <div className={'new_order_top_title_text'}>
                  신규 주문
                  <span style={{marginLeft: 8}} className={'point_color'}>
                    {this.state.order_count}
                  </span>
                </div>
                <div className={'new_order_top_more_button'}>
                  전체보기
                  <img src={ic_more} />
                </div>
              </div>
            </div>

            <div className={'first_second_box'}>
              <div className={'calculate_box'}>
                <div className={'new_order_top_container'}>
                  <div className={'new_order_top_title_text'}>
                    정산
                  </div>
                  <div className={'new_order_top_more_button'}>
                    더보기
                    <img src={ic_more} />
                  </div>
                </div>
              </div>
              <div className={'link_copy_button'}>
                🔗 상점 링크를 공유해볼까요?
              </div>
            </div>
          </div>          
        </div>
      </div>
    )
  }
};

// props 로 넣어줄 스토어 상태값
// const mapStateToProps = (state) => {
//   // console.log(state);
//   return {
//     // pageViewKeys: state.page.pageViewKeys.concat()
//   }
// };

// const mapDispatchToProps = (dispatch) => {
//   return {
//     // handleAddPageViewKey: (pageKey: string, data: any) => {
//     //   dispatch(actions.addPageViewKey(pageKey, data));
//     // },
//     // handleAddToastMessage: (toastType:number, message: string, data: any) => {
//     //   dispatch(actions.addToastMessage(toastType, message, data));
//     // }
//   }
// };

export default StoreManagerTabHomePage;