'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';
import Types from '../Types';

// import ScrollArea from 'react-scrollbar';
// import {Scrollbar} from 'smooth-scrollbar-react';

const CATEGORY_DEFAULT_VALUE = 1;
const CATEGORY_DOWNLOAD_DEFAULT_VALUE = 7;
class Category_Selecter extends Component{

  constructor(props){
    super(props);

    this.state = {
      select_top_id: null,
      select_sub_id: null,
      category_top_list: [],
      category_sub_list: [],

      isInitInfo: false,

      explain_list: [
        {
          select_top_id: 1,
          value: '만들어드려요란? 크리에이터의 주요 콘텐츠를 팬의 요청에 따라 만들어주는 콘텐츠상품입니다.'
        },
        {
          select_top_id: 2,
          value: '소통해요란? 크리에이터와 소통하고 싶은 팬들을 위한 콘텐츠상품입니다.'
        },
        {
          select_top_id: 3,
          value: '알려드려요란? 강의/피드백/추천 등 크리에이터에게 정보를 전달받는 콘텐츠상품입니다.'
        },
        {
          select_top_id: 4,
          value: '같이 해요란? 크리에이터의 콘텐츠에 참여하고 싶은 팬들을 위한 콘텐츠상품입니다.'
        },
        {
          select_top_id: 5,
          value: '만나요란? 크리에이터가 오프라인에서 팬과 직접 만나서 진행하는 콘텐츠상품입니다.'
        },
        {
          select_top_id: 6,
          value: '홍보해드려요란? 크리에이터와 비즈니스를 하고 싶은 분들을 위한 콘텐츠상품입니다.'
        }
      ]
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestTopCategoryList();
  };

  componentDidUpdate(prevProps, prevState){
    if(prevProps.default_category_sub_id !== this.props.default_category_sub_id){
      if(!this.state.isInitInfo){
        this.setState({
          isInitInfo: true
        }, () => {
          this.getCategoryInfo();
        })
      }
    }

    if(prevProps.item_type_contents !== this.props.item_type_contents){
      this.setDefaultTopCategory();
    }
    // if(prevState.select_top_id !== this.state.select_top_id){
    //   this.requsetSubCategoryList(); 
    // }
  }

  requestTopCategoryList = () => {
    axios.post("/category/any/top/list", {}, 
    (result) => {
      this.setState({
        category_top_list: result.list.concat()
      }, () => {
        // if(this.props.default_category_sub_id === null){
          this.setDefaultTopCategory();
        // }else{
          // this.getCategoryInfo();
        // }
        
      })
    }, (error) => {

    })
  }

  getCategoryInfo = () => {
    axios.post("/category/any/get/info", {
      category_sub_item_id: this.props.default_category_sub_id
    }, (result) => {
      this.setState({
        select_top_id: result.data.category_top_id,
        select_sub_id: result.data.category_sub_id
      }, () => {
        this.requsetSubCategoryList();
      })
    }, (error) => {

    })
  }

  setDefaultTopCategory = () => {

    let default_top_id = CATEGORY_DEFAULT_VALUE
    if(this.props.item_type_contents === Types.contents.completed){
      default_top_id = CATEGORY_DOWNLOAD_DEFAULT_VALUE;
    }
    
    this.setState({
      select_top_id: default_top_id,
    }, () => {
      this.setSubCategory(null);
      this.requsetSubCategoryList();
    })
  }

  requsetSubCategoryList = () => {
    if(this.state.select_top_id === null){
      return;
    }

    axios.post("/category/any/sub/list", {
      category_top_id: this.state.select_top_id
    }, (result) => {
      this.setState({
        category_sub_list: result.list.concat()
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){
    
  };

  onClickTopCategory = (e, select_category_top_id) => {
    e.preventDefault();

    this.setState({
      select_top_id: select_category_top_id,
    }, () => {
      this.setSubCategory(null);
      this.requsetSubCategoryList();
    })
  }

  onClickSubCategory = (e, select_category_sub_id) => {
    e.preventDefault();

    this.setSubCategory(select_category_sub_id);
  }

  setSubCategory = (select_category_sub_id) => {
    this.setState({
      select_sub_id: select_category_sub_id
    }, () => {
      this.props.callback_select(this.state.select_top_id, this.state.select_sub_id);
    })
  }

  render(){

    let category_top_list_dom = [];
    for(let i = 0 ; i < this.state.category_top_list.length ; i++){
      const data = this.state.category_top_list[i];

      if(data.contents_type !== this.props.item_type_contents){
        continue;
      }

      let selectStyle = {}
      if(this.state.select_top_id === data.id){
        selectStyle = {
          backgroundColor: '#f7f7f7'
        }
      }

      const categoryItemDom = <button key={i} style={selectStyle} onClick={(e) => {this.onClickTopCategory(e, data.id)}} className={'category_list_item'}>
                                {data.title}
                              </button>

      category_top_list_dom.push(categoryItemDom);
    }

    let category_sub_list_dom = [];
    for(let i = 0 ; i < this.state.category_sub_list.length ; i++){
      const data = this.state.category_sub_list[i];

      let selectStyle = {}
      if(this.state.select_sub_id === data.id){
        selectStyle = {
          backgroundColor: '#f7f7f7'
        }
      }

      const categoryItemDom = <button key={i} style={selectStyle} onClick={(e) => {this.onClickSubCategory(e, data.id)}} className={'category_list_item'}>
                                {data.title}
                              </button>

      category_sub_list_dom.push(categoryItemDom);
    }

    let explain_text = '';
    const explainData = this.state.explain_list.find((value) => {
      if(value.select_top_id === this.state.select_top_id){
        return value;
      }
    })

    if(explainData !== undefined){
      explain_text = explainData.value;
    }
    return(
      <div className={'Category_Selecter'}>
        <div className={'category_top_list_box_container'}>
          <div className={'scroll_box category_top_list_box'}>
            {category_top_list_dom}
          </div>

          <div style={{width: 8}}>
          </div>

          <div className={'scroll_box category_sub_list_box'}>
            {category_sub_list_dom}
          </div>
        </div>
        <div className={'category_explain_text'}>
          {explain_text}
        </div>
      </div>
    )
  }
};

Category_Selecter.defaultProps = {
  default_category_sub_id: null,
  callback_select: (category_sub_id) => {}
}

export default Category_Selecter;