import language from '../res/json/language/language.json';

const StrLib = {
  getStr: (strKey, language_code) => {
     const stringKey = strKey;
     let text = stringKey;

     if(stringKey === ''){
      text = '##EMPTY##';
     }
     else if(language[stringKey] === undefined){
      text = stringKey;
     }else if(language[stringKey][language_code] === undefined || language[stringKey][language_code] === null){
      text = stringKey;
     }else{
      text = language[stringKey][language_code];
     }

    //  return text;
     return text+'('+strKey+')';
  }
}

export default StrLib;