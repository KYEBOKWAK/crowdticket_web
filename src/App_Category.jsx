'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import axios from './lib/Axios';
import Types from './Types';

import Category_Top_Carousel from './component/Category_Top_Carousel';
// import Home_Thumb_Container_List from './component/Home_Thumb_Container_List';
import Category_Result_List from './component/Category_Result_List';
import Category_Creator_List from './component/Category_Creator_List';

import ic_category_info from './res/img/ic-category-info.svg';
import ic_refresh from './res/img/ic-refresh.svg';

import ic_category_cancle from './res/img/ic-category-cancle.svg';

import ScrollBooster from 'scrollbooster';

import ic_dropdown from './res/img/ic-dropdown.svg';

import Popup_category_filter from './component/Popup_category_filter';
import Popup_category_sort from './component/Popup_category_sort';

import Popup_category_info from './component/Popup_category_info';

const MENU_CONTENTS = 'MENU_CONTENTS';
const MENU_CREATOR = 'MENU_CREATOR';

//9999로 넘어오는 전체 카테고리의 기타에 id값 모음
const ETC_LISTS = [9, 15, 20, 23, 26, 29, 32];

class App_Category extends Component {
  scrollBooster = null;

  constructor(props) {
    super(props);

    let category_top_item_id = 0;
    const category_top_item_id_dom = document.querySelector('#category_top_item_id');
    if(category_top_item_id_dom){
      category_top_item_id = Number(category_top_item_id_dom.value);
    }

    this.state = {
      category_top_item_id: category_top_item_id,
      category_sub_data_list: [],
      category_sub_select_list: [],

      menu: MENU_CONTENTS,

      contents_filter_selects: [],
      is_filter_popup: false,
      
      contents_sort_select_type: Types.sort_category.SORT_POPULAR,
      creator_sort_select_type: Types.sort_category.SORT_POPULAR,
      select_contents_sort_text: '인기순',
      select_creator_sort_text: '인기순',
      is_sort_popup: false,

      is_info_popup: false
    }
    
  }

  componentDidMount(){
    this.requestSubCategoryList();

    window.addEventListener('resize', this.updateDimensions);
  }
  componentWillUnmount(){
    window.removeEventListener('resize', this.updateDimensions);
  }

  updateDimensions = () => {

    if(window.innerWidth > Types.width.tablet){
      this.destroyScrollAction();
    }else{
      if(this.scrollBooster === null){
        this.setScrollAction();
      }
    }
  }

  destroyScrollAction = () => {
    if(this.scrollBooster !== null){
      this.scrollBooster.destroy();
      this.scrollBooster = null;
    }
  }

  setScrollAction = () => {
    const viewport = document.querySelector('.App_Category .viewport');
    const content = document.querySelector('.App_Category .scrollable-content');

    this.scrollBooster = new ScrollBooster({
      viewport,
      content,
      bounce: true,
      textSelection: false,
      emulateScroll: true,
      onUpdate: (state) => {
        // state contains useful metrics: position, dragOffset, dragAngle, isDragging, isMoving, borderCollision
        // you can control scroll rendering manually without 'scrollMethod' option:
        content.style.transform = `translate(
          ${-state.position.x}px,
          0px
        )`;

        // content.style.transform = `translate(
        //   ${-state.position.x}px,
        //   ${-state.position.y}px
        // )`;
      },
      shouldScroll: (state, event) => {
        // disable scroll if clicked on button
        const isButton = event.target.nodeName.toLowerCase() === 'button';
        return !isButton;
      },
      onClick: (state, event, isTouchDevice) => {
        // prevent default link event
        const isLink = event.target.nodeName.toLowerCase() === 'link';
        if (isLink) {
          event.preventDefault();
        }
      }
    });

    // methods usage examples:
    this.scrollBooster.updateMetrics();
    // sb.scrollTo({ x: 100, y: 100 });
    this.scrollBooster.updateOptions({ emulateScroll: false });
    // sb.destroy();
  }
  
