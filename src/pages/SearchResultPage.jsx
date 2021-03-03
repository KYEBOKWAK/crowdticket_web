'use strict';

import React, { Component } from 'react';

import Types from '../Types';
import Home_Thumb_list from '../component/Home_Thumb_list';
import Home_Thumb_Container_List from '../component/Home_Thumb_Container_List';

class SearchResultPage extends Component{

  constructor(props){
    super(props);

    let search_text = '';
    const search_result_dom = document.querySelector('#search_result');
    if(search_result_dom){
      search_text = search_result_dom.value
    }

    this.state = {
      search_text: search_text,
      // result_creators: [],
      result_stores_count: -1, //home_thumb_list 안에서 item을 호출한다.
      result_items_count: -1,
      result_projects_count: -1
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
  };

  // requestSearchResult = () => {

  // }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){

    let storesLists = <></>;
    if(this.state.result_stores_count === -1 || this.state.result_stores_count > 0){
      let label_dom = <></>;
      if(this.state.result_stores_count > 0){
        let countText = this.state.result_stores_count;
        if(countText < 10){
          countText = '0'+countText;
        }

        label_dom = <div className={'search_result_label_text_container'}>
                      <div className={'search_result_label_text'}>
                      크리에이터
                      </div>
                      <div className={'search_result_label_count'}>
                        {countText}
                      </div>
                    </div>
      }

      storesLists = <div className={'search_result_recommend_container'}>
                      {label_dom}
                      <Home_Thumb_list 
                        thumb_list_type={Types.thumb_list_type.find_result_stores} 
                        pc_show_item_count={6} 
                        search_text={this.state.search_text}
                        search_result_count_callback={(count) => {
                          this.setState({
                            result_stores_count: count
                          })
                        }}
                      >
                      </Home_Thumb_list>
                    </div>
    }

    let itemLists = <></>;
    if(this.state.result_items_count === -1 || this.state.result_items_count > 0){
      let label_dom = <></>;
      if(this.state.result_items_count > 0){
        let countText = this.state.result_items_count;
        if(countText < 10){
          countText = '0'+countText;
        }

        label_dom = <div className={'search_result_label_text_container'}>
                      <div className={'search_result_label_text'}>
                      콘텐츠
                      </div>
                      <div className={'search_result_label_count'}>
                        {countText}
                      </div>
                    </div>
      }

      itemLists = <div className={'search_result_container'}>
                    {label_dom}
                    <Home_Thumb_Container_List 
                      type={Types.thumb_list_type.find_result_items}
                      search_text={this.state.search_text}
                      isMore={true}
                      search_result_count_callback={(count) => {
                        this.setState({
                          result_items_count: count
                        })
                      }}
                    >
                    </Home_Thumb_Container_List>
                  </div>
    }

    let projectLists = <></>;
    if(this.state.result_projects_count === -1 || this.state.result_projects_count > 0){
      let label_dom = <></>;
      if(this.state.result_projects_count > 0){
        let countText = this.state.result_projects_count;
        if(countText < 10){
          countText = '0'+countText;
        }

        label_dom = <div className={'search_result_label_text_container'}>
                      <div className={'search_result_label_text'}>
                      팬 이벤트
                      </div>
                      <div className={'search_result_label_count'}>
                        {countText}
                      </div>
                    </div>
      }

      projectLists = <div className={'search_result_container'}>
                      {label_dom}
                      <Home_Thumb_Container_List 
                        type={Types.thumb_list_type.find_result_projects}
                        search_text={this.state.search_text}
                        isMore={true}
                        search_result_count_callback={(count) => {
                          this.setState({
                            result_projects_count: count
                          })
                        }}
                      >
                      </Home_Thumb_Container_List>
                    </div>
    }

    let noResultTextDom = <></>;
    let recommendDom = <></>;
    if(this.state.result_items_count === 0 && this.state.result_projects_count === 0 && this.state.result_stores_count === 0){
      noResultTextDom = <div className={'search_no_result'}>
                          검색 결과가 없습니다.
                        </div>;

      recommendDom = <div className={'search_result_recommend_container'} style={{marginBottom: 0}}>
                        <div className={'search_result_label_text_container'}>
                          <div className={'search_result_label_text'}>
                            이런 콘텐츠는 어떠세요?
                          </div>
                        </div>
                        <Home_Thumb_list 
                          thumb_list_type={Types.thumb_list_type.find_no_result_recommend} 
                          pc_show_item_count={4} 
                        >
                        </Home_Thumb_list>
                      </div>
    }

    return(
      <div className={'SearchResultPage'}>
        <div className={'search_result_page_container'}>
          <div className={'search_result_title'}>
            {`'${this.state.search_text}'에 대한 검색 결과`}
          </div>

          {noResultTextDom}
        </div>
        {storesLists}
        <div className={'search_result_page_container'}>
          {itemLists}
          {projectLists}
        </div>

        {recommendDom}
      </div>
    )
  }
};

export default SearchResultPage;