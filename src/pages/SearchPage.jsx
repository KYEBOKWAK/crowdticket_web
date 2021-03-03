'use strict';

import React, { Component } from 'react';

import ic_search from '../res/img/ic-search.svg';
import ic_exit from '../res/img/ic-close.svg';
import ic_clear from '../res/img/btn-app-clear.svg';

import ic_trash from '../res/img/ic-trash.svg';
// import axios from '../lib/Axios';

import Storage from '../lib/Storage';
import * as storageType from  '../StorageKeys';

const MAX_SAVE_TEXT_COUNT = 5;
class SearchPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      search_text: '',

      is_clear_button: false,

      save_search_text: []
      // isSaveText: true
    }
  };

  componentDidMount(){
    ScrollLock();

    this.loadSearchText();
  };

  componentWillUnmount(){
    ScrollUnLock();
  };

  componentDidUpdate(){
  }

  loadSearchText = () => {
    Storage.load(storageType.SEARCH_TEXTS, (result) => {
      if(result.value){
        let _save_search_text = [];
        let saveText = result.value;
        _save_search_text = saveText.split(",");

        this.setState({
          save_search_text: _save_search_text
        })
      }else{
        //값이 없음
      }        
    })
  }

  onChangeInput = (e) => {
    e.preventDefault();

    let isClearButton = false;
    if(e.target.value !== ''){
      isClearButton = true;
    }

    // console.log(e.target.value);
    this.setState({
      search_text: e.target.value,
      is_clear_button: isClearButton
    })
    
  }

  onClickExit = (e) => {
    e.preventDefault();

    this.props.closeCallback();
  }

  onClickClear = (e) => {
    e.preventDefault();

    this.setState({
      search_text: '',
      is_clear_button: false
    })
  }

  requestSearch = () => {
    let _save_search_text = this.state.save_search_text.concat();

    const findSearchTextIndex = this.state.save_search_text.findIndex((value) => {return value === this.state.search_text});

    if(findSearchTextIndex < 0){
      _save_search_text.push(this.state.search_text);
    }else{
      _save_search_text.splice(findSearchTextIndex, 1);
      _save_search_text.push(this.state.search_text);
    }

    if(_save_search_text.length > MAX_SAVE_TEXT_COUNT) {
      //5개 이상이면 이전꺼부터 삭제
      _save_search_text.splice(0, 1);
    }

    Storage.save(storageType.SEARCH_TEXTS, _save_search_text.toString(), (result) => {
      let baseURL = 'https://crowdticket.kr'
      const baseURLDom = document.querySelector('#base_url');
      if(baseURLDom){
        // console.log(baseURLDom.value);
        baseURL = baseURLDom.value;
      }
      
      let hrefURL = baseURL+'/search?search='+this.state.search_text;
      
      window.location.href = hrefURL;    
    });
  }

  handleKeyPress = (e) => {
    // if(e.charCode === 13) { //  deprecated
    //   this.handleClick();
    // }
    if (e.key === "Enter") {
      this.requestSearch();
    }
  };

  onClickSearchText = (e, text) => {
    e.preventDefault();

    let isClearButton = false;
    if(text !== ''){
      isClearButton = true;
    }

    this.setState({
      search_text: text,
      is_clear_button: isClearButton
    }, () => {
      this.requestSearch();
    })
  }

  onClickSaveClear = (e) => {
    e.preventDefault();

    Storage.delete(storageType.SEARCH_TEXTS, () => {
      this.setState({
        save_search_text: []
      })
    });
  }
  render(){
    let isClearButtonDom = <></>;
    if(this.state.is_clear_button){
      isClearButtonDom = <button onClick={(e) => {this.onClickClear(e)}}>
                          <img src={ic_clear} />
                        </button>
    }

    let searchList = [];
    let searchListDom = <></>;
    if(this.state.save_search_text.length > 0){
      for(let i = this.state.save_search_text.length - 1 ; i >= 0 ; i--){
        const data = this.state.save_search_text[i];

        const searchObjectDom = <div className={'save_search_list_text'} key={i}>
                                  <button onClick={(e) => {this.onClickSearchText(e, data)}}>
                                    {data}
                                  </button>
                                </div>

        searchList.push(searchObjectDom);
      }

      searchListDom = <div className={'SearchPage_container'}>
                        <div className={'save_search_label_container'}>
                          <div className={'save_search_label'}>
                            최근 검색어
                          </div>

                          <button onClick={(e) => {this.onClickSaveClear(e)}} className={'save_search_clear_container'}>
                            <img src={ic_trash} />
                            <div>
                              전체 삭제
                            </div>
                          </button>
                        </div>
                        <div className={'save_search_list_container'}>
                          {searchList}
                        </div>
                      </div>
    }
    return(
      <div className={'SearchPage'}>
        <div className={'SearchPage_container'}>
          <div className={'search_input_box'}>
            <div className={'search_input_box_first'}>
              <img className={'ic_search_img'} src={ic_search} />

              <div className={'input_box_container'}>
                <input 
                className={'input_box'} 
                type="search" 
                name={'search_creator'} 
                placeholder={'찾고 계신 크리에이터 또는 콘텐츠가 있나요?'} 
                value={this.state.search_text}
                onKeyPress={(e) => {this.handleKeyPress(e)}}
                onChange={(e) => {this.onChangeInput(e)}}/>

                {isClearButtonDom}
              </div>
            </div>
            <button onClick={(e) => {this.onClickExit(e)}}>
              <img src={ic_exit} />
            </button>
          </div>
        </div>

        <div className={'under_line'}>
        </div>

        {searchListDom}
      </div>
    )
  }
};

export default SearchPage;