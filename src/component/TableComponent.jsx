'use strict';

import React, { Component } from 'react';
import Types from '../Types';
import Util from '../lib/Util';

import InfiniteScroll from 'react-infinite-scroll-component';

class TableComponent extends Component{
  columnRefs = [];

  constructor(props){
    super(props);

    // let columnsDom = [];
    let _sortDatas = [];
    for(let i = 0 ; i < this.props.columns.length ; i++){
      const data = this.props.columns[i];

      let refDatas = {
        key: i,
        field: data.field,
        ref: React.createRef()
      }

      // const objectDom = <div key={i} ref={(ref) => {refDatas.ref = ref;}} className={'column_title_box'}>
      //                     <div className={'column_title'}>
      //                       {data.title}
      //                     </div>
      //                   </div>;
      
      if(data.isSort !== undefined && data.isSort){
        //솔트 기능이 있는 컬럼
        //컬럼의 데이터별로 넣는다.
        const sortData = {
          field: data.field,
          select_type: '0',
          types: []
        }

        _sortDatas.push(sortData);
      }

      this.columnRefs.push(refDatas);
      // columnsDom.push(objectDom);
    }

    this.state = {
      // columnsDom: columnsDom.concat(),
      widthDatas: [],

      sortDatas: _sortDatas.concat(),

      datas: []
    }
  };

