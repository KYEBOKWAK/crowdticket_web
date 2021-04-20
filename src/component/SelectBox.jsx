'use strict';

import React, { Component } from 'react';

import ic_dropdown from '../res/img/ic-dropdown.svg';

class SelectBox extends Component{

  constructor(props){
    super(props);

    let default_value = this.props.default_value;
    if(default_value === undefined || default_value === null || default_value === ''){
      default_value = '-1';
    }

    let option_list = [];

    if(!this.props.null_show_value_set_last){
      const nullOptionObject = <option key={'-1'} value={'-1'}>
                              {this.props.null_show_value}
                              </option>
      option_list.push(nullOptionObject);
    }
    

    for(let i = 0 ; i < this.props.list.length ; i++){
      const data = this.props.list[i];

      const dataValue = String(data.value);

      const optionObject = <option key={dataValue} value={dataValue}>
                              {data.show_value}
                            </option>

      option_list.push(optionObject);
    }

    if(this.props.null_show_value_set_last){
      const nullOptionObject = <option key={'-1'} value={'-1'}>
                              {this.props.null_show_value}
                              </option>
      option_list.push(nullOptionObject);
    }

    this.state = {
      select_value: default_value,
      show_select_value: this.getListShowValue(default_value),
      option_list: option_list.concat()
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  onChangeSelect = (e) => {
    const selectValue = e.target.value;

    this.setState({
      select_value: selectValue,
      show_select_value: this.getListShowValue(selectValue),
    }, () => {
      this.props.callbackChangeSelect(this.getChangeSelect());
    })
  }

  getChangeSelect = () => {
    let select_value = this.state.select_value;
    if(select_value === '-1'){
      return null;
    }

    return select_value;
  }

  getListShowValue = (_value) => {
    const data = this.props.list.find((value) => {
                    const stringValue = String(value.value);
                    if(stringValue === _value){
                      return value;
                    }
                  })

    if(data === undefined){
      return this.props.null_show_value;
    }

    return data.show_value;
  }



  render(){

    return(
      <div className={'SelectBox'}>
        {this.state.show_select_value}
        <img src={ic_dropdown} />

        <select className={'selectBox_select'} value={this.state.select_value} onChange={(e) => {this.onChangeSelect(e)}}>
          {this.state.option_list}
        </select>
      </div>
    )
  }
};


/*
list data = [
  {
  value: 'a',
  show_value: '보여질메뉴'
  }
]
*/
SelectBox.defaultProps = {
  list: [],
  default_value: null,
  null_show_value: '',
  null_show_value_set_last: false
}

export default SelectBox;