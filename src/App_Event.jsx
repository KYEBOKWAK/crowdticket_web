'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import axios from './lib/Axios';
import Types from './Types';

import Home_Thumb_Container_Item from './component/Home_Thumb_Container_Item';

import Home_Thumb_Tag from './component/Home_Thumb_Tag';

import share_img from './res/img/img-share.png';
import bell_img from './res/img/img-bell.png';

import {CopyToClipboard} from 'react-copy-to-clipboard';

import { ToastContainer, toast } from 'react-toastify';

import Cookies from 'universal-cookie';
const cookies = new Cookies();

const HOME_THUMB_CONTAINER_SHOW_LINE_COUNT = 4;
const REQUEST_ONCE_ITME = 16;

class App_Event extends Component{  
  
  isUnmount = false;

  constructor(props){
    super(props);

    let alias = null;
    const event_alias_dom = document.querySelector('#event_alias');
    if(event_alias_dom){
      alias = event_alias_dom.value;
    }

    this.state = {
      alias: alias,
      list: [],
      items: [],
      items_count: 0,
      hasMore: true,

      text_tag: null,
      text_title: null,

      link_url: window.location.href,

      text_notice: null
    }

    
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    if(this.state.alias === null){
      alert("진행되지 않는 이벤트 입니다");
    }

    axios.post('/event/any/pages', {
      alias: this.state.alias
    }, (result) => {

      if(result.list.length === 0){
        alert('존재 하지 않는 이벤트 입니다.');
        return;
      }
      this.setState({
        list: result.list.concat()
      }, () => {
        this.requestEventItemList();
        this.requestEventTag();
        this.requestEventTitle();
        this.requestEventNotice();
        this.addViewCount();
      })
    }, (error) => {
      alert('존재 하지 않는 이벤트 입니다.');
    })
  };

  addViewCount = () => {
    let cookiesName = 'cr_event_view_'+this.state.alias;

    let view_store = cookies.get(cookiesName);
    if(view_store === undefined){
      var today = new Date();

      var nextDay = new Date(today);
      nextDay.setMinutes(today.getMinutes() + 10);

      cookies.set(cookiesName, '0', 
      { 
        path: '/',
        expires: nextDay
      });

      axios.post('/viewcount/any/event/add', {
        alias: this.state.alias
      }, (result) => {
      }, (error) => {

      })
    }
  }

  requestEventNotice = () => {
    if(this.state.alias === null){
      alert('이벤트 정보가 없습니다');
      return;
    }

    axios.post("/event/any/page/notice", 
    {
      alias: this.state.alias
    },
    (result) => {
      if(this.isUnmount){
        return;
      }

      this.setState({
        text_notice: result.text
      })

    }, (error) => {

    })
  }

  requestEventTag = () => {
    if(this.state.alias === null){
      alert('이벤트 정보가 없습니다');
      return;
    }

    axios.post("/event/any/page/tag", 
    {
      alias: this.state.alias
    },
    (result) => {
      if(this.isUnmount){
        return;
      }

      this.setState({
        text_tag: result.text
      })

    }, (error) => {

    })
  }

  requestEventTitle = () => {
    if(this.state.alias === null){
      alert('이벤트 정보가 없습니다');
      return;
    }

    axios.post("/event/any/page/title", 
    {
      alias: this.state.alias
    },
    (result) => {
      if(this.isUnmount){
        return;
      }

      this.setState({
        text_title: result.text
      })

    }, (error) => {

    })
  }
  
  requestEventItemList = () => {
    if(this.state.alias === null){
      alert('이벤트 정보가 없습니다');
      return;
    }

    axios.post("/event/any/items", 
    {
      alias: this.state.alias
    },
    (result) => {
      if(this.isUnmount){
        return;
      }
      
      this.makeItemList(result.list);
    }, (error) => {

    })
  }

  makeItemList = (_list) => {
    let _rand_list = _list.concat();
    
    let lineCount = _rand_list.length / HOME_THUMB_CONTAINER_SHOW_LINE_COUNT;

    let index = 0;

    let _items = [];
    let hasMore = false;
    // if(this.props.isMore){
    //   _items = this.state.items.concat();

    //   if(_list.length < REQUEST_ONCE_ITME) {
    //     hasMore = false;
    //   }
    // }else{
    //   _items = [];
    // }

    let marginTopZeroStyle = {
      marginTop: 0
    }
    for(let i = 0 ; i < lineCount ; i++){
      let columnItems = [];
      let isOverCount = false;
      for(let j = 0 ; j < 2 ; j++){
        //1줄에 4개 모바일일 경우 2개씩 쪼개야 하기 때문에 쪼개서 flex 한다.(모바일일때 2개 flex 유지, pc 일때 4개 flex 유지)
        let rowItems = [];

        for(let k = 0 ; k < 2 ; k++){
          let target_id = null;

          if(index >= _rand_list.length){
            if(k === 0){
              //두개중 한개만 비어있는 경우가 있음
              isOverCount = true;
            }
          }else{
            const data = _rand_list[index];

            target_id = data.target_id;
            // if(this.props.type === Types.thumb_list_type.find_result_projects){
            //   target_id = data.project_id;
            // }else{
            //   target_id = data.item_id;
            // }
          }

          // const itemDom = <Home_Thumb_Container_Item key={k} store_item_id={target_id}></Home_Thumb_Container_Item>;

          let itemDom = <Home_Thumb_Container_Item key={k} store_item_id={target_id}>
                        </Home_Thumb_Container_Item>;
          
          rowItems.push(itemDom);

          if(k === 0){
            rowItems.push(<div key={k+'_gap'} className={'row_items_gap'}></div>)
          }

          index++;
        }

        let itemContainerStyle = {}
        if(isOverCount){
          itemContainerStyle = {
            ...marginTopZeroStyle
          }
        }

        const itemContainerDom = <div style={itemContainerStyle} key={j} className={'row_items_container'}>
                                  {rowItems}
                                </div>

        columnItems.push(itemContainerDom);

        if(j === 0){
          columnItems.push(<div key={j+'_gap'} className={'column_items_gap'}></div>);
        }
      }

      const itemColumnsDom = <div key={this.state.items.length+'_'+i} className={'column_items_container'}>
                              {columnItems}
                            </div>

      _items.push(itemColumnsDom);
    }

    
    this.setState({
      items: _items.concat(),
      items_count: this.state.items_count + index,
      hasMore: hasMore,
      isRefreshing: false
    })
  }