  componentDidMount(){
    let widthDatas = [];
    for(let i = 0 ; i < this.columnRefs.length ; i++){
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

  componentDidUpdate(prevProps, prevState){

    if(prevProps.datas.length !== this.props.datas.length){
      //sort 데이터 셋팅
      let _sortDatas = this.state.sortDatas.concat();

      for(let i = 0 ; i < _sortDatas.length ; i++){
        const sortData = _sortDatas[i];
        for(let j = 0 ; j < this.props.datas.length ; j++){
          const data = this.props.datas[j];

          const valueData = data[sortData.field];
          if(valueData === undefined){
            continue;
          }

          const sortTypeData = sortData.types.find((value) => {return value === valueData});
          if(sortTypeData === undefined){
            //데이터가 없다.
            _sortDatas[i].types.push(valueData);
          }
        }
      }

      this.setState({
        sortDatas: _sortDatas.concat(),
        // datas: this.props.datas.concat()
      }, () => {
        this.setDataSort();
      })

      //sortType start
      // const sortDataIndex = _sortDatas.findIndex((value) => {return value.field === columnData.field});
      // if(sortDataIndex >= 0){
      //   //sortType 임
      //   const sortData = _sortDatas[sortDataIndex];
      //   const sortTypeData = sortData.types.find((value) => {return value === valueData});
      //   if(sortTypeData === undefined){
      //     //데이터가 없다.
      //     _sortDatas[sortDataIndex].types.push(valueData);
      //   }
      // }

      // //sortType end
      // console.log(prevProps.datas);
      // console.log(this.props.datas);
      // console.log('----------------')
    }

    /*
    if(prevProps.datas.length !== this.props.datas.length){
      //sort 데이터 셋팅
      let _sortDatas = this.state.sortDatas.concat();


      //sortType start
      const sortDataIndex = _sortDatas.findIndex((value) => {return value.field === columnData.field});
      if(sortDataIndex >= 0){
        //sortType 임
        const sortData = _sortDatas[sortDataIndex];
        const sortTypeData = sortData.types.find((value) => {return value === valueData});
        if(sortTypeData === undefined){
          //데이터가 없다.
          _sortDatas[sortDataIndex].types.push(valueData);
        }
      }

      //sortType end
      console.log(prevProps.datas);
      console.log(this.props.datas);
      console.log('----------------')
    }
    */
  }

  setDataSort = () => {
    
    // let _datas = this.props.datas.concat();

    let _datas = [];

    for(let i = 0 ; i < this.props.datas.length ; i++){
      const data = this.props.datas[i];

      // let isPushData = true;
      let isPushDatas = [];
      for(let j = 0 ; j < this.state.sortDatas.length ; j++){
        const sortData = this.state.sortDatas[j];

        const sortFieldValue = data[sortData.field];
        if(sortFieldValue === undefined){
          continue;
        }

        let isPushData = true;
        if(sortData.select_type !== '0'){
          isPushData = false;

          if(sortFieldValue === sortData.select_type){
            isPushData = true;
          }
        }

        isPushDatas.push(isPushData);
      }
      
      if(isPushDatas.length === 0){
        _datas.push(data);
      }else{
        const isPushFalse = isPushDatas.find((value) => {return value === false});
        if(isPushFalse === undefined){
          _datas.push(data);
        }
        
      }
      
    }

    this.setState({
      datas: _datas.concat()
    })
  }

  componentWillUnmount(){
    
  };

  onChangeSelect = (e, field) => {
    e.preventDefault();

    let _sortDatas = this.state.sortDatas.concat();
    const sortDataIndex = _sortDatas.findIndex((value) => {return value.field === field});
    if(sortDataIndex < 0){
      return;
    }

    _sortDatas[sortDataIndex].select_type = e.target.value;

    this.setState({
      sortDatas: _sortDatas.concat()
    }, () => {
      this.setDataSort();
    })
  }
  
  render(){

    //상단 셋팅 start
    let _sortDatas = this.state.sortDatas.concat();
    let columnsDoms = [];
    for(let i = 0 ; i < this.props.columns.length ; i++){
      const data = this.props.columns[i];

      // console.log(data);
      // let refDatas = {
      //   key: i,
      //   field: data.field,
      //   ref: React.createRef()
      // }

      const columnRefIndex = this.columnRefs.findIndex((value) => {return value.field === data.field});
      if(columnRefIndex < 0){
        continue;
      }

      let isSortType = false;
      const sortData = _sortDatas.find((value) => {return value.field === data.field});
      if(sortData !== undefined){
        isSortType = true;
      }

      let selectDom = <></>;
      let sortMarkDom = <></>;
      if(isSortType){

        let options = [];
        options.push(<option key={0} value={0}>{'모두보기'}</option>);

        for(let j = 0 ; j < sortData.types.length ; j++){
          const sortValue = sortData.types[j];
          const optionDom = <option key={j+1} value={sortValue}>{sortValue}</option>;
          options.push(optionDom);
        }
        selectDom = <select className={'select_tag'} value={sortData.select_type} onChange={(e) => {this.onChangeSelect(e, data.field)}}>
                      {options}
                    </select>;

        sortMarkDom = <div className={'sort_mark'}>
                      </div>
      }

      const objectDom = <div key={i} ref={(ref) => {this.columnRefs[columnRefIndex].ref = ref;}} className={'column_title_box'}>
                          <div className={'column_title'}>
                            {data.title}
                            {sortMarkDom}
                          </div>
                          {selectDom}
                        </div>;
      
      columnsDoms.push(objectDom);
    }
    //상단 셋팅 end

    let rowLineDoms = [];
    let infiniteDoms = <></>;
    let total_line_dom = <></>;
    if(this.props.isInfinite){

      infiniteDoms = <InfiniteScroll
                      // dataLength={this.props.datas.length} //This is important field to render the next data
                      dataLength={this.props.datas.length} //This is important field to render the next data
                      next={() => {this.props.requestMoreDataCallback()}}
                      hasMore={this.props.hasMore}
                      loader=
                      {
                        <div style={{display: 'flex', justifyContent: 'center'}}>
                          <h4>Loading...</h4>
                        </div>
                      }
                      endMessage={
                        <></>
                      }
                      // below props only if you need pull down functionality
                      // refreshFunction={this.refresh}
                      // pullDownToRefresh
                      pullDownToRefreshThreshold={50}
                      pullDownToRefreshContent={
                        <></>
                      }
                      releaseToRefreshContent={
                        <></>
                      }
                    >
                      {/* {this.props.datas.map((_data) => { */}
                      {this.state.datas.map((_data) => {

                        const data = _data;
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

                        // if(i === this.props.datas.length - 1){
                        //   underLineDom = <></>;
                        // }

                        // if(this.props.hasMore){
                        //   underLineDom = <></>;
                        // }

                        return <div key={data.id} className={'row_line_container'}> 
                                  <div className={'row_line_box'}>
                                    {rowDoms}
                                  </div>
                                  {underLineDom}
                                </div>
                      })}
                    </InfiniteScroll>
    }
    else{
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
    }
    
    
    return(
      <div className={'TableComponent'}>
        <div className={'column_container'}>
          {/* {this.state.columnsDom} */}
          {columnsDoms}
        </div>
        {infiniteDoms}
        {rowLineDoms}
        {total_line_dom}
      </div>
    )
  }
};

TableComponent.defaultProps = {
  table_type: Types.table_type.none,
  //무한에 필요한 데이터 start
  isInfinite: false,
  hasMore: false,
  requestMoreDataCallback: () => {},
  ///////////무한에 필요한 데이터 end

  columns: [],
  datas: []
}

// export default connect(mapStateToProps, mapDispatchToProps)(StoreItemDetailPage);
export default TableComponent;

/*
'use strict';

import React, { Component } from 'react';
import Types from '../Types';
import Util from '../lib/Util';

import InfiniteScroll from 'react-infinite-scroll-component';

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
      widthDatas: [],

      sortData: [],
    }
  };

  componentDidMount(){
    let widthDatas = [];
    for(let i = 0 ; i < this.columnRefs.length ; i++){
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
    let infiniteDoms = <></>;
    let total_line_dom = <></>;
    if(this.props.isInfinite){
      // console.log(this.props.datas);
      infiniteDoms = <InfiniteScroll
                      dataLength={this.props.datas.length} //This is important field to render the next data
                      next={() => {this.props.requestMoreDataCallback()}}
                      hasMore={this.props.hasMore}
                      loader=
                      {
                        <div style={{display: 'flex', justifyContent: 'center'}}>
                          <h4>Loading...</h4>
                        </div>
                      }
                      endMessage={
                        <></>
                      }
                      // below props only if you need pull down functionality
                      // refreshFunction={this.refresh}
                      // pullDownToRefresh
                      pullDownToRefreshThreshold={50}
                      pullDownToRefreshContent={
                        <></>
                      }
                      releaseToRefreshContent={
                        <></>
                      }
                    >
                      {this.props.datas.map((_data) => {
                      
                        const data = _data;
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

                        // if(i === this.props.datas.length - 1){
                        //   underLineDom = <></>;
                        // }

                        // if(this.props.hasMore){
                        //   underLineDom = <></>;
                        // }

                        return <div key={data.id} className={'row_line_container'}> 
                                  <div className={'row_line_box'}>
                                    {rowDoms}
                                  </div>
                                  {underLineDom}
                                </div>
                      })}
                    </InfiniteScroll>
    }
    else{
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
    }
    
    
    return(
      <div className={'TableComponent'}>
        <div className={'column_container'}>
          {this.state.columnsDom}
        </div>
        {infiniteDoms}
        {rowLineDoms}
        {total_line_dom}
      </div>
    )
  }
};

TableComponent.defaultProps = {
  table_type: Types.table_type.none,
  //무한에 필요한 데이터 start
  isInfinite: false,
  hasMore: false,
  requestMoreDataCallback: () => {},
  ///////////무한에 필요한 데이터 end

  columns: [],
  datas: []
}

// export default connect(mapStateToProps, mapDispatchToProps)(StoreItemDetailPage);
export default TableComponent;
*/