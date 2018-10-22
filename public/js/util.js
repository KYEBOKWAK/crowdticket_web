function addComma(num) {
  var regexp = /\B(?=(\d{3})+(?!\d))/g;
   return num.toString().replace(regexp, ',');
}

function isMobile(){
  return $('#isMobile').is(":visible");
};