  componentWillUnmount(){
    this.isUnmount = true;
  };

  componentDidUpdate(){
  }

  onClickMoreContents = (e) => {
    e.preventDefault();

    window.location.href = '/category/0';
  }

  onClickBanner = (e) => {
    e.preventDefault();

    Kakao.Channel.addChannel({
      channelPublicId: '_JUxkxjM'
    });
  }

  render(){
    if(this.state.list.length === 0){
      return(<></>)
    }

    
    const image_lists = [];
    for(let i = 0 ; i < this.state.list.length ; i++){
      const data = this.state.list[i];
      const imageDom = <div className={'images_container'} key={i}>
                        <img className={'images_pc'} src={data.image_pc}/>
                        <img className={'images_mobile'} src={data.image_mobile} />
                      </div>
      
      image_lists.push(imageDom);
    }

    let tagDom = <></>;
    if(this.state.text_tag !== null && this.state.text_tag !== ''){
      tagDom = <Home_Thumb_Tag thumb_tags={Types.thumb_tags.props} text={this.state.text_tag}></Home_Thumb_Tag>;
    }

    let titleDom = <></>;
    if(this.state.text_title !== null && this.state.text_title !== ''){
      titleDom = <div className={'title_text'}>{this.state.text_title}</div>
    }

    let noticeDom = <></>;
    if(this.state.text_notice !== null && this.state.text_notice !== ''){
      noticeDom = <div className={'notice_container'}>
                    <div className={'padding_container'}>
                      <div className={'notice_title'}>
                        유의사항
                      </div>
                      <div className={'notice_content_box'}>
                        {this.state.text_notice}
                      </div>
                    </div>
                  </div>
    }

    return(
      <div className={'App_Event'}>
        {image_lists}
        <div className={'container_box'}>
          <div className={'padding_container'}>
            <div className={'tag_container'}>
              {tagDom}
            </div>
            <div className={'title_container'}>
              {titleDom}
            </div>

            <div className={'list_container'}>
              {this.state.items}
            </div>
            
            <button className={'other_contents_button'} onClick={(e) => {this.onClickMoreContents(e)}}>
              다른 콘텐츠는 없나요? 🧐
            </button>

            <div className={'bottom_banners_container'}>
              <CopyToClipboard 
                text={this.state.link_url} 
                onCopy={() => 
                {
                  toast.dark('기획전 링크가 복사되었습니다!', {
                    position: "top-center",
                    autoClose: 5000,
                    hideProgressBar: true,
                    closeOnClick: true,
                    pauseOnHover: true,
                    draggable: true,
                    progress: undefined,
                    });
                }}>
                  <button className={'share_button'}>
                    <img className={'share_img'} src={share_img} />
                    <div className={'share_text_box'}>
                      <div>
                        친구한테 공유하고 인싸되자!
                      </div>
                      <div className={'share_text_bottom'}>
                        이 기획전 공유하기
                      </div>
                    </div>
                    
                  </button>
                </CopyToClipboard>

              <button className={'share_button alarm_button_color'} onClick={(e) => {this.onClickBanner(e)}}>
                <img className={'share_img'} src={bell_img} />
                <div className={'share_text_box'}>
                  <div>
                    클릭 한 번으로
                  </div>
                  <div className={'share_text_bottom'}>
                    새로운 기획전 알림 받기
                  </div>
                </div>
              </button>
            </div>

            
          </div>

          {noticeDom}
        </div>

        <ToastContainer 
          position="top-center"
          autoClose={5000}
          hideProgressBar
          newestOnTop={false}
          closeOnClick
          rtl={false}
          pauseOnFocusLoss
          draggable
          pauseOnHover
        />
      </div>
    )
  }
};

// export default App_Event;
let domContainer = document.querySelector('#react_app_event_page');
ReactDOM.render(<App_Event />, domContainer);