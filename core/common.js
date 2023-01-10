/*
* Common JS scripts
*/

function gEBI( objId ){
  return document.getElementById( objId );
}

function createCookie( sName, sValue, iDays ){
  sValue = escape( sValue );
  if( iDays ){
    var oDate = new Date();
    oDate.setTime( oDate.getTime() + ( iDays*24*60*60*1000 ) );
    var sExpires = "; expires="+oDate.toGMTString();
  }
  else
    var sExpires = "";
  document.cookie = sName+"="+sValue+sExpires+"; path=/";
}

function throwCookie( sName ){
  var sNameEQ = sName + "=";
  var aCookies = document.cookie.split( ';' );
  for( var i=0; i < aCookies.length; i++ ){
    var c = aCookies[i];
    while( c.charAt(0) == ' ' )
      c = c.substring( 1, c.length );
    if( c.indexOf( sNameEQ ) == 0 )
      return unescape( c.substring( sNameEQ.length, c.length ) );
  }
  return null;
}

function delCookie( sName ){
  createCookie( sName, "", -1 );
}

function isset( sVar ){
  return( typeof( window[sVar] ) != 'undefined' );
}

_bUa=navigator.userAgent.toLowerCase();
_bOp=(_bUa.indexOf("opera")!=-1?true:false);
_bIe=(_bUa.indexOf("msie")!=-1&&!_bOp?true:false);
_bIe4=(_bIe&&(_bUa.indexOf("msie 2.")!=-1||_bUa.indexOf("msie 3.")!=-1||_bUa.indexOf("msie 4.")!=-1)&&!_bOp?true:false)
isIe=function(){return _bIe;}
isOldIe=function(){return _bIe4;}
var olArray=[];

function AddOnload( f ){
  if( isIe() && isOldIe() ){
    window.onload = ReadOnload;
    olArray[olArray.length] = f;
  }
  else if( window.onload ){
    if( window.onload != ReadOnload ){
      olArray[0] = window.onload;
      window.onload = ReadOnload;
    }
    olArray[olArray.length] = f;
  }
  else
    window.onload=f;
}
function ReadOnload(){
  for( var i=0; i < olArray.length; i++ ){
    olArray[i]();
  }
}

/* PLUGINS */
    function backToTop(){
      $('#backToTop').hide();
      $(window).scroll( function(){
        if( $(this).scrollTop() > 100 )
          $('#backToTop').fadeIn();
        else
          $('#backToTop').fadeOut();
      } );
      $('#backToTop a').click( function(){
        $('body,html').animate( {scrollTop:0}, 600 );
        return false;
      } );
    }

    var aPosition = Array( null, 0, 0 );
    var aMaxLeft = Array( );
    var aStep = Array( null, 200, 200 );
    function imagesSlider( event ){
      iId = event.data.iId;
      iMinus = event.data.iMinus;
      iStep = aStep[iId];
      aPosition[iId] = aPosition[iId] + ( iStep * iMinus );
      if( aPosition[iId] < aMaxLeft[iId] )
        aPosition[iId] = aMaxLeft[iId];
      if( aPosition[iId] > 0 )
        aPosition[iId] = 0;
      $('#imagesList'+iId+" ul").animate( {"left": aPosition[iId]+"px"}, 1000 );
      return false;
    }

    function imagesSliderInit( ){
      for( var i = 1; i < 3; i++ ){
        var sId = "#imagesList"+i;
        if( $(".imagesListSlider"+sId+" .slider").length > 0 ){
          var iMaxLiWidth = 0;
          $.each( $(sId+" .slider ul li"), function(index,value){
            if( iMaxLiWidth < $(this).outerWidth(true) )
              iMaxLiWidth = $(this).outerWidth(true)
          });
          var iSliderWidth = $(sId+" .slider ul li").length * iMaxLiWidth;
          aStep[i] = iMaxLiWidth;
          $(sId).css( "width", iMaxLiWidth+'px' );
          $(sId+" .slider ul li").css( "width", iMaxLiWidth+'px' );
          var iSliderPlace = $(sId+" .slider").innerWidth();
          $(sId+" ul").css( 'width', iSliderWidth );
          aMaxLeft[i] = iSliderPlace - iSliderWidth;
          $(sId+" .nav.left").on( "click", "a", {iId:i,iMinus:1}, imagesSlider );
          $(sId+" .nav.right").on( "click", "a", {iId:i,iMinus:-1}, imagesSlider );
        }
      }
    }