'use strict';

import React, { Component } from 'react';
import Types from '../Types';
import Util from '../lib/Util';


// import { scale, verticalScale, moderateScale } from 'react-native-size-matters';
// import FontWeights from '@lib/fontWeights';

// import * as appKeys from '~/AppKeys';
// import Util from '@lib/Util';
// import * as GlobalKeys from '~/GlobalKeys';

//redux START
// import * as actions from '@actions/index';
// import { connect } from 'react-redux';
//redux END
// import Colors from '@lib/colors';
// import Types from '~/Types';



class TableComponent extends Component{
  columnRefs = [];

  constructor(props){
    super(props);

    let columnsDom = [];

    for(let i = 0 ; i < this.props.columns.length ; i++){
      const data = this.props.columns[i];
    
      let refDatas = {
        key: i,
        field: data.field,
        ref: React.createRef()
      }

      const objectDom = <div key={i} ref={(ref) => {refDatas.ref = ref;}} className={'column_title_box'}>
                          <div className={'column_title'}>
                            {data.title}
                          </div>
                        </div>

      this.columnRefs.push(refDatas);
      columnsDom.push(objectDom);
    }

    this.state = {
      columnsDom: columnsDom.concat(),
      widthDatas: []
    }
  };

  componentDidMount(){
    let widthDatas = [];
    for(let i = 0 ; i < this.columnRefs.length ; i++){
      // console.log(this.columnRefs[i].ref);
      // console.log(this.columnRefs[i].ref.clientWidth);
      const data = this.columnRefs[i];

      const widthData = {
        key: i,
        field: data.field,
        width: data.ref.clientWidth
      }

      widthDatas.push(widthData);
    }

    this.setState({
      widthDatas: widthDatas.concat()
    })
  };

  componentWillUnmount(){
    
  };

  render(){
    let rowLineDoms = [];

    let isBottomCalc = false;
    for(let i = 0 ; i < this.props.datas.length ; i++){
      const data = this.props.datas[i];
      let rowDoms = [];
      for(let j = 0 ; j < this.props.columns.length ; j++){
        const columnData = this.props.columns[j];
        
        if(columnData.bottomCalc !== undefined && columnData.bottomCalc !== ''){
          isBottomCalc = true;
        }

        let _width = '100%';
        if(this.state.widthDatas.length > 0){
          _width = this.state.widthDatas[j].width;
        }

        let ellipsizeOption = ''
        if(columnData.ellipsize){
          ellipsizeOption = 'text-ellipsize';
        }

        //type 셋팅
        const valueData = data[columnData.field];
        let value = valueData;
        if(valueData === undefined){
          value = '';
        }else{
          if(columnData.type === Types.table_columns_type.price){
            value = Util.getNumberWithCommas(valueData) + '원';
          }
        }
        
        const rowDom = <div key={j} className={'row_value '+ellipsizeOption} style={{width: _width}}>
                        {value}
                      </div>

        rowDoms.push(rowDom);
      }

      let underLineDom = <div className={'row_under_line'}></div>;

      if(i === this.props.datas.length - 1){
        underLineDom = <></>;
      }
      const rowLineDom =  <div key={i} className={'row_line_container'}> 
                            <div className={'row_line_box'}>
                              {rowDoms}
                            </div>
                            {underLineDom}
                          </div>

      rowLineDoms.push(rowLineDom)
    }


    let total_line_dom = <></>;
    if(isBottomCalc){
      //해당 타입은 하단에 총합계가 나온다.
      let rowDoms = [];
      for(let i = 0 ; i < this.props.columns.length ; i++){
        const columnData = this.props.columns[i];
        let _width = '100%';
        if(this.state.widthDatas.length > 0){
          _width = this.state.widthDatas[i].width;
        }

        //type 셋팅
        let value = '';
        if(columnData.bottomCalc === 'sum'){
          //총 합을 찾는다.
          let bottom_value = 0;
          for(let j = 0 ; j < this.props.datas.length ; j++){
            const rowData = this.props.datas[j];
            const valueData = rowData[columnData.field];
            if(valueData === undefined){
              continue;
            }

            bottom_value += valueData;
          }

          // console.log(bottom_value);
          value = Util.getNumberWithCommas(bottom_value) + '원';

        }else{
          value = '';
        }

        //table_type === total_payment 인 경우에는 총합계가 나와야 한다.
        if(this.props.table_type === Types.table_type.total_payment){
          if(i === 1){
            value = '총 ' + this.props.datas.length + '건';
          }
        }
        
        const rowDom = <div key={i} className={'row_value row_bottom_value'} style={{width: _width}}>
                        {value}
                      </div>

        rowDoms.push(rowDom);
      }

      total_line_dom = <div className={'row_line_box row_line_bottom_box'}>
                          {rowDoms}
                        </div>
    }
    
    return(
      <div className={'TableComponent'}>
        <div className={'column_container'}>
          {this.state.columnsDom}
        </div>
        {rowLineDoms}
        {total_line_dom}
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

TableComponent.defaultProps = {
  table_type: Types.table_type.none,
  columns: [],
  datas: []
}

// export default connect(mapStateToProps, mapDispatchToProps)(StoreItemDetailPage);
export default TableComponent;