  requestSubCategoryList = () => {
    axios.post("/category/any/sub/list", {
      category_top_id: this.state.category_top_item_id
    }, (result) => {
      let category_sub_data_list = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];

        const sub_data = {
          id: data.id,
          title: data.title,
          isSelect: false
        }

        category_sub_data_list.push(sub_data);
      }

      this.setState({
        category_sub_data_list: category_sub_data_list.concat()
      }, () => {
        this.updateDimensions();
        this.setSelectSubCategory();
      })

    }, (error) => {

    })
  }

  setSelectSubCategory = () => {
    let category_sub_select_list = [];
    
    for(let i = 0 ; i < this.state.category_sub_data_list.length ; i++){
      const data = this.state.category_sub_data_list[i];

      if(data.isSelect){
        category_sub_select_list.push(data.id);
      }
    }

    this.setState({
      category_sub_select_list: category_sub_select_list.concat()
    })
  }

  onClickSubItem = (e, id) => {
    e.preventDefault();

    let category_sub_data_list = this.state.category_sub_data_list.concat();

    const subDataIndex = category_sub_data_list.findIndex((value) => {
      if(value.id === id){
        return value;
      }
    })

    if(subDataIndex < 0){
      alert('서브 카테고리 데이터 조회 에러')
      return;
    }
    
    let isSelect = category_sub_data_list[subDataIndex].isSelect;
    if(isSelect){
      isSelect = false;
    }else{
      isSelect = true;
    }

    category_sub_data_list[subDataIndex].isSelect = isSelect;

    this.setState({
      category_sub_data_list: category_sub_data_list.concat()
    }, () => {
      this.setSelectSubCategory();
    })
  }

  onClickSubReset = (e) => {
    e.preventDefault();

    let category_sub_data_list = this.state.category_sub_data_list.concat();
    for(let i = 0 ; i < category_sub_data_list.length ; i++){
      category_sub_data_list[i].isSelect = false;
    }

    this.setState({
      category_sub_data_list: category_sub_data_list.concat()
    }, () => {
      this.setSelectSubCategory();
    })
  }

  getSubCategoryTitle = () => {
    const data = Types.category_top.find((value) => {
      if(this.state.category_top_item_id === value.id){
        return value;
      }
    });

    if(data === undefined){
      return '';
    }

    return data.show_value;
  }

  onClickMenuContents = (e) => {
    e.preventDefault();

    this.setState({
      menu: MENU_CONTENTS
    })
  }

  onClickMenuCreator = (e) => {
    e.preventDefault();

    this.setState({
      menu: MENU_CREATOR
    })
  }

  onClickFilterPopup = (e) => {
    e.preventDefault();

    this.setState({
      is_filter_popup: true
    })
  }

  onClickSortPopup = (e) => {
    e.preventDefault();

    this.setState({
      is_sort_popup: true
    })
  }

  onClickInfoPopup = (e) => {
    e.preventDefault();

    this.setState({
      is_info_popup: true
    })
  }

  render() {

    let sub_category_list_dom = [];
    for(let i = 0 ; i < this.state.category_sub_data_list.length ; i++){
      const data = this.state.category_sub_data_list[i];

      let subStyle = {}
      let closeImg = <></>;
      if(data.isSelect){
        subStyle = {
          backgroundColor: '#00bfff',
          color: '#ffffff',
        }

        closeImg = <img style={{marginLeft: 4, width: 17, height: 17}} src={ic_category_cancle} />
      }

      const sub_item_dom = <div key={i} onClick={(e) => {this.onClickSubItem(e, data.id)}} style={subStyle} className={'category_sub_list_item'}>
                              <div>
                                {data.title}
                              </div>
                            {closeImg}
                          </div>
      
      sub_category_list_dom.push(sub_item_dom);
    }

    let sub_category_title_text = this.getSubCategoryTitle();

    let menuContentsStyle = {};
    let menuCreatorStyle = {};
    let menuContentsUnderBarStyle = {};
    let menuCreatorUnderBarStyle = {};

    let contentsListDom = <></>;

    let filter_button_dom = <></>;

    let select_sort_text = '';
    if(this.state.menu === MENU_CONTENTS){
      select_sort_text = this.state.select_contents_sort_text;
      menuContentsStyle = {
        color: '#00bfff'
      }

      menuContentsUnderBarStyle = {
        display: 'block'
      }

      contentsListDom = <div>
                          <Category_Result_List 
                            type={Types.thumb_list_type.category_result}
                            isMore={true}
                            category_top_id={this.state.category_top_item_id}
                            category_sub_ids={this.state.category_sub_select_list.concat()}
                            contents_filter_selects={this.state.contents_filter_selects}
                            contents_sort_select_type={this.state.contents_sort_select_type}
                            ETC_LISTS={ETC_LISTS}
                          >
                          </Category_Result_List>
                        </div>
      
      let contentsFilterText = '';
      if(this.state.contents_filter_selects.length > 0){
        contentsFilterText = this.state.contents_filter_selects[0].text;
        if(this.state.contents_filter_selects.length > 1){
          contentsFilterText = contentsFilterText + ' 외 ' + (this.state.contents_filter_selects.length - 1) + '개';
        }
      }else{
        contentsFilterText = '콘텐츠 전체'
      }
      
      filter_button_dom = <button onClick={(e) => {this.onClickFilterPopup(e)}} className={'filter_box'}>
                            {contentsFilterText}
                            <img style={{width: 16, height: 16}} src={ic_dropdown} />
                          </button>
    }else if(this.state.menu === MENU_CREATOR){
      select_sort_text = this.state.select_creator_sort_text;

      menuCreatorStyle = {
        color: '#00bfff'
      }

      menuCreatorUnderBarStyle = {
        display: 'block'
      }

      contentsListDom = <div>
                          <Category_Creator_List 
                            isMore={true}
                            category_top_id={this.state.category_top_item_id}
                            category_sub_ids={this.state.category_sub_select_list.concat()}
                            creator_sort_select_type={this.state.creator_sort_select_type}
                            ETC_LISTS={ETC_LISTS}
                          >
                          </Category_Creator_List>
                        </div>
    }

    let filterPopupDom = <></>;
    if(this.state.is_filter_popup){
      filterPopupDom = <Popup_category_filter 
                          selectedList={this.state.contents_filter_selects.concat()}
                          closeCallback={() => {
                            this.setState({
                              is_filter_popup: false
                            })
                          }}
                          selectCallback={(list) => {
                            this.setState({
                              contents_filter_selects: list.concat()
                            }, () => {
                              this.setState({
                                is_filter_popup: false
                              })
                            })
                          }}
                        ></Popup_category_filter>
    }

    let sortPopupDom = <></>;
    if(this.state.is_sort_popup){
      let default_select_sort_type = '';
      if(this.state.menu === MENU_CONTENTS){
        default_select_sort_type = this.state.contents_sort_select_type
      }else{
        default_select_sort_type = this.state.creator_sort_select_type
      }
      sortPopupDom = <Popup_category_sort 
                        menu_type={this.state.menu} 
                        default_select_sort_type={default_select_sort_type}
                        closeCallback={() => {
                          this.setState({
                            is_sort_popup: false
                          })
                        }}
                        selectCallback={(select_sort_type, text) => {

                          if(this.state.menu === MENU_CONTENTS){
                            this.setState({
                              contents_sort_select_type: select_sort_type,
                              select_contents_sort_text: text
                            }, () => {
                              this.setState({
                                is_sort_popup: false
                              })
                            })
                          }else{
                            this.setState({
                              creator_sort_select_type: select_sort_type,
                              select_creator_sort_text: text
                            }, () => {
                              this.setState({
                                is_sort_popup: false
                              })
                            })
                          }                          
                        }}
                      ></Popup_category_sort>
    }

    let infoPopupDom = <></>;
    if(this.state.is_info_popup){
      infoPopupDom = <Popup_category_info 
                      closeCallback={() => {
                        this.setState({
                          is_info_popup: false
                        })
                      }}></Popup_category_info>
    }

    return (
      <div className={'App_Category'}>
        <div className={'allPageController'}>
          <div className={'category_page_label_box'}>
            <div className={'category_page_label_text'}>
              카테고리
            </div>
            <button onClick={(e) => {this.onClickInfoPopup(e)}}>
              <img className={'category_page_info_img'} src={ic_category_info} />
            </button>
          </div>
        </div>
        <div className={'category_top_carousel_box'}>
          <Category_Top_Carousel category_top_item_id={this.state.category_top_item_id}></Category_Top_Carousel>
        </div>
        <div className={'allPageController'}>
          <div className={'category_sub_title_container'}>
            <div className={'category_sub_title_text'}>
              {sub_category_title_text}
            </div>
            <button onClick={(e) => {this.onClickSubReset(e)}} className={'category_sub_reset_box'}>
              <img src={ic_refresh} />
              <div>
                선택 초기화
              </div>
            </button>
          </div>
        </div>

        <div className={'category_sub_list_box'}>
          <div className={'viewport'}>
            <div className={'scrollable-content'} style={{display: 'flex', flexDirection: 'row',}}>
              {sub_category_list_dom}
            </div>
          </div>
        </div>

        <div className={'allPageController'}>
          <div className={'menu_button_container'}>
            <button style={menuContentsStyle} onClick={(e) => {this.onClickMenuContents(e)}} className={'menu_button_contents'}>
              콘텐츠
            </button>
            <button style={menuCreatorStyle} onClick={(e) => {this.onClickMenuCreator(e)}} className={'menu_button_creator'}>
              크리에이터
            </button>
          </div>
          <div className={'menu_under_bar'}>
            <div style={menuContentsUnderBarStyle} className={'menu_under_bar_contents_select'}>
            </div>
            <div style={menuCreatorUnderBarStyle} className={'menu_under_bar_creator_select'}>
            </div>
          </div>

          <div className={'filter_container'}>
            {filter_button_dom}
            <button onClick={(e) => {this.onClickSortPopup(e)}} className={'sort_box'}>
              {select_sort_text}
              <img style={{width: 16, height: 16}} src={ic_dropdown} />
            </button>
          </div>
          {contentsListDom}
        </div>

        {filterPopupDom}
        {sortPopupDom}
        {infoPopupDom}
      </div>
    );
  }
}

let domContainer = document.querySelector('#react_app_category_page');
ReactDOM.render(<App_Category />, domContainer